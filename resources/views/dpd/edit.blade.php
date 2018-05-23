@extends('layouts.app')

@section('page_title')
  PD - Create
@endsection

@section('page_header')
  <h1>PD <small>Create PD</small></h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('dpd') }}"><i class="fa fa-home"></i> PD</a></li>
    <li class="active"><i></i>Create</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create PD</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($dpd, [ 'route'=>['dpd.update', $dpd->id], 'id'=>'form-update-dpd', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'put' ]) !!}
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Code', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'code of the PD', 'id'=>'code']) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the PD', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('dpd/'.$dpd->id.'') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-update-dpd">
                <i class="fa fa-save"></i>&nbsp;Update
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