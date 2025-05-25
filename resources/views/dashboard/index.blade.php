@extends('layouts.dashboard')

@section('content')
    <?php
    $departments = App\Models\Department::get();
    $archive_documents = App\Models\Document::onlyTrashed()->get();
    $documents = App\Models\Document::get();
    $external_files = App\Models\UploadPdf::get();
    $users = App\Models\User::get();
    ?>
    <div class="page-breadcrumb" >
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('dashboard.dashboard') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-image: url({{ asset('assets/images/main_logo.jpg') }})">
        <div class="card-group">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-danger">
                                <i class="ti-clipboard text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ __('departments.count') }}
                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $departments->count() ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg btn-info">
                                <i class="mdi mdi-file text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ __('documents.count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $documents->count() ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="mdi mdi-file text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ __('documents.external_count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $external_files->count() ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-warning">
                                <i class="mdi mdi-currency-usd text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ __('documents.archive_count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $archive_documents->count() ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Column -->


        </div>
        <div class="card-group">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-secondary">
                                <i class="fa fa-users text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ __('documents.users_count') }}
                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $users->count() ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
        </div>

        {{-- <div class="row d-flex justify-content-center">
            <!-- Column -->
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center">
                            <div>
                                <h4 class="card-title">{{ __('documents.count') }}</h4>
                                <h5 class="card-subtitle">Overview of Latest Month</h5>
                            </div>
                            <div class="ml-auto">
                                <ul class="list-inline font-12 dl m-r-10">
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-info"></i> {{ __('documents.all_documents') }}
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-danger"></i> {{ __('documents.archive_count') }}
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="fas fa-dot-circle text-success"></i> {{ __('documents.external_count') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="product-sales_new" style="height:305px"></div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection
@section('js')
    <script>
        Morris.Area({
            element: 'product-sales_new',
            data: [{
                    period: '2012',
                    iphone: 50,
                    ipad: 80,
                    itouch: 20
                },
                {
                    period: '2013',
                    iphone: 130,
                    ipad: 100,
                    itouch: 80
                },
                {
                    period: '2014',
                    iphone: 80,
                    ipad: 60,
                    itouch: 70
                },
                {
                    period: '2015',
                    iphone: 70,
                    ipad: 200,
                    itouch: 140
                },
                {
                    period: '2016',
                    iphone: 180,
                    ipad: 150,
                    itouch: 140
                },
                {
                    period: '2017',
                    iphone: 105,
                    ipad: 100,
                    itouch: 80
                },
                {
                    period: '2018',
                    iphone: 250,
                    ipad: 150,
                    itouch: 200
                }
            ],
            xkey: 'period',
            ykeys: ['iphone', 'ipad'],
            labels: ['iPhone', 'iPad'],
            pointSize: 2,
            fillOpacity: 0,
            pointStrokeColors: ['#ccc', '#4798e8', '#9675ce'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 2,
            hideHover: 'auto',
            lineColors: ['#ccc', '#4798e8', '#9675ce'],
            resize: true
        });
    </script>
@endsection
