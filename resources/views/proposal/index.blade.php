@extends('layouts.app')

@section('page_title')
  Permohonan
@endsection

@section('page_header')
  <h1>
    Permohonan
    <small>Daftar Permohonan</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-newspaper-o"></i> Permohonan</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Permohonan</h3>
              <div class="pull-right">
                @if(\Auth::user()->can('create-proposal'))
                <a href="{{ url('proposal/create') }}" class="btn btn-primary">Add New</a>
                @endif
                <a href="{{ url('proposal/import') }}" class="btn btn-default" title="Clik to import proposal"><i class="fa fa-upload"></i> Import</a>
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-proposal">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width: 10%;">Code</th>
                      <th style="width: 10%;">DPD</th>
                      <th>Member</th>
                      <th>Type</th>
                      <th style="width:10%;">Jumlah Unit Kompetensi</th>
                      <th style="width:10%;">Notes</th>
                      <th style="width:10%;">Created Date</th>
                      <th>Status</th>
                      <th>Status Notes</th>
                      <th>Status DJK</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  
                  <tbody>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    </div>
  </div>

  <!--Modal Delete Proposal-->
  <div class="modal fade" id="modal-delete-proposal" tabindex="-1" role="dialog" aria-labelledby="modal-delete-proposalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteProposal', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-proposalLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="proposal-code-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="proposal_id" name="proposal_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Delete Proposal-->
  
@endsection

@section('additional_scripts')
 
  <script type="text/javascript">
    var tableProposal =  $('#table-proposal').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        "url" : '{!! route('datatables.getProposals') !!}',
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'dpd', name: 'user.dpds.name' },
        { data: 'user', name: 'user.name' },
        { data: 'type', name: 'type' },
        { data: 'jumlah_unit_kompetensi', name: 'jumlah_unit_kompetensi', className:'dt-body-right' },
        { data: 'notes', name: 'notes' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status' },
        { data: 'status_notes', name: 'status_notes' },
        { data: 'status_djk', name: 'status_djk' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' }
      ],
      "order": [[ 7, "desc" ]]
    });

    // Delete button handler
    tableProposal.on('click', '.btn-delete-proposal', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#proposal_id').val(id);
      $('#proposal-code-to-delete').text(code);
      $('#modal-delete-proposal').modal('show');
    });

    // Setup text inputs and select options to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 11) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
      if($(this).index() == 8){
        $(this).html(
          '<select class="form-control" name="status" data-id="'+$(this).index()+'">'+
            '<option value="">All</option>'+
            '<option value="0">Pengajuan Diterima</option>'+
            '<option value="1">Berkas Lengkap</option>'+
            '<option value="2">Berkas Tidak Lengkap</option>'+
            '<option value="3">Proses Online DJK</option>'+
            '<option value="4">Terima Nomer Registrasi</option>'+
            '<option value="5">Cetak Sertifikat</option>'+
            '<option value="6">Penandatangan sertifikat</option>'+
            '<option value="7">Scanning dan tandaterima</option>'+
            '<option value="8">Sertifikat siap kirim</option>'+
            '<option value="9">Sertifikat sudah terkirim</option>'+
            '<option value="10">SELESAI</option>'+
          '</select>'
        );
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableProposal.columns($(this).data('id')).search(this.value).draw();
    });
    $('#searchColumn select').change(function () {
      if($(this).val() == ""){
        tableProposal.columns($(this).data('id')).search('').draw();
      }
      else{
        tableProposal.columns($(this).data('id')).search(this.value).draw();
      }
    });
    //ENDBlock search input and select
    
  </script>
   
@endsection