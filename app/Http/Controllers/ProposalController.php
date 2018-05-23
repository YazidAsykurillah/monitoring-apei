<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\ImportProposalRequest;

use App\User;
use App\Proposal;
use App\ProposalLog;

use Excel;
use Carbon\Carbon;
class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('status')){
            if($request->status == '1'){    //berkas lengkap
                return view('proposal.index_1');    
            }
            elseif($request->status == '2'){    //Berkas TIDAK Lengkap
                return view('proposal.index_2');    
            }
            elseif($request->status == '3'){    //Proses Online DJK
                return view('proposal.index_3');    
            }
            elseif($request->status == '9'){    //Sertifikat Sudah Terkirim
                return view('proposal.index_9');    
            }
            elseif($request->status == 'on_process'){    //Exclude of Berkas Lengkap, Berkas tidak lengkap, and Selesai
                return view('proposal.index_on_process');    
            }
            elseif($request->status == 'all'){    //Show all proposals
                return view('proposal.index');    
            }
            elseif($request->status == 'rekapitulasi'){    //Show rekapitulasi
                return view('proposal.rekapitulasi');    
            }
            else{
                return redirect('proposal')
                    ->with('errorMessage', "Proposal status is undefined");
            }
            
        }
        else{
            return view('proposal.index');    
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

      return view('proposal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalRequest $request)
    {
        $proposal = new Proposal;
        $proposal->user_id = $request->user_id;
        $proposal->type = $request->type;
        $proposal->jumlah_unit_kompetensi = abs($request->jumlah_unit_kompetensi);
        $proposal->notes = $request->notes;
        $proposal->save();
        $proposal_id = $proposal->id;
        //update proposal_code;
        $update_proposal_code = $this->update_proposal_code($proposal_id);

        //register proposal log
        $log = $this->register_proposal_create_mode($proposal_id);
        
        return redirect('proposal/'.$proposal_id)
            ->with('successMessage', 'Proposal has been saved');
    }

    protected function register_proposal_create_mode($proposal_id)
    {
        $log = new ProposalLog;
        $log->proposal_id = $proposal_id;
        $log->user_id = \Auth::user()->id;
        $log->mode = 'create';
        $log->save();
    }

    protected function update_proposal_code($proposal_id){
        $proposal = Proposal::findOrFail($proposal_id);
        $proposal->code = 'P-'.str_pad($proposal_id, 6, 0, STR_PAD_LEFT);
        $proposal->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal = Proposal::findOrFail($id);
        $status_opts = [
            '0'=>'Pengajuan diterima',
            '2'=>'Berkas Tidak Lengkap',
            '1'=>'Berkas Lengkap',
            '3'=>'Proses Online DJK',
            '4'=>'Terima Nomer Registrasi',
            '5'=>'Cetak Sertifikat',
            '6'=>'Penandatangan sertifikat',
            '7'=>'Scanning dan tanda terima',
            '8'=>'Sertifikat siap kirim',
            '9'=>'Sertifikat sudah terkirim',
            '10'=>'SELESAI'
        ];

        $proposal_files = \DB::table('proposal_files')->where('proposal_id', '=', $id)->get();
        if(count($proposal_files)){
            $proposal_file_check_lists = $proposal_files;
        }else{
            //register proposal_type_configuration
            $proposal_type_configurations = \DB::table('proposal_type_configurations')
            ->select('surat_permohonan', 'ktp', 'foto_3x4', 'ijazah', 'fotokopi_sk_a_t', 'surat_pernyataan', 'cv')
            ->where('type', '=', $proposal->type)
            ->get();
            $data = [];
            foreach($proposal_type_configurations as $val){
                if($val->surat_permohonan == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'surat_permohonan'] );
                }
                if($val->ktp == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'ktp'] );
                }
                if($val->foto_3x4 == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'foto_3x4'] );
                }
                if($val->ijazah == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'ijazah'] );
                }
                if($val->fotokopi_sk_a_t == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'fotokopi_sk_a_t'] );
                }
                if($val->surat_pernyataan == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'surat_pernyataan'] );
                }
                if($val->cv == TRUE){
                  array_push($data, ['proposal_id'=>$id, 'file'=>'cv'] );
                }
                
            }
            \DB::table('proposal_files')->insert($data);
            $proposal_file_check_lists =\DB::table('proposal_files')->where('proposal_id', '=', $id)->get();
        }

        return view('proposal.show')
            ->with('status_opts', $status_opts)
            ->with('proposal_file_check_lists', $proposal_file_check_lists)
            ->with('proposal', $proposal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('proposal.edit')
            ->with('proposal', $proposal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalRequest $request, $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->user_id = $request->user_id;
        $proposal->type = $request->type;
        $proposal->jumlah_unit_kompetensi = abs($request->jumlah_unit_kompetensi);
        $proposal->notes = $request->notes;
        $proposal->save();
        return redirect('proposal/'.$id)
            ->with('successMessage', 'Proposal has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $proposal = Proposal::findOrFail($request->proposal_id);
        $code = $proposal->code;
        $proposal->delete();
        return redirect('proposal')
            ->with('successMessage', "Proposal $code has been deleted");
    }


    public function changestatus(Request $request)
    {
        $proposal = Proposal::findOrFail($request->proposal_id);
        //get the old status
        $old_status = $proposal->status;

        $proposal->status = $request->status;
        $proposal->status_notes = $request->status_notes;
          //if request status is 2 = Berkas tidak lengkap, delete proposal file related to this proposal
          if($request->status == 2){
              \DB::table('proposal_files')->where('proposal_id', '=', $proposal->id)->delete();
          }

        //update the proposal
        $proposal->save();

            //Block save log
            $log = new ProposalLog;
            $log->proposal_id = $request->proposal_id;
            $log->user_id = \Auth::user()->id;
            $log->mode = 'change-status';
            $log->description = "From <strong>".proposal_status_display($old_status)."</strong> to <strong>".proposal_status_display($request->status)."</strong>";
            $log->save();
            //ENDBlock save log


          


        return redirect('proposal/'.$request->proposal_id)
            ->with('successMessage', "Proposal status has been changed");
    }


    public function fileCompletion(Request $request)
    {
      $proposal = Proposal::findOrFail($request->proposal_id_from_proposal_file);
      
      if($request->has('proposal_file_id')){
        //first set  all the proposal_Files related to proposal id to false
        \DB::table('proposal_files')->where('proposal_id', $proposal->id)->update(['status'=>false]);
        foreach($request->proposal_file_id as $id){
          \DB::table('proposal_files')->where('id','=',$id)->update(['status'=>true]);
        }
      }
      else{
        \DB::table('proposal_files')->where('proposal_id', $proposal->id)->update(['status'=>false]);
      }

      //compare proposal_file with proposal_files_configurations
      $true_files = \DB::table('proposal_files')->where('proposal_id', $proposal->id)->where('status', TRUE)->get();
        //count how many proposal_type_configurations;
      $count_proposal_configuration = $this->count_proposal_configuration($proposal);
      if(count($true_files) == $count_proposal_configuration){
        //update proposal status to "berkas_lengkap";
        \DB::table('proposals')->where('id', $proposal->id)->update(['status'=>'1', 'status_notes'=>'Berkas Lengkap']);
      }
      else{
        //update proposal status to "berkas_TIDAKlengkap";
        \DB::table('proposals')->where('id', $proposal->id)->update(['status'=>'2', 'status_notes'=>'Berkas Tidak Lengkap']); 
      }

      return redirect('proposal/'.$proposal->id)
          ->with('successMessage', "File has been checked and status is changed");
    }

    protected function count_proposal_configuration($proposal)
    {
      $proposal_type_configurations = \DB::table('proposal_type_configurations')
            ->select('surat_permohonan', 'ktp', 'foto_3x4', 'ijazah', 'fotokopi_sk_a_t', 'surat_pernyataan', 'cv')
            ->where('type', '=', $proposal->type)
            ->get();
            $required_file_amount = 0;
            foreach($proposal_type_configurations as $val){
                if($val->surat_permohonan == TRUE){
                  $required_file_amount+=1;
                }
                if($val->ktp == TRUE){
                  $required_file_amount+=1;
                }
                if($val->foto_3x4 == TRUE){
                  $required_file_amount+=1;
                }
                if($val->ijazah == TRUE){
                  $required_file_amount+=1;
                }
                if($val->fotokopi_sk_a_t == TRUE){
                  $required_file_amount+=1;
                }
                if($val->surat_pernyataan == TRUE){
                  $required_file_amount+=1;
                }
                if($val->cv == TRUE){
                  $required_file_amount+=1;
                }
            }
      return $required_file_amount;
    }


    //import excel
    public function getImport()
    {
        return view('proposal.import');
    }


    public function postImport(ImportProposalRequest $request)
    {
      $path = $request->file('file')->getRealPath();
      $data = Excel::load($path, function($reader) {
      })->get();
      if(!empty($data) && $data->count()){
        //initiate new imported member
        $new_imported_member = 0;
        $imported_proposal = 0;
        foreach ($data as $key => $value) {
          //check if member is already registered based on id_card or email value
          $is_member_registered = $this->is_member_registered($value->id_card, $value->email);


          if($is_member_registered == FALSE){
            //create the user account to this member and also store the proposal too
            //create the user account
              $user = new User;
              $user->name = $value->name;
              $user->id_card = $value->id_card;
              $user->email = $value->email;
              $user->tempat_lahir = $value->tempat_lahir;
              $user->tanggal_lahir = Carbon::parse($value->tanggal_lahir)->format('Y-m-d');
              $user->telephone = $value->telephone;
              $user->password = bcrypt("manchesterunited");
              $user->save();
              $user_id = $user->id;
              //attach role for this user
              $saved_user = User::find($user_id);
              $saved_user->roles()->attach(4);
              //attach dpd for this user
              $saved_user->dpds()->attach($request->dpd_id);
              $new_imported_member +=1;
            //store the proposal
              $proposal = new Proposal;
              $proposal->user_id = $user_id;
              $proposal->type = $request->type;
              $proposal->jumlah_unit_kompetensi = abs($value->jumlah_unit_kompetensi);
              $proposal->save();
              $proposal_id = $proposal->id;
              //update proposal_code;
              $update_proposal_code = $this->update_proposal_code($proposal_id);
              //register proposal log
              $log = $this->register_proposal_create_mode($proposal_id);
              //increment the imported proposal
              $imported_proposal +=1;
              
              
          }
          else{
            //only store the proposal for the returned user 
            //define the user returned data from is_member_registered
            $user = $is_member_registered->first();
            
            $proposal = new Proposal;
            $proposal->user_id = $user->id;
            $proposal->type = $request->type;
            $proposal->jumlah_unit_kompetensi = abs($value->jumlah_unit_kompetensi);
            $proposal->save();
            $proposal_id = $proposal->id;
            //update proposal_code;
            $update_proposal_code = $this->update_proposal_code($proposal_id);
            //register proposal log
            $log = $this->register_proposal_create_mode($proposal_id);
            //increment the imported proposal
            $imported_proposal +=1;
            
            

          }

        }

        return redirect('proposal')
               ->with('successMessage', "Imported $imported_proposal proposal and registered $new_imported_member member");
          
      }
      
    }


    protected function is_member_registered( $id_card = NULL, $email = NULL )
    {
      if($id_card != NULL || $email!= NULL){
        $user = User::where('id_card', '=', $id_card)->orWhere('email', '=', $email)->get();

        if($user ->count()){
          return $user;
        }
        else{
          return FALSE;
        }
      }else{
        return "Missing ID Card param or email";
      }
    }
   

}
