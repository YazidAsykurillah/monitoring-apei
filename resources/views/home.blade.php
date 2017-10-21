@extends('layouts.app')

@section('page_title')
    Dashboard
@endsection

@section('page_header')
  <h1>
    Dashboard
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="active"><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  </ol>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-search"></i>&nbsp;Search Proposal</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">

          {!! Form::open(['url'=>'home/proposal/search','role'=>'form','class'=>'form-inline','id'=>'form-search-proposal']) !!}
            <label for="memberName">Nama</label>&nbsp;
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <input type="text" class="form-control" id="memberName" name="memberName" placeholder="Nama Member" value="{{ old('memberName') }}">
            </div>

            <label for="memberKTP">&nbsp;KTP / Passport</label>&nbsp;
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <input type="text" class="form-control" id="memberKTP" name="memberKTP" placeholder="Nomor KTP atau Passport" value="{{ old('memberKTP') }}">
            </div>

            <label for=""></label>&nbsp;
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;Search</button>
              
            </div>
            <label for=""></label>&nbsp;
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <a href="{{ url('home')}}" class="btn btn-default">Clear</a>
            </div>
            
          {!! Form::close() !!}
          <p>&nbsp;</p>
          @if(Session::has('userResult'))
            @if(Session::get('userResult')->count())
              @if(Session::get('proposals')->count())
                <table class="table">
                  <thead>
                    <tr>
                      <th>Code</th>
                      <th>Member</th>
                      <th>Identity</th>
                      <th>Created Date</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(Session::get('proposals') as $proposal)
                    <tr>
                      <td>
                        <a href="{{ url('proposal/'.$proposal->id) }}">
                          {{ $proposal->code }}
                        </a>
                      </td>
                      <td>{{ $proposal->user->name }}</td>
                      <td>{{ $proposal->user->ktp }}</td>
                      <td>{{ $proposal->created_at }}</td>
                      <td>{{ proposal_status_display($proposal->status) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <p class="alert alert-info">There is no result</p>
              @endif
            @else
              <p class="alert alert-info">There is no result</p>
            @endif
          @endif

        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
        
        </div>
      </div><!-- /.box -->
    </div>
  </div>

  <div class="row">

    <div class="col-md-3">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $uncomplete_proposal_files }}</h3>
          <p>Berkas Tidak Lengkap</p>
        </div>
        <div class="icon">
          <i class="fa fa-warning"></i>
        </div>
        <a href="{{ URL::to('proposal/?status=2') }}" class="small-box-footer">More info 
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $complete_proposal_files }}</h3>
          <p>Berkas Lengkap</p>
        </div>
        <div class="icon">
          <i class="fa fa-thumbs-up"></i>
        </div>
        <a href="{{ URL::to('proposal/?status=1') }}" class="small-box-footer">More info 
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $sertifikat_sudah_terkirim }}</h3>
          <p>Sertifikat Sudah Terkirim</p>
        </div>
        <div class="icon">
          <i class="fa fa-send"></i>
        </div>
        <a href="{{ URL::to('proposal/?status=9') }}" class="small-box-footer" title="Proposal dengan status Sertifikat Sudah Terkirim">More info 
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $on_process_certificates }}</h3>
          <p>On Process</p>

        </div>
        <div class="icon">
          <i class="fa fa-spin fa-circle-o-notch"></i>
        </div>
        <a href="{{ URL::to('proposal/?status=on_process') }}" class="small-box-footer" title="Proposal dengan status selain Berkas Lengkap, Berkas Tidak Lengkap, dan Sertifikat Sudah Dikirim">More info 
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <i class="fa fa-bar-chart-o"></i>

          <h3 class="box-title">On Process Proposal Chart</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div id="donut-chart" style="height: 400px; padding: 0px; position: relative;">
          <canvas class="flot-base" width="509" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 509.5px; height: 300px;">
          </canvas>
          <canvas class="flot-overlay" width="509" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 509.5px; height: 300px;">
          </canvas>
          </div>
        </div>
        <!-- /.box-body-->
      </div>
    </div>
    
  </div>
@endsection

@section('additional_scripts')
  <script>
  $(function () {
    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
      { label: 'Proses Online DJK', data: {{ $proses_online_djk }}, color: '#65f442' },
      { label: 'Terima Nomer Registrasi', data: {{ $terima_nomer_registrasi }}, color: '#2f472a' },
      { label: 'Cetak Sertifikat', data: {{ $cetak_sertifikat }}, color: '#293e47' },
      { label: 'Penandatangan sertifikat', data: {{ $penandatanganan_sertifikat }}, color: '#56231b' },
      { label: 'Scanning dan tandaterima', data: {{  $scanning_dan_tanda_terima }}, color: '#c1aca8' },
      { label: 'Sertifikat siap dikirim', data:  {{ $sertifikat_siap_kirim }}, color: '#0073b7' },
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 3 / 4,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: true
      }
    })
    /*
     * END DONUT CHART
     */

  })

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:4px; color: #000; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.data[0][1]) + '</div>'
  }
</script>
  
@endsection
