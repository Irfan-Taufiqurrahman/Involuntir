<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') ?? 'Peduly' }}</title>

    {{-- Noble UI --}}
    <!-- core:css -->


    <link rel="stylesheet" href="{{ asset('nobleui/vendors/core/core.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    {{-- <link rel="stylesheet" href="{{ asset('nobleui/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}"> --}}
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('nobleui/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('nobleui/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('nobleui/css/demo_1/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('nobleui/images/favicon.png') }}">

    {{-- Tailwind --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    {{-- font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.css">

</head>

<body class="sidebar-dark">
    @yield('body')

    <!-- core:js -->
    <script src="{{ asset('nobleui/vendors/core/core.js') }}"></script>
    <!-- endinject -->

    <!-- plugin js for this page -->
    <script src="{{ asset('nobleui/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('nobleui/vendors/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('nobleui/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('nobleui/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('nobleui/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('nobleui/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <!-- end plugin js for this page -->

    <!-- inject:js -->
    <script src="{{ asset('nobleui/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('nobleui/js/template.js') }}"></script>
    <!-- endinject -->

    <!-- custom js for this page -->
    <script src="{{ asset('nobleui/js/dashboard.js') }}"></script>
    <script src="{{ asset('nobleui/js/datepicker.js') }}"></script>
    <!-- end custom js for this page -->

    {{-- Datatables --}}
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });

        });
    </script>

    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</body>

</html>
