@extends('layouts.app')

@section('page_title')
  Member
@endsection

@section('page_header')
  <h1>
    Member
    <small>Detail Member</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('member') }}"><i class="fa fa-users"></i> Member</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail Member</h3>
            <div class="pull-right">
              <a href="{{ url('member/'.$user->id.'/edit') }}" class="btn btn-info btn-xs" title="Click to edit this member">
                <i class="fa fa-edit"></i>&nbsp;Edit
              </a>
              
            </div>
            
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
                <tr>
                  <td style="width: 20%;">KTP / Passport</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $user->id_card }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">No HP</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $user->telephone }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Tempat Lahir</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $user->tempat_lahir }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Tanggal Lahir</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $user->tanggal_lahir }}</td>
                </tr>
              </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="{{ url('proposal/create/?dpd_id='.$user->dpds->first()->id.'&user_id='.$user->id.'') }}" class="btn btn-success btn-xs pull-right" title="Click to register proposal for this member">
            <i class="fa fa-plus"></i>&nbsp;Proposal
          </a>
        </div>
      </div><!-- /.box -->
    </div>
    <div class="col-md-4">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Photo</h3>
        </div>
        <div class="box-body">
          @if($user->photo == NULL)
            {!! Form::open(array('url' => 'user/uploadphoto','files'=>'true', 'role'=>'form', 'class'=>'form-horizontal', 'id'=>'form-upload-photo')) !!}
              <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                <div class="col-sm-8">
                  {!! Form::file('photo') !!}
                  @if ($errors->has('photo'))
                    <span class="help-block">
                      <strong>{{ $errors->first('photo') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                  {!! Form::hidden('user_id', $user->id) !!}
                  <button type="submit" class="btn btn-xs btn-info" id="btn-submit-photo">
                    <i class="fa fa-upload"></i>&nbsp;Upload
                  </button>
                </div>
              </div>
            {!! Form::close() !!}
          @else               
            {!! Html::image('files/photo/thumb_'.$user->photo.'', $user->photo, ['class'=>'profile-user-img img-responsive img-circle']) !!}
            <p></p>
            <center>
            <a href="#" class="btn btn-xs btn-danger" id="btn-delete-photo" data-user-id="{{ $user->id }}">
              <i class="fa fa-trash"></i>
            </a>
            </center>
          @endif
        </div>
      </div>
    </div>
  </div>
  
  <!--Modal Delete PHoto-->
  <div class="modal fade" id="modal-delete-photo" tabindex="-1" role="dialog" aria-labelledby="modal-delete-photoLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'user/deletephoto', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-photoLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          Photo will be deleted
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="user_id" name="user_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Delete PHoto-->
@endsection

@section('additional_scripts')
 
<script type="text/javascript">
  $('#btn-delete-photo').on('click', function(event){
    event.preventDefault();
    var id = $(this).attr('data-user-id');
    var code = $(this).attr('data-text');
    $('#user_id').val(id);
    $('#modal-delete-photo').modal('show');
  });   

</script>
 
@endsection