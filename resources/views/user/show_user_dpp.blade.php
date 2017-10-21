@extends('layouts.app')

@section('page_title')
  Administrator DPP
@endsection

@section('page_header')
  <h1>
    Administrator DPP
    <small>Detail Administrator DPP</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user-dpp') }}"><i class="fa fa-users"></i> Administrator DPP</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-8">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Administrator DPP</h3>
              <a href="{{ url('user-dpp/'.$user->id.'/edit') }}" class="btn btn-info pull-right">Edit</a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-user">
                  <tr>
                    <td style="width: 20%;">Name</td>
                    <td style="width: 1%;">:</td>
                    <td>{{ $user->name }}</td>
                  </tr>
                  <tr>
                    <td style="width: 20%;">Email</td>
                    <td style="width: 1%;">:</td>
                    <td>{{ $user->email }}</td>
                  </tr>
                </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>
  
@endsection

@section('additional_scripts')
 
 
@endsection