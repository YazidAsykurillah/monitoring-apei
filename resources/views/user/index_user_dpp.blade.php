@extends('layouts.app')

@section('page_title')
  Administrator DPP
@endsection

@section('page_header')
  <h1>
    Administrator DPP
    <small>List Administrator DPP</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('user-dpp') }}"><i class="fa fa-users"></i> Administrator DPP</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">List Administrator DPP</h3>
              <a href="{{ url('user-dpp/create') }}" class="btn btn-primary pull-right">Add New</a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table-user">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th style="width:10%;text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <thead id="searchColumn">
                    <tr>
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

  <!--Modal Delete User-->
  <div class="modal fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="modal-delete-userLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteUser', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-userLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to delete <b id="user-name-to-delete"></b>
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
  <!--ENDModal Delete User-->
  
@endsection

@section('additional_scripts')
 
  <script type="text/javascript">
    var tableUser =  $('#table-user').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        "url" : '{!! route('datatables.getUserDpps') !!}',
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-body-center' }
      ]
    });

    // Delete button handler
    tableUser.on('click', '.btn-delete-user', function(e){
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#user_id').val(id);
      $('#user-name-to-delete').text(code);
      $('#modal-delete-user').modal('show');
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 4) {
        $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }
          
    });
    //Block search input and select
    $('#searchColumn input').keyup(function() {
      tableUser.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
   
@endsection