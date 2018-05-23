@extends('layouts.app')

@section('page_title')
  Daftar PD
@endsection

@section('page_header')
  <h1>
    PD
    <small>Daftar PD</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('dpd') }}"><i class="fa fa-home"></i> PD</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PD</h3>
              <a href="{{ URL::to('dpd/create')}}" class="btn btn-primary pull-right" title="Create new dpd">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-dpd">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Jumlah Asesi</th>
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

  <!--Modal Delete Dpd-->
  <div class="modal fade" id="modal-delete-dpd" tabindex="-1" role="dialog" aria-labelledby="modal-delete-dpdLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteDpd', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-dpdLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="dpd-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="dpd_id" name="dpd_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Delete Dpd-->
@endsection

@section('additional_scripts')
 
   <script type="text/javascript">
    var tableDpd =  $('#table-dpd').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getDpds') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'count_asesis', name: 'count_asesis' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' }
      ]
    });

    // Delete button handler
    tableDpd.on('click', '.btn-delete-dpd', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#dpd_id').val(id);
      $('#dpd-name-to-delete').text(code);
      $('#modal-delete-dpd').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 4) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableDpd.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection