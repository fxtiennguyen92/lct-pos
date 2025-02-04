@extends('template.base')

@push('wrapper')
    <!-- Main wrapper -->
    <div id="main-wrapper">
        <!-- Header -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <b>
                            <!-- Dark Logo icon -->
                            {{-- <img src="logo_white.png" alt="{{ config('app.name') }}" class="dark-logo"/> --}}
                            <!-- Light Logo icon -->
                            <img src="logo-light-icon.png" alt="{{ config('app.name') }}" class="light-logo" />
                        </b>
                        <span>
                            <b>{{ config('app.name') }}</b>Admin
                        {{-- <!-- Logo text -->
                            <img src="images/web/LogoTextColorV2.png" alt="Admin Page" class="dark-logo" style="height: 40px" />
                            <!-- Light Logo text -->
                            <img src="images/web/LogoTextColorV2.png" alt="Admin Page" class="light-logo" style="height: 40px" /> --}}
                        </span>
                    </a>
                </div>

                <!-- Navbar -->
                @include('template.components.top-navbar')
            </nav>
        </header>

        <!-- Left sidebar -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        @include('template.components.user-profile')

                        <!-- Sidebar navigation-->
                        @include('template.components.sidebar')
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Page content -->
                @stack('content')
            </div>
        </div>

        <!-- Footer -->
        @include('template.components.footer')
    </div>
@endpush

@prepend('css')
    
@endprepend

@prepend('js')
    <script>
        @if (session('success'))
            $.toast({
                heading: "{{ __('text.messages.success') }}",
                text: "{{ session('success') }}",
                position: 'top-right',
                icon: 'success',
                loader: false,
                hideAfter: 4000,
            });
        @endif

        @if (session('error'))
            $.toast({
                heading: "{{ __('text.messages.error') }}",
                text: "{{ session('error') }}",
                position: 'top-right',
                icon: 'error',
                loader: false,
                hideAfter: 4000,
            });
        @endif


        // $(document).ready(function() {
        //     $('.dropify').dropify({
        //         messages: {
        //             default: "{{ __('text.dropify.messages.default') }}",
        //             replace: "{{ __('text.dropify.messages.replace') }}",
        //             error: "{{ __('text.dropify.messages.error') }}"
        //         }
        //     });
        // });
    </script>
@endprepend
