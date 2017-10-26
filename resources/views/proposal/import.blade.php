@extends('layouts.app')

@section('page_title')
  Import Permohonan
@endsection

@section('additional_styles')
  {!! Html::style('css/datepicker/datepicker3.css') !!}
@endsection

@section('page_header')
  <h1>
    Permohonan
    <small>Import Permohonan</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-users"></i> Permohonan</a></li>
    <li class="active"><i></i> Import</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Import Permohonan </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['url'=>'proposal/import', 'method'=>'post', 'id'=>'form-import-proposal', 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true]) !!}
            <div class="form-group{{ $errors->has('dpd_id') ? ' has-error' : '' }}">
              {!! Form::label('dpd_id', 'PD', ['class'=>'col-sm-2 control-label']) !!}
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
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <p>{!! Form::radio('type', 'new') !!} Pengajuan Baru</p>
                  <p>{!! Form::radio('type', 'equalization') !!} Penyetaraan</p>
                  <p>{!! Form::radio('type', 'extension') !!} Perpanjangan</p>
                  @if ($errors->has('type'))
                    <span class="help-block">
                      <strong>{{ $errors->first('type') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
              {!! Form::label('file', 'File', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::file('file') !!}
                @if ($errors->has('file'))
                  <span class="help-block">
                    <strong>{{ $errors->first('file') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <a href="{{ url('proposal') }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
                <button type="submit" class="btn btn-info" id="btn-import-proposal">
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
      placeholder: 'Select PD',
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

    $('#form-import-proposal').on('submit', function(){
      $('#btn-import-proposal').prop('disabled', true);
    });
    
  </script>
  
   
@endsection