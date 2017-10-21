@extends('layouts.app')

@section('page_title')
  Proposal Pengajuan Baru
@endsection

@section('page_header')
  <h1>
    Configuration
    <small>Proposal Pengajuan Baru</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('#') }}"><i class="fa fa-cog"></i> Configuration</a></li>
    <li class="active"><i></i> Proposal Pengajuan Baru</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Proposal Pengajuan Baru</h3>
        </div>
        <div class="box-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Check to make file to be required
          </p>
          {!! Form::open(['url'=>'configuration/proposal/new', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
            <div class="form-group{{ $errors->has('surat_permohonan') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="surat_permohonan">Surat Permohonan</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="surat_permohonan" {{ $configuration[0]->surat_permohonan ? 'checked' : '' }}>
              </div>
            </div>
            <div class="form-group{{ $errors->has('ktp') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="ktp">KTP</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="ktp" {{ $configuration[0]->ktp ? 'checked' : '' }}>
              </div>
            </div>
            <div class="form-group{{ $errors->has('foto_3x4') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="foto_3x4">Foto 3x4</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="foto_3x4" {{ $configuration[0]->foto_3x4 ? 'checked' : '' }}>
              </div>
            </div>
            <div class="form-group{{ $errors->has('ijazah') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="ijazah">Ijazah</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="ijazah" {{ $configuration[0]->ijazah ? 'checked' : '' }}>
              </div>
            </div>
            <div class="form-group{{ $errors->has('fotokopi_sk_a_t') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="fotokopi_sk_a_t">Fotokopi SKA/SKT</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="fotokopi_sk_a_t" {{ $configuration[0]->fotokopi_sk_a_t ? 'checked' : '' }}>
              </div>
            </div>
            <div class="form-group{{ $errors->has('surat_pernyataan') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="surat_pernyataan">Surat Pernyataan</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="surat_pernyataan" {{ $configuration[0]->surat_pernyataan ? 'checked' : '' }}>
              </div>
            </div>
            <div class="form-group{{ $errors->has('cv') ? ' has-error' : '' }}">
              <div class="col-md-3">
                  <label class="pull-right" for="cv">CV</label>
              </div>
              <div class="col-md-9">
                  <input type="checkbox" name="cv" {{ $configuration[0]->cv ? 'checked' : '' }}>
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <button type="submit" class="btn btn-info" id="btn-submit-certificate">
                  <i class="fa fa-save"></i>&nbsp;Save
                </button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('additional_scripts')
 
@endsection