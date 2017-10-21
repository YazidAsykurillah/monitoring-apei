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
            return view('home')
                ->with('complete_proposal_files', $complete_proposal_files)
                ->with('uncomplete_proposal_files', $uncomplete_proposal_files)
                ->with('proses_online_djk', $proses_online_djk)
                ->with('terima_nomer_registrasi', $terima_nomer_registrasi)
                ->with('cetak_sertifikat', $cetak_sertifikat)
                ->with('penandatanganan_sertifikat', $penandatanganan_sertifikat)
                ->with('scanning_dan_tanda_terima', $scanning_dan_tanda_terima)
                ->with('sertifikat_siap_kirim', $sertifikat_siap_kirim)
                ->with('sertifikat_sudah_terkirim', $sertifikat_sudah_terkirim);
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
                return $query->where('id', '=', $dpd_id);
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
                ->with('sertifikat_sudah_terkirim', $sertifikat_sudah_terkirim);
    }


    public function searchProposal(Request $request)
    {
        $user = User::where('name', 'LIKE', "%$request->memberName%")
                ->orWhere('id_card', '=',trim(trim($request->memberKTP)))
                ->get();
        // print_r($user->toArray());
        // exit();
        
        if(count($user->toArray())){
            $user_id_array = [];
            foreach($user->toArray() as $user_id){
                array_push($user_id_array, $user_id['id']);
            }
            $proposals = Proposal::whereIn('user_id', $user_id_array)->get();
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
