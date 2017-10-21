<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ConfigurationController extends Controller
{
    public function getEqualizationProposal()
    {
    	$configuration = \DB::table('proposal_type_configurations')->where('type', '=', 'equalization')->get();
    	return view('configuration.proposal.equalization')
    		->with('configuration', $configuration);
    }

    //Proposal "Equalization"
    public function saveEqualizationProposal(Request $request)
    {
    	$data = [
    		'surat_permohonan'=>$request->surat_permohonan == 'on'?TRUE:FALSE,
    		'ktp'=>$request->ktp == 'on'?TRUE:FALSE,
    		'foto_3x4'=>$request->foto_3x4 == 'on'?TRUE:FALSE,
    		'ijazah'=>$request->ijazah == 'on'?TRUE:FALSE,
    		'fotokopi_sk_a_t'=>$request->fotokopi_sk_a_t == 'on'?TRUE:FALSE,
    		'surat_pernyataan'=>$request->surat_pernyataan == 'on'?TRUE:FALSE,
    		'cv'=>$request->cv == 'on'?TRUE:FALSE,
    	];
    	\DB::table('proposal_type_configurations')->where('type', '=', 'equalization')->update($data);
    	return redirect('configuration/proposal/equalization')
    		->with('successMessage', 'Configuration for Equalization Proposal has been saved');
    }

    //Proposal "NEW"
    public function getNewProposal()
    {
    	$configuration = \DB::table('proposal_type_configurations')->where('type', '=', 'new')->get();
    	return view('configuration.proposal.new')
    		->with('configuration', $configuration);
    }

    
    public function saveNewProposal(Request $request)
    {
    	$data = [
    		'surat_permohonan'=>$request->surat_permohonan == 'on'?TRUE:FALSE,
    		'ktp'=>$request->ktp == 'on'?TRUE:FALSE,
    		'foto_3x4'=>$request->foto_3x4 == 'on'?TRUE:FALSE,
    		'ijazah'=>$request->ijazah == 'on'?TRUE:FALSE,
    		'fotokopi_sk_a_t'=>$request->fotokopi_sk_a_t == 'on'?TRUE:FALSE,
    		'surat_pernyataan'=>$request->surat_pernyataan == 'on'?TRUE:FALSE,
    		'cv'=>$request->cv == 'on'?TRUE:FALSE,
    	];
    	\DB::table('proposal_type_configurations')->where('type', '=', 'new')->update($data);
    	return redirect('configuration/proposal/new')
    		->with('successMessage', 'Configuration for New Proposal has been saved');
    }


    //Proposal "EXTENSION"
    public function getExtensionProposal()
    {
    	$configuration = \DB::table('proposal_type_configurations')->where('type', '=', 'extension')->get();
    	return view('configuration.proposal.extension')
    		->with('configuration', $configuration);
    }

    
    public function saveExtensionProposal(Request $request)
    {
    	$data = [
    		'surat_permohonan'=>$request->surat_permohonan == 'on'?TRUE:FALSE,
    		'ktp'=>$request->ktp == 'on'?TRUE:FALSE,
    		'foto_3x4'=>$request->foto_3x4 == 'on'?TRUE:FALSE,
    		'ijazah'=>$request->ijazah == 'on'?TRUE:FALSE,
    		'fotokopi_sk_a_t'=>$request->fotokopi_sk_a_t == 'on'?TRUE:FALSE,
    		'surat_pernyataan'=>$request->surat_pernyataan == 'on'?TRUE:FALSE,
    		'cv'=>$request->cv == 'on'?TRUE:FALSE,
    	];
    	\DB::table('proposal_type_configurations')->where('type', '=', 'extension')->update($data);
    	return redirect('configuration/proposal/extension')
    		->with('successMessage', 'Configuration for Extension Proposal has been saved');
    }
}
