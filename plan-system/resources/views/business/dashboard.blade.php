@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ $project->name }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="row m-t-40">
        
        <!-- Products -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box bg-primary text-center">
                    <h1 class="font-light text-white">1,738</h1>
                    <h6 class="text-white">{{ __('Products') }}</h6>
                </div>
            </div>
        </div>
        <!-- Reservation -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white">1100</h1>
                    <h6 class="text-white">{{ __('Reservation') }}</h6>
                </div>
            </div>
        </div>
        <!-- Clients -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white">964</h1>
                    <h6 class="text-white">{{ __('Clients') }}</h6>
                </div>
            </div>
        </div>
        
        <!-- Accounts -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="card" href="{{ route('project-accounts.index', $project->code) }}">
                <div class="box bg-dark text-center">
                    <h1 class="font-light text-white">2,064</h1>
                    <h6 class="text-white">{{ __('Accounts') }}</h6>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">{{ __('Accounts') }}</h5>
                    <div class="table-responsive m-t-30">
                        <table class="table product-overview">
                            <thead>
                                <tr>
                                    <th>{{ __('Full name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Role') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-12"></div>
    </div>
@endpush

@push('css')
@endpush

@push('js')
@endpush
