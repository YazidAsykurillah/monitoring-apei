@extends('layouts.app')

@section('page_title')
  {{ $proposal->code }}
@endsection

@section('page_header')
  <h1>
    Proposal
    <small>Proposal Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-newspaper-o"></i> Proposal</a></li>
    <li class="active"><i></i> Detail</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    
    <div class="col-lg-8">
      <!-- Box General Information-->
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Proposal Detail</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <td style="width: 20%;">Code</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $proposal->code }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Type</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ proposal_type_display($proposal->type) }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Member Name</td>
                  <td style="width: 1%;">:</td>
                  <td>
                    @if($proposal->user)
                      {{ $proposal->user->name }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td style="width: 20%;">Created Date</td>
                  <td style="width: 1%;">:</td>
                  <td>{{ $proposal->created_at }}</td>
                </tr>
                <tr>
                  <td style="width: 20%;">Status</td>
                  <td style="width: 1%;">:</td>
                  <td>
                    {{ proposal_status_display($proposal->status)}}&nbsp;
                    <a href="#" id="btn-change-status" data-id="{{ $proposal->id }}" data-text="{{ $proposal->code }}" class="btn btn-link">
                      <i class="fa fa-cog"></i>&nbsp;Change Status
                    </a>
                    @if($proposal->status == '2')
                    <p class="text-warning"><i class="fa fa-warning"></i>&nbsp;{{ $proposal->uncomplete_reason }}</p>
                    @endif
                  </td>
                </tr>
                
              </table>
            </div>
          </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
      <!-- ENDBox General Information-->

      <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Logs</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            @if($proposal->proposal_logs->count())
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 20%;">Datetime</th>
                  <th style="width: 15%;">User</th>
                  <th style="width: 15%;">Mode</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>
                @foreach($proposal->proposal_logs as $log)
                <tr>
                  <td>{{ $log->created_at }}</td>
                  <td>{{ $log->user->name }}</td>
                  <td>{{ $log->mode }}</td>
                  <td>{!! $log->description !!}</td>
                </tr>
                @endforeach  
              </tbody>
            </table>
            @else
            <p class="alert alert-info">There is no log informations</p>
            @endif
          </div>
      </div>

    </div>
    

    <!-- Box Files Information-->
    <div class="col-lg-4">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Files</h3>

          </div><!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['url'=>'proposal/fileCompletion', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
            @foreach($proposal_file_check_lists as $check_list)
              <div class="form-group">
                <div class="col-md-6">
                    <label for="proposal_file_id">{{ $check_list->file }}</label>
                </div>
                <div class="col-md-3">
                  <input type="checkbox" name="proposal_file_id[]" class="proposal_file_checkboxes" value="{{ $check_list->id}}" {{ $check_list->status == TRUE ? 'checked':''}} /> 
                </div>
              </div>
            @endforeach
              <div class="form-group">
                {!! Form::label('', '', ['class'=>'col-md-6 control-label']) !!}
                <div class="col-md-6">
                  <input type="hidden" name="proposal_id_from_proposal_file" value="{{ $proposal->id}}" />
                  <button type="submit" class="btn btn-info" id="btn-proposal-file-checklist">
                    <i class="fa fa-save"></i>&nbsp;Submit
                  </button>
                </div>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
    <!-- ENDBox Files Information-->
  </div>

  <!--Modal CHANGE STATUS-->
  <div class="modal fade" id="modal-change-status" tabindex="-1" role="dialog" aria-labelledby="modal-change-statusLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'proposal/changestatus', 'role'=>'form', 'class'=>'form-horizontal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-change-statusLabel">Change Status</h4>
        </div>
        <div class="modal-body">
          <p class="alert alert-info">
            <i class="fa fa-info-circle"></i>&nbsp;Select to change the proposal status
          </p>
          <div class="form-group">
            {!! Form::label('status', 'Status', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('status',$status_opts , $proposal->status, ['class'=>'form-control', 'id'=>'status']) }}
            </div>
          </div>
          <div class="form-group{{ $errors->has('uncomplete_reason') ? ' has-error' : '' }}" id="uncomplete_reason_group">
            {!! Form::label('uncomplete_reason', 'Keterangan', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::textarea('uncomplete_reason',$proposal->uncomplete_reason,['class'=>'form-control', 'placeholder'=>'uncomplete_reason of the proposal', 'id'=>'uncomplete_reason']) !!}
              @if ($errors->has('uncomplete_reason'))
                <span class="help-block">
                  <strong>{{ $errors->first('uncomplete_reason') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <br/>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="proposal_id" name="proposal_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Change</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal CHANGE STATUS-->


  
@endsection

@section('additional_scripts')
 
<script type="text/javascript">
  $('#btn-change-status').on('click', function(event){
    event.preventDefault();
    $('#modal-change-status').modal('show');
    $('#proposal_id').val($(this).attr('data-id'));
  });

  $('#status').on('change', function(){
    if($(this).val() == '2'){
      $('#uncomplete_reason').prop('required', true);
      $('#uncomplete_reason_group').show();
    }else{
      $('#uncomplete_reason').prop('required', false);
      $('#uncomplete_reason_group').hide();
    }
  });

  @if($proposal->status == '2')
    $('#uncomplete_reason').prop('required', true);
    $('#uncomplete_reason_group').show();
  @else
    $('#uncomplete_reason').prop('required', false);
    $('#uncomplete_reason_group').hide();
  @endif

  //Block handle proposal file checking submission
  var proposal_status = {!! $proposal->status !!};
  if(proposal_status == '0' || proposal_status == '2'){
    $('.proposal_file_checkboxes').prop('disabled', false);
    $('#btn-proposal-file-checklist').prop('disabled', false);
  }else{
    $('.proposal_file_checkboxes').prop('disabled', true);
    $('#btn-proposal-file-checklist').prop('disabled', true);
  }
  
</script>
  
   
@endsection