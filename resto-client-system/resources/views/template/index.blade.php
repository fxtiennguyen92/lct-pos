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
                            <img src="logo.png" alt="Admin Page" class="dark-logo" style="height: 40px" />
                            <!-- Light Logo icon -->
                            <img src="logo.png" alt="Admin Page" class="light-logo" style="height: 40px" />
                        </b>
                        <span class="text-dark">
                            Trang Quản Trị
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
                <!-- User Profile-->
                @include('template.components.user-profile')

                <!-- Sidebar navigation-->
                @include('template.components.sidebar')
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
    <link href="assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="assets/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet">
    <link href="assets/node_modules/gridstack/gridstack.css" rel="stylesheet">
    <link href="dist/css/pages/ribbon-page.css" rel="stylesheet">
    <link href="dist/css/pages/other-pages.css" rel="stylesheet">
    <script>
        function addDefaultImage(img) {
            img.src = "images/default/bg_image.png"
        }
    </script>
@endprepend

@prepend('js')
    <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/waves.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>

    <script src="assets/node_modules/skycons/skycons.js"></script>
    <script src="assets/node_modules/raphael/raphael-min.js"></script>
    <script src="assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="assets/node_modules/toast-master/js/jquery.toast.js"></script>
    <script src="assets/node_modules/dropify/dist/js/dropify.min.js"></script>

    

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


        $(document).ready(function() {
            $('.dropify').dropify({
                messages: {
                    default: "{{ __('text.dropify.messages.default') }}",
                    replace: "{{ __('text.dropify.messages.replace') }}",
                    error: "{{ __('text.dropify.messages.error') }}"
                }
            });
        });
    </script>
@endprepend
