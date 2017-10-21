@extends('layouts.app')

@section('page_title')
  Proposal | Sertifikat Sudah Terkirim
@endsection

@section('page_header')
  <h1>
    Proposal
    <small>Daftar Proposal Status Sertifikat Sudah Terkirim</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('proposal') }}"><i class="fa fa-newspaper-o"></i> Proposal</a></li>
    <li class="active"><i></i> Sertifikat Sudah Terkirim</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Proposal Status Sertifikat Sudah Terkirim</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-proposal">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width: 10%;">Code</th>
                      <th style="width: 15%;">DPD</th>
                      <th>Member</th>
                      <th>Type</th>
                      <th>Jumlah Unit Kompetensi</th>
                      <th>Notes</th>
                      <th>Status Notes</th>
                      <th>Created Date</th>
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
        "url" : '{!! route('datatables.getProposals_9') !!}',
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'dpd', name: 'user.dpds.name' },
        { data: 'user', name: 'user.name' },
        { data: 'type', name: 'type' },
        { data: 'jumlah_unit_kompetensi', name: 'jumlah_unit_kompetensi' },
        { data: 'notes', name: 'notes' },
        { data: 'status_notes', name: 'status_notes' },
        { data: 'created_at', name: 'created_at' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' }
      ],
      "order": [[ 8, "desc" ]]
    });

    

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 9) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableProposal.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
   
@endsection