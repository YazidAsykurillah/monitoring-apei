@extends('layouts.app')

@section('page_title')
  Administrator DPP
@endsection

@section('page_header')
  <h1>
    Administrator DPP
    <small>Edit Administrator DPP</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user-dpp') }}"><i class="fa fa-users"></i> Administrator DPP</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Administrator DPP </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($user, ['route'=>['user.update', $user->id], 'class'=>'form-horizontal','id'=>'form-edit-user', 'method'=>'put', 'files'=>true]) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Nama', 'id'=>'name']) !!}
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('email',null,['class'=>'form-control', 'placeholder'=>'Email', 'id'=>'email']) !!}
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <input type="hidden" name="role_id" value="2">
                <a href="{{ url('user-dpp') }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
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