@extends('layouts.app')

@section('page_title')
  Profile
@endsection

@section('page_header')
  <h1>
    Profile
    <small>Detail Profile</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-user"></i> My Profile</h3>
            
            
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
                <tr>
                  <td style="width: 20%;">Role</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $user->roles->first()->name }}</td>
                </tr>
              </table>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>

    <div class="col-md-4">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lock"></i> Change Password</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['url'=>'profile/change-password', 'method'=>'post', 'id'=>'form-change-password', 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true]) !!}
              <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                {!! Form::label('new_password', 'New Password', ['class'=>'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  {!! Form::password('new_password',['class'=>'form-control', 'placeholder'=>'New Password', 'id'=>'new_password']) !!}
                  @if ($errors->has('new_password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('password_conf') ? ' has-error' : '' }}">
                {!! Form::label('password_conf', 'Password Confirmation', ['class'=>'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  {!! Form::password('password_conf',['class'=>'form-control', 'placeholder'=>'Password Confirmation', 'id'=>'password_conf']) !!}
                  @if ($errors->has('password_conf'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password_conf') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                {!! Form::label('', '', ['class'=>'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  <a href="{{ url('profile') }}" class="btn btn-default">
                    <i class="fa fa-repeat"></i>&nbsp;Cancel
                  </a>&nbsp;
                  <button type="submit" class="btn btn-info" id="btn-submit-change-password">
                    <i class="fa fa-save"></i>&nbsp;Update
                  </button>
                </div>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    
  </div>
  
  
@endsection

@section('additional_scripts')
 

 
@endsection