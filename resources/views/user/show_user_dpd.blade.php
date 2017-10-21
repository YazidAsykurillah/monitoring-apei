@extends('layouts.app')

@section('page_title')
  Administrator DPD
@endsection

@section('page_header')
  <h1>
    Administrator DPD
    <small>Detail Administrator DPD</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user-dpd') }}"><i class="fa fa-users"></i> Administrator DPD</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail Administrator DPD</h3>
            <a href="{{ url('user-dpd/'.$user->id.'/edit') }}" class="btn btn-info pull-right">
              <i class="fa fa-edit"></i>&nbsp;Edit
            </a>
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
                  <td style="width: 20%;">DPD Name</td>
                  <td style="width: 1%;">:</td>
                  <td>
                    @if($user->dpds->count())
                      {{ $user->dpds->first()->name }}
                    @endif
                  </td>
                </tr>
              </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
    <div class="col-md-4">
      <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Change or Reset Password</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['url'=>'user/password/change','role'=>'form','class'=>'form-horizontal','id'=>'form-change-password']) !!}
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password', ['class'=>'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::password('password',['class'=>'form-control', 'id'=>'password']) !!}
                @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('password_conf') ? ' has-error' : '' }}">
              {!! Form::label('password_conf', 'Password Confirmation', ['class'=>'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::password('password_conf',['class'=>'form-control', 'id'=>'password_conf']) !!}
                @if ($errors->has('password_conf'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password_conf') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('default_password') ? ' has-error' : '' }}">
              {!! Form::label('default_password', 'Reset Password', ['class'=>'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {{ Form::checkbox('default_password', null, null, ['id' => 'default_password']) }}
                <small class="text-warning"><i class="fa fa-info-circle"></i>&nbsp;If it is checked, the password will be set to default password</small>
                @if ($errors->has('default_password'))
                  <span class="help-block">
                    <strong>d</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-4 control-label']) !!}
              <div class="col-sm-8">
                {!! Form::hidden('user_id', $user->id) !!}
                <button type="submit" class="btn btn-info" id="btn-submit-certificate">
                  <i class="fa fa-save"></i>&nbsp;Submit
                </button>
              </div>
            </div>
          {!! Form::close() !!}
          </div>
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  
@endsection

@section('additional_scripts')
 <script type="text/javascript">
   $('#default_password').on('click', function(){
    if($(this).is(':checked')){
      $('#password').prop('disabled', true);
      $('#password_conf').prop('disabled', true);
    }
    else{
      $('#password').prop('disabled', false);
      $('#password_conf').prop('disabled', false);
    }
   });
 </script>
 
@endsection