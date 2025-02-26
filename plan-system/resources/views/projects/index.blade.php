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
                    <h5 class="card-title text-uppercase m-t-10">{{ __('Projects') }}</h5>
                    <a href="{{ route('projects.create') }}" class="btn btn-info text-white"><i class="ti-plus"></i>
                        {{ __('Add new') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Projects') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Last modified') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr class="clickable-row" data-href="{{ route('projects.edit', $project) }}">
                                        <th class="text-center">{{ $project->id }}</th>
                                        <td>{{ $project->code }}</td>
                                        <th>
                                            <a class="text-dark"
                                                href="{{ route('projects.edit', $project) }}">{{ $project->name }}</a>
                                        </th>
                                        <td class="text-center">
                                            @if ($project->status == App\ProjectStatusEnum::SETTING_UP->value)
                                                <span
                                                    class="label label-warning">{{ App\ProjectStatusEnum::SETTING_UP->label() }}</span>
                                            @elseif ($project->status == App\ProjectStatusEnum::ACTIVE->value)
                                                <span
                                                    class="label label-success">{{ App\ProjectStatusEnum::ACTIVE->label() }}</span>
                                            @elseif ($project->status == App\ProjectStatusEnum::INACTIVE->value)
                                                <span
                                                    class="label label-danger">{{ App\ProjectStatusEnum::INACTIVE->label() }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $project->updated_at->format('m-d-Y H:i') }}</td>
                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $projects->links() }}
                        </div>
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
