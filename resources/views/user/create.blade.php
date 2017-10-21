@extends('layouts.app')

@section('page_title')
  Create Member
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Member
    <small>Create Member</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('member') }}"><i class="fa fa-users"></i> Member</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Create Member </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'user.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-user','files'=>true]) !!}
            <div class="form-group{{ $errors->has('dpd_id') ? ' has-error' : '' }}">
              {!! Form::label('dpd_id', 'DPD', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <select name="dpd_id" id="dpd_id" class="form-control">
                  @if(Request::old('dpd_id') != NULL)
                    <option value="{{Request::old('dpd_id')}}">
                      {{ \App\Dpd::find(Request::old('dpd_id'))->name }}
                    </option>
                  @endif
                </select>
                @if ($errors->has('dpd_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('dpd_id') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the member', 'id'=>'name']) !!}
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
                {!! Form::text('email',null,['class'=>'form-control', 'placeholder'=>'Email of the member', 'id'=>'email']) !!}
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('id_card') ? ' has-error' : '' }}">
              {!! Form::label('id_card', 'KTP/Passport', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('id_card',null,['class'=>'form-control', 'placeholder'=>'ID Card of the member', 'id'=>'id_card']) !!}
                @if ($errors->has('id_card'))
                  <span class="help-block">
                    <strong>{{ $errors->first('id_card') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
              {!! Form::label('telephone', 'No HP', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('telephone',null,['class'=>'form-control', 'placeholder'=>'telephone of the member', 'id'=>'telephone']) !!}
                @if ($errors->has('telephone'))
                  <span class="help-block">
                    <strong>{{ $errors->first('telephone') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('tempat_lahir') ? ' has-error' : '' }}">
              {!! Form::label('tempat_lahir', 'Tempat Lahir', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('tempat_lahir',null,['class'=>'form-control', 'placeholder'=>'Place of birth', 'id'=>'tempat_lahir']) !!}
                @if ($errors->has('tempat_lahir'))
                  <span class="help-block">
                    <strong>{{ $errors->first('tempat_lahir') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
              {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('tanggal_lahir',null,['class'=>'form-control', 'placeholder'=>'Date of birth', 'id'=>'tanggal_lahir']) !!}
                @if ($errors->has('tanggal_lahir'))
                  <span class="help-block">
                    <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <input type="hidden" name="role_id" value="4">
                <a href="{{ url('user') }}" class="btn btn-default">
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
  {!! Html::script('js/datepicker/bootstrap-datepicker.js') !!}
  <script type="text/javascript">
    //Block dpd_id selection
    $('#dpd_id').select2({
      placeholder: 'Select DPD',
      ajax: {
        url: '{!! url('select2Dpd') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id
                  }
              })
          };
        },
        cache: true
      },
      allowClear : true
    });
    //ENDBlock dpd_id selection

    //Block Tanggal Lahir
    $('#tanggal_lahir').on('keydown', function(event){
      event.preventDefault();
    });
    $('#tanggal_lahir').datepicker({
      format : 'yyyy-mm-dd',
    });
    //ENDBlock Tanggal Lahir
  </script>
  
   
@endsection