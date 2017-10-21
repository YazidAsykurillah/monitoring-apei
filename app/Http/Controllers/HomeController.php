<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Proposal;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if($user->roles->first()->code == 'SUP' || $user->roles->first()->code == 'AD-DPP'){
            $complete_proposal_files = Proposal::where('status', '=', '1')->get()->count(); //berkas lengkap
            $uncomplete_proposal_files = Proposal::where('status', '=', '2')->get()->count(); //berkas TIDAK lengkap
            $proses_online_djk = Proposal::where('status', '=', '3')->get()->count(); //Proses online DJK
            $terima_nomer_registrasi = Proposal::where('status', '=', '4')->get()->count();
            $cetak_sertifikat = Proposal::where('status', '=', '5')->get()->count();
            $penandatanganan_sertifikat = Proposal::where('status', '=', '6')->get()->count();
            $scanning_dan_tanda_terima = Proposal::where('status', '=', '7')->get()->count();
            $sertifikat_siap_kirim = Proposal::where('status', '=', '8')->get()->count();
            $sertifikat_sudah_terkirim = Proposal::where('status', '=', '9')->get()->count();
            $on_process_certificates  = Proposal::whereNotIn('status', ['0','1', '2', '10'])->get()->count();
            return view('home')
                ->with('complete_proposal_files', $complete_proposal_files)
                ->with('uncomplete_proposal_files', $uncomplete_proposal_files)
                ->with('proses_online_djk', $proses_online_djk)
                ->with('terima_nomer_registrasi', $terima_nomer_registrasi)
                ->with('cetak_sertifikat', $cetak_sertifikat)
                ->with('penandatanganan_sertifikat', $penandatanganan_sertifikat)
                ->with('scanning_dan_tanda_terima', $scanning_dan_tanda_terima)
                ->with('sertifikat_siap_kirim', $sertifikat_siap_kirim)
                ->with('sertifikat_sudah_terkirim', $sertifikat_sudah_terkirim)
                ->with('on_process_certificates', $on_process_certificates);
        }
        elseif($user->roles->first()->code == 'AD-DPD'){
            return $this->index_for_dpd($user);
        }
        else{

        }
        
    }

    protected function index_for_dpd($user){
        $dpd_id =  $user->dpds()->first()->id;
        $proposals = Proposal::with(['user', 'user.dpds'])
            ->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', $dpd_id);
            })->get();
        
        $complete_proposal_files = $proposals->where('status', '1')->count();
        $uncomplete_proposal_files = $proposals->where('status', '2')->count();
        $proses_online_djk = $proposals->where('status', '3')->count();
        $terima_nomer_registrasi = $proposals->where('status', '4')->count();
        $cetak_sertifikat = $proposals->where('status', '5')->count();
        $penandatanganan_sertifikat = $proposals->where('status', '6')->count();
        $scanning_dan_tanda_terima = $proposals->where('status', '7')->count();
        $sertifikat_siap_kirim = $proposals->where('status', '8')->count();
        $sertifikat_sudah_terkirim = $proposals->where('status', '9')->count();
        $on_process_certificates  = $proposals->whereIn('status', ['3', '4', '5', '6', '7', '8'])->count();
        
        // echo $sertifikat_sudah_terkirim;
        // exit();
        return view('home')
                ->with('complete_proposal_files', $complete_proposal_files)
                ->with('uncomplete_proposal_files', $uncomplete_proposal_files)
                ->with('proses_online_djk', $proses_online_djk)
                ->with('terima_nomer_registrasi', $terima_nomer_registrasi)
                ->with('cetak_sertifikat', $cetak_sertifikat)
                ->with('penandatanganan_sertifikat', $penandatanganan_sertifikat)
                ->with('scanning_dan_tanda_terima', $scanning_dan_tanda_terima)
                ->with('sertifikat_siap_kirim', $sertifikat_siap_kirim)
                ->with('sertifikat_sudah_terkirim', $sertifikat_sudah_terkirim)
                ->with('on_process_certificates', $on_process_certificates);
    }


    public function searchProposal(Request $request)
    {
        if($request->memberName == "" && $request->memberKTP == ""){
            return redirect()->back()
            ->with('errorMessage', "Silahkan isi nama member atau KTP/Passport");
        }
        $logged_in_user = \Auth::user()->roles->first();
        if($logged_in_user->code == 'SUP' || $logged_in_user->code == 'AD-DPP'){
            $user = User::where('name', 'LIKE', "%$request->memberName%")
                ->orWhere('id_card', '=',trim(trim($request->memberKTP)))
                ->get();  
        }elseif($logged_in_user->code == 'AD-DPD'){
            $dpd_id = \Auth::user()->dpds->first()->id;
            $user = User::with(['roles', 'dpds'])
            ->whereHas('roles', function($query){
                $query->where('id','=',4);
            })
            ->whereHas('dpds', function($query) use($dpd_id, $request){
                $query->where('dpds.id','=',$dpd_id);
                $query->where('users.name', 'LIKE', "%$request->memberName%");
                $query->orWhere('users.id_card', 'LIKE','%'.trim(trim($request->memberKTP)).'%');
            })
            ->get();
        }
        else{
            return "Missing role";
            exit();
        }
        
        // print_r($user->toArray());
        // exit();
        
        if(count($user->toArray())){
            $user_id_array = [];
            
            foreach($user->toArray() as $user_id){
                array_push($user_id_array, $user_id['id']);
            }
            $proposals = Proposal::whereHas('user', function($query) use($user_id_array){
                return $query->whereIn('id', $user_id_array);
            })
            ->orderBy('proposals.id', 'desc')
            ->get();
            return redirect()->back()
            ->withInput()
            ->with('proposals', $proposals)
            ->with('userResult', $user);
        }
        else{
            return redirect()->back()
            ->with('userResult', $user)
            ->withInput();
        }
        
       
    }
}
