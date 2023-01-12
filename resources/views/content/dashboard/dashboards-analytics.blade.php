@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<!-- <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> -->
@endsection

@section('page-script')
<!-- <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script> -->
@endsection

@section('content')

 @php 
    if($rem_collection !=0)
      $collectP =  ($daily_collection/$rem_collection)*100; 
    else
      $collectP = 0;
 
 @endphp
  <div class="row">
      <div class="col-4 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class='bx bx-user' ></i>
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Clients</span>
            <h3 class="card-title mb-2">{{$client_count}}</h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.14%</small>
          </div>
        </div>
      </div>


      <div class="col-4 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Today's Collection</span>
            <h3 class="card-title mb-2">&#8369; {{number_format($daily_collection)}}</h3>
            
            @if($collectP > 90)
                <small class="text-success fw-semibold">
                   <i class='bx bx-up-arrow-alt'></i>
            @elseif($collectP >= 50)
                <small class="text-information fw-semibold">
                    <i class='bx bx-chevron-right'></i>
            @elseif($collectP >=20)
                <small class="text-warning fw-semibold">
                    <i class='bx bx-chevron-right'></i>
            @else
                 <small class="text-danger fw-semibold">
                    <i class='bx bx-chevron-down' ></i>
            @endif
                  {{ number_format($collectP,2)  }} %
            </small>
          </div>
        </div>
      </div>

      <div class="col-4 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                  <a class="dropdown-item" href="javascript:void(0);">View More</a>
                  <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Non Paying</span>
            <h3 class="card-title mb-2">&#8369; {{number_format($rem_collection)}}</h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +28.14%</small>
          </div>
        </div>
      </div>
  </div>
@endsection
