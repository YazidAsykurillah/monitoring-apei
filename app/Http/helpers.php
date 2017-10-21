<?php

use Carbon\Carbon;


function jakarta_date_time($date_time = NULL)
{	
	if(is_null($date_time)){
		return NULL;
	}
	else{
		$the_date = Carbon::createFromFormat('Y-m-d H:i:s', $date_time);
		$the_date->setTimezone('Asia/Jakarta');
		return $the_date;
	}
	
}


function proposal_type_display($type = NULL){
	if(is_null($type)){
		return NULL;
	}else{
		switch ($type) {
			case 'new':
				return "Pengajuan Baru";
				break;
			case 'equalization':
				return "Penyetaraan";
				break;
			case 'extension':
				return "Perpanjangan";
				break;
			
			default:
				# code...
				break;
		}
	}
}

function proposal_status_display($status = NULL){
	if(is_null($status)){
		return NULL;
	}else{
		switch ($status) {
			case '0':
				return "Pengajuan Diterima";
				break;
			case '1':
				return "Berkas Lengkap";
				break;
			case '2':
				return "Berkas Tidak Lengkap";
				break;
			case '3':
				return "Proses Online DJK";
				break;
			case '4':
				return "Terima Nomor Registrasi";
				break;
			case '5':
				return "Cetak Sertifikat";
				break;
			case '6':
				return "Penandatangan sertifikat";
				break;
			case '7':
				return "Scanning dan tandaterima";
				break;
			case '8':
				return "Sertifikat siap kirim";
				break;
			case '9':
				return "Sertifikat sudah terkirim";
				break;
			case '10':
				return "Selesai";
				break;
			default:
				# code...
				break;
		}
	}
}