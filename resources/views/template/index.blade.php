@extends('layouts.app')

@section('page_title')
  Daftar Template
@endsection

@section('page_header')
  <h1>
    Template
    <small>Daftar Template</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('template') }}"><i class="fa fa-user"></i> Template</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Template</h3>
        </div>
        <div class="box-body">
          <p class="alert alert-info">Clik Download button to download the template</p>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th style="width:5%;">No</th>
                  <th>Name</th>
                  <th style="width:10%;text-align:center;">Download</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Pemohon</td>
                  <td style="text-align:center;">
                    <a href="{{ url('template/member') }}" class="btn btn-default">
                      <i class="fa fa-download"></i> Download
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Permohonan</td>
                  <td style="text-align:center;">
                    <a href="{{ url('template/proposal') }}" class="btn btn-default">
                      <i class="fa fa-download"></i> Download
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer clearfix">
          
        </div>
      </div>
        
    </div>
  </div>


  
@endsection

@section('additional_scripts')
 
  
   
@endsection