@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{ __('Categories') }}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item">{{ __('My business') }}</li>
                    <li class="breadcrumb-item">{{ __('Services') }}</li>
                    <li class="breadcrumb-item active">{{ __('Categories') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-header">
                    <span class="card-title text-uppercase">{{ __('Priority') }}</span>
                </div>
                <div class="card-body">
                    @php $nests = $categories->where('active_flg', true); @endphp
                    <div class="myadmin-dd-empty dd" id="cateNestable">
                        <ol class="dd-list">
                            @foreach ($nests as $cate)
                                <li class="dd-item dd3-item" data-id="{{ $cate->id }}">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">{{ $cate->name }}</div>
                                </li>
                                @foreach ($cate->children() as $child)
                                    @if ($loop->first())
                                        <ol class="dd-list">
                                    @endif
                                    <li class="dd-item dd3-item" data-id="{{ $child->id }}">
                                        <div class="dd-handle dd3-handle"></div>
                                        <div class="dd3-content">{{ $child->name }}</div>
                                    </li>
                                    @if ($loop->last())
                        </ol>
                        @endif
                        @endforeach
                        @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="card">
                <div class="card-header">
                    <span class="card-title text-uppercase">{{ __('Categories') }}</span>
                    <div class="card-actions">
                        <a href="{{ route('categories.create', session('projectCode')) }}"
                            class="btn btn-sm btn-info text-white">{{ __('Add new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Category name') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $cate)
                                    <tr>
                                        <td>
                                            <span class="mb-0">{{ $cate->name }}</span>
                                            <div class="text-muted">{!! $cate->description !!}</div>
                                        </td>
                                        <td class="text-center">
                                            @if ($cate->active_flg)
                                                <i class="text-success icon-check" title="{{ __('status.active') }}"></i>
                                            @else
                                                <i class="text-danger icon-close" title="{{ __('status.inactive') }}"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('categories.edit', [session('projectCode'), $cate]) }}"
                                                class="btn btn-sm btn-success text-white me-1 mb-2">{{ __('Modify') }}</a>
                                            <a href="{{ route('categories.edit', [session('projectCode'), $cate]) }}"
                                                class="btn btn-sm btn-info text-white mb-2">{{ __('Services') }}</a>
                                        </td>
                                    </tr>
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
    <link href="assets/node_modules/nestable/nestable.css" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="assets/node_modules/nestable/jquery.nestable.js"></script>
    <script>
        $(document).ready(function() {
            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target);
                var data = list.nestable('serialize');

                $.ajax({
                    url: '/admin/categories/update-order', // Your Laravel route
                    type: 'post',
                    data: {
                        categories: JSON.stringify(data),
                        _token: @json(csrf_token())
                    },
                    success: function(response) {
                        
                    },
                    error: function(xhr) {
                        
                    }
                });
            };

            $('#cateNestable').nestable({
                maxDepth: 1,
            }).on('change', updateOrderDisplay);

        });
    </script>
@endpush
