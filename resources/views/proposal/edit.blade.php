@extends('layouts.app')

@section('page_title')
  Proposal
@endsection

@section('page_header')
  <h1>
    Proposal
    <small>Edit Proposal</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-newspaper-o"></i> Proposal</a></li>
    <li class="active"><i></i> Edit</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Proposal</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            {!! Form::model($proposal, ['route'=>['proposal.update', $proposal->id], 'class'=>'form-horizontal','id'=>'form-edit-proposal', 'method'=>'put', 'files'=>true]) !!}
              <div class="form-group{{ $errors->has('dpd_id') ? ' has-error' : '' }}">
                {!! Form::label('dpd_id', 'DPD', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <select id="dpd_id" name="dpd_id" class="form-control">
                    <!-- ERROR HANDLING if proposal have relation to a user-->
                    @if($proposal->user)
                    <option value="{{ $proposal->user->dpds()->first()->id }}" selected="selected">
                      {{ $proposal->user->dpds()->first()->name }}
                    </option>
                    @endif
                    <!-- ENDERROR HANDLING if proposal have relation to a user-->
                    @if(Request::old('dpd_id') != NULL)
                      <option value="{{Request::old('dpd_id')}}">
                        {!! \DB::table('dpds')->where('id', '=', \Request::old('dpd_id'))->first()->name !!}
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
                    <!-- ERROR HANDLING if proposal have relation to a user-->
                    @if($proposal->user)
                    <option value="{{ $proposal->user_id }}" selected="selected">
                      {{ \DB::table('users')->where('id', '=', $proposal->user_id)->first()->name }}
                    </option>
                    @endif
                    <!-- ENDERROR HANDLING if proposal have relation to a user-->
                    @if(Request::old('user_id') != NULL)
                      <option value="{{Request::old('user_id')}}">
                        {!! \DB::table('users')->where('id', '=', \Request::old('user_id'))->first()->name !!}
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
              <div class="form-group{{ $errors->has('jumlah_unit_kompetensi') ? ' has-error' : '' }}">
                {!! Form::label('jumlah_unit_kompetensi', 'Jumlah Unit Kompetensi', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::number('jumlah_unit_kompetensi',null,['class'=>'form-control', 'placeholder'=>'Jumlah unit kompetensi of the proposal', 'id'=>'jumlah_unit_kompetensi']) !!}
                  @if ($errors->has('jumlah_unit_kompetensi'))
                    <span class="help-block">
                      <strong>{{ $errors->first('jumlah_unit_kompetensi') }}</strong>
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
  var selected_dpd_id = "";
  @if(Request::old('dpd_id') != NULL)
    selected_dpd_id = {{Request::old('dpd_id')}};
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