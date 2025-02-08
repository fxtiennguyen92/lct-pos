@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Projects') }}</h4>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-t-10">{{ __('Projects') }}</h5>
                    <a href="{{ route('projects.create') }}" class="btn btn-info text-white"><i class="ti-plus"></i> {{ __('Add new') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Project') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <th class="text-center">{{ $project->id }}</th>
                                        <td>{{ $project->code }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>
                                            @if ($project->trashed())
                                                <span class="label label-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="label label-danger">{{ __('Deleted') }}</span>
                                            @endif
                                        </td>
                                        <td>

                                        </td>
                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
@endpush

@push('js')

@endpush
