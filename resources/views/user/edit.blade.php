@extends('layouts.app')

@section('page_title')
  Member
@endsection

@section('page_header')
  <h1>
    Member
    <small>Edit Member</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('member') }}"><i class="fa fa-user"></i> Member</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Member </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($user, ['route'=>['user.update', $user->id], 'class'=>'form-horizontal','id'=>'form-edit-user', 'method'=>'put', 'files'=>true]) !!}
            <div class="form-group{{ $errors->has('dpd_id') ? ' has-error' : '' }}">
              {!! Form::label('dpd_id', 'DPD', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <select name="dpd_id" id="dpd_id" class="form-control">
                  @if($user->dpds)
                    <option value="{{ $user->dpds->first()->id }}">{{ $user->dpds->first()->name }}</option>
                  @endif
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
            <div class="form-group{{ $errors->has('id_card') ? ' has-error' : '' }}">
              {!! Form::label('id_card', 'KTP / Passport', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                {!! Form::text('id_card',null,['class'=>'form-control', 'placeholder'=>'id_card of the member', 'id'=>'id_card']) !!}
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
            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <input type="hidden" name="role_id" value="4">
                <a href="{{ url('member/'.$user->id.'') }}" class="btn btn-default">
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
  </script>
  
   
@endsection