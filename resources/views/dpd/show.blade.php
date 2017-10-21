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
    <li><a href="{{ URL::to('dpd') }}"><i class="fa fa-home"></i> DPD</a></li>
    <li class="active"><i></i> {{ $dpd->code }}</li>
  </ol>
@endsection
  
@section('content')
  <div class="row">
    <div class="col-md-4">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>10</h3>

          <p>Users</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-md-4">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>

          <p>Members</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-md-4">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>44</h3>

          <p>Certificates</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
@endsection

@section('additional_scripts')
 
   
@endsection