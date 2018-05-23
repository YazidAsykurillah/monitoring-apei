@extends('layouts.app')

@section('page_title')
  Rekapitulasi
@endsection

@section('page_header')
  <h1>
    Rekapitulasi
    <small>Daftar Rekapitulasi</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-newspaper-o"></i> Rekapitulasi</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Rekapitulasi</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-proposal">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width: 10%;">KTP</th>
                      <th style="width: 10%;">Alamat</th>
                      <th>Tempat Tanggal Lahir</th>
                      <th>Nama</th>
                      <th style="width:10%;">Nomor Registrasi</th>
                      <th style="width:10%;">Daerah</th>
                      <th style="width:10%;">Status Pengajuan</th>
                      <th style="width:10%;">Tahun</th>
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

 
  
@endsection

@section('additional_scripts')
 
  <script type="text/javascript">
    var tableProposal =  $('#table-proposal').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        "url" : '{!! route('datatables.getProposalRekapitulasi') !!}',
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        {data: 'KTP', name: 'KTP'},
        {data: 'Alamat', name: 'Alamat'},
        {data: 'Tempat_Tanggal_Lahir', name: 'Tempat_Tanggal_Lahir'},
        {data: 'Nama', name: 'Nama'},
        {data: 'No_Register', name: 'No_Register'},
        {data: 'Daerah', name: 'Daerah'},
        {data: 'Status_Pengajuan', name: 'Status_Pengajuan'},
        {data: 'Tahun', name: 'Tahun', searchable:false, orderable:false},
        
      ],
      "order": [[ 5, "desc" ]]
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
      if ($(this).index() != 0 && $(this).index() != 8) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
      if($(this).index() == 7){
        $(this).html(
          '<select class="form-control" name="status" data-id="'+$(this).index()+'">'+
            '<option value="">All</option>'+
            '<option value="1">Baru</option>'+
            '<option value="2">Penyetaraan</option>'+
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