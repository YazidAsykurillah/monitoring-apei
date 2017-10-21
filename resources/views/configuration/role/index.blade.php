@extends('layouts.app')

@section('page_title')
  Comfiguration | Roles
@endsection

@section('page_header')
  <h1>
    Configuration
    <small>Role</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('#') }}"><i class="fa fa-cog"></i> Configuration</a></li>
    <li class="active"><i></i> Roles</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
        <div class="box-header with-border">
          <h3 class="box-title">Roles List</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="display" id="table-role">
            <thead>
              <tr>
                <th style="width:5%;background-color:#3c8dbc;color:white">#</th>
                <th style="width:80%;background-color:#3c8dbc;color:white">Role Name</th>
                <th style="width:15%;text-align:center;background-color:#3c8dbc;color:white">Actions</th>
              </tr>
            </thead>
            <thead id="searchid">
              <tr>
                <th style="width:5%;"></th>
                <th style="width:80%;">Role Name</th>
                <th style="width:15%;text-align:center;"></th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix"></div>
      </div><!-- /.box -->
    </div>
</div>

@endsection

@section('additional_scripts')
  <script type="text/javascript">
  var tableRole =  $('#table-role').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getRoles') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:false},
        { data: 'name', name: 'name' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, class:'dt-body-center' },
      ],

    });

    // Delete button handler
    tableRole.on('click', '.btn-delete-role', function(e){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#role_id').val(id);
      $('#role-name-to-delete').text(name);
      $('#modal-delete-role').modal('show');
    });

      // Setup - add a text input to each header cell
      $('#searchid th').each(function() {
            if ($(this).index() != 0 && $(this).index() != 2) {
                $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
            }

      });
      //Block search input and select
      $('#searchid input').keyup(function() {
        tableRole.columns($(this).data('id')).search(this.value).draw();
      });
      //ENDBlock search input and select
  </script>
@endsection