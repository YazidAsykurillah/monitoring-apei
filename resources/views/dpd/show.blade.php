@extends('layouts.app')

@section('page_title')
  {{ $dpd->code }} - {{ $dpd->name }}
@endsection

@section('page_header')
  <h1>
    {{ $dpd->name }}
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('dpd') }}"><i class="fa fa-home"></i> PD</a></li>
    <li class="active"><i></i> {{ $dpd->code }}</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Asesi {{ $dpd->name }}</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table-user">
                <thead>
                  <tr>
                    <th style="width:5%;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>KTP / Passport</th>
                    <th>No HP</th>
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
@endsection

@section('additional_scripts')
 
  <script type="text/javascript">
    var tableUser =  $('#table-user').DataTable({
      processing :true,
      serverSide : true,
      ajax : {
        "url" : '{!! route('datatables.getMembersOfDpd') !!}',
        data: function(d){
          d.dpd_id = '{!! $dpd->id !!}';
        }
      },
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'id_card', name: 'id_card' },
        { data: 'telephone', name: 'telephone' },
      ]
    });

    // Setup - add a text input to each header cell
    $('#searchColumn th').each(function() {
      if ($(this).index() != 0) {
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