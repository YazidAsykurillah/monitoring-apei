<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Excel;
use App\User;

class TemplateController extends Controller
{
    public function index()
    {
    	return view('template.index');
    }

    public function member()
    {
    	//$data = User::select('name', 'email', 'id_card', 'tempat_lahir', 'tanggal_lahir')->get();
    	$data = [
    		'name', 'tempat_lahir', 'tanggal_lahir', 'id_card', 'email', 'telephone'
    	];
    	Excel::create('Template Pemohon PT APEI', function($excel) use ($data) {

		    // Set the title
		    $excel->setTitle('Template pemohon untuk import daftar pemohon');
		    $excel->sheet('Sheet-01', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
		    // Chain the setters
		    $excel->setCreator('PT APEI')
		          ->setCompany('PT APEI');

		    // Call them separately
		    $excel->setDescription('Template pemohon untuk import daftar pemohon');

		})->download('xls');
    }

    public function proposal()
    {
    	$data = [
    		'name', 'tempat_lahir', 'tanggal_lahir', 'id_card', 'email', 'telephone', 'jumlah_unit_kompetensi'
    	];
    	Excel::create('Template Permohonan PT APEI', function($excel) use ($data) {

		    // Set the title
		    $excel->setTitle('Template Permohonan untuk import daftar Permohonan');
		    $excel->sheet('Sheet-01', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
		    // Chain the setters
		    $excel->setCreator('PT APEI')
		          ->setCompany('PT APEI');

		    // Call them separately
		    $excel->setDescription('Template Permohonan untuk import daftar Permohonan');

		})->download('xls');
    }
}
