@extends('Admin.main')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Menu</div>
                            <div class="h1 mb-0 font-weight-bold text-gray-800">
                                {{ $menus }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coffee fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Meja</div>
                            <div class="h1 mb-0 font-weight-bold text-gray-800">
                                {{ $tables }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-th-large fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kuota Meja
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h7 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $available_tables }}
                                        of
                                        {{ $tables }}
                                    </div>
                                </div>                                                              
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="col mt-3">
                        <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width:{{ $available_tables==0?0:$available_tables/$tables*100 }}%"
                                aria-valuenow="{{ $available_tables==0?0:$available_tables/$tables*100 }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Order Live Aprroved
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h7 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $approved_order_lives }}
                                        of
                                       {{ $order_lives}}
                                    </div>
                                </div>                                                              
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sign-language fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="col mt-3">
                        <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width:{{ $approved_order_lives==0?0:$approved_order_lives/$order_lives*100 }}%"
                                aria-valuenow="{{ $approved_order_lives==0?0:$approved_order_lives/$order_lives*100 }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-12">            
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h4 class="center mb-0 text-primary">Grafik Formasi Tenaga Kerja Unit</h4>
                        <a href="{{ url('ftk/ftk') }}" class="btn btn-sm btn-primary">Selengkapnya</a>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <canvas id="ftkChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    

    {{-- @if(Sentinel::getUser()->inRole('super-admin')||Sentinel::getUser()->inRole('wakil-rektor-akademik'))
    @include('Admin.SUPER.dashboard-detail.super-dash')
    @endif --}}

    @if((Sentinel::getUser()->inRole('prodi-admin')))
    {{-- @include('Admin.PRODI.dashboard-detail.prodi-dash') --}}
    @endif

    @if((Sentinel::getUser()->inRole('mahasiswa')))
    {{-- @include('Admin.MAHASISWA.dashboard-detail.mahasiswa-dash') --}}
    @endif

    @if((Sentinel::getUser()->inRole('bau-admin')))
    {{-- @include('Admin.BAU.dashboard-detail.bau-admin-dash') --}}
    @endif



</div>
<!-- /.container-fluid -->
@endsection
@section('script')

@endsection