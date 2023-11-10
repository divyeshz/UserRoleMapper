<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'UserRoleMapper')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->

    {{-- flatpickr --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">

    {{-- tagsinput --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.css') }}">

    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="{{ ('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo3/style.css') }}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <style>
        form .error {
            color: red;
            font-size: 1rem;
            position: unset;
            line-height: unset;
            width: 100%;
        }
        span.star{
            color: red;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">

        <!-- partial:partials/_navbar.html -->
        <div class="horizontal-menu">

            @includeIf('components.header')
            @includeIf('components.sidebar')

        </div>
        <!-- partial -->

        <div class="page-wrapper">

            @yield('content')

            @includeIf('components.footer')

        </div>
    </div>

    <!-- core:js -->
    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ ('assets/js/tags-input.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard-light.js') }}"></script>
    <!-- End custom js for this page -->

    <!-- jquery-validation js -->
    <script src="{{ ('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ ('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>

    @yield('jsContent')

</body>

</html>
