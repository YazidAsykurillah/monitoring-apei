@extends('layouts.app')

@section('page_title')
  Proposal
@endsection

@section('page_header')
  <h1>
    Proposal
    <small>Create Proposal</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-newspaper-o"></i> Proposal</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Create Proposal</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            {!! Form::open(['route'=>'proposal.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-proposal','files'=>true]) !!}
              <div class="form-group{{ $errors->has('dpd_id') ? ' has-error' : '' }}">
                {!! Form::label('dpd_id', 'DPD', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <select id="dpd_id" name="dpd_id" class="form-control">
                    @if(Request::old('dpd_id') != NULL)
                      <option value="{{Request::old('dpd_id')}}">
                        {!! \DB::table('dpds')->where('id', '=', \Request::old('dpd_id'))->first()->name !!}
                      </option>
                    @endif
                    @if(Request::get('dpd_id'))
                     <option value="{{Request::get('dpd_id')}}">
                        {!! \DB::table('dpds')->where('id', '=', \Request::get('dpd_id'))->first()->name !!}
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
              <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                {!! Form::label('user_id', 'Member', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <select id="user_id" name="user_id" class="form-control">
                    @if(Request::old('user_id') != NULL)
                      <option value="{{Request::old('user_id')}}">
                        {!! \DB::table('users')->where('id', '=', \Request::old('user_id'))->first()->name !!}
                      </option>
                    @endif
                    @if(Request::get('user_id') != NULL)
                      <option value="{{Request::get('user_id')}}">
                        {!! \DB::table('users')->where('id', '=', \Request::get('user_id'))->first()->name !!}
                      </option>
                    @endif

                  </select>
                  @if ($errors->has('user_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('user_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {!! Form::label('type', 'Type', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <p>{!! Form::radio('type', 'equalization') !!} Penyetaraan</p>
                  <p>{!! Form::radio('type', 'new') !!} Pengajuan Baru</p>
                  <p>{!! Form::radio('type', 'extension') !!} Perpanjangan</p>
                  @if ($errors->has('type'))
                    <span class="help-block">
                      <strong>{{ $errors->first('type') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::textarea('notes',null,['class'=>'form-control', 'placeholder'=>'Notes of the proposal', 'id'=>'notes']) !!}
                  @if ($errors->has('notes'))
                    <span class="help-block">
                      <strong>{{ $errors->first('notes') }}</strong>
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
                  <button type="submit" class="btn btn-info" id="btn-submit-certificate">
                    <i class="fa fa-save"></i>&nbsp;Save
                  </button>
                </div>
              </div>
            {!! Form::close() !!}
            </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>


  
@endsection

@section('additional_scripts')
 
<script type="text/javascript">
  //initiate selected dpd_id;
  var selected_dpd_id = "";
  //see if we got the old dpd_id submitted
  @if(Request::old('dpd_id') != NULL)
    selected_dpd_id = {{Request::old('dpd_id')}};
  @endif
  //see if we have dpd_id from the memeber detail page
  @if(Request::get('dpd_id') != NULL)
    selected_dpd_id = {{Request::get('dpd_id')}};
  @endif
  //Block dpd_id selection
  $('#dpd_id').select2({
    placeholder: 'Select DPD',
    ajax: {
      url: '{!! url('select2DpdFromCreateProposal') !!}',
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
  }).on('select2:select', function(){
    selected_dpd_id = $(this).val();
    $('#user_id').val('').trigger('change');
  }).on('select2:unselect', function(){
    $('#user_id').val('').trigger('change');
  });
  //ENDBlock dpd_id selection

  //Block user_id selection

  $('#user_id').select2({
    placeholder: 'Select Member',
    ajax: {
      url: '{!! url('select2UserFromCreateProposal') !!}',
      data: function (params) {
           return {
                q: params.term,
                dpd_id: selected_dpd_id,
                page: params.page
           };
      },
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
  //ENDBlock user_id selection
   
</script>
  
   
@endsection