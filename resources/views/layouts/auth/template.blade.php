<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('template') }}/assets/img/favicon.png">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/bootstrap.min.css">

    <!-- Jquery UI CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/jquery-ui.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/select2.min.css">

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/toastr-new/toastr.min.css">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/plugins/datatables/datatables.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/feather.css">

    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/custom.css">

    <style>
        .form-title {
            margin-bottom: 24px;
        }
    </style>
</head>

<body>

    <!-- Main Wrapper -->
    @yield('content')

    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('template') }}/assets/js/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('template') }}/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Js -->
    <script src="{{ asset('template') }}/assets/js/feather.min.js"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('template') }}/assets/js/jquery.slimscroll.js"></script>

    <!-- Select2 Js -->
    <script src="{{ asset('template') }}/assets/js/select2.min.js"></script>

    <!-- Datatables JS -->
    <script src="{{ asset('template') }}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/assets/plugins/datatables/datatables.min.js"></script>

    <!-- counterup JS -->
    <script src="{{ asset('template') }}/assets/js/jquery.waypoints.js"></script>
    <script src="{{ asset('template') }}/assets/js/jquery.counterup.min.js"></script>

    <!-- Apexchart JS -->
    <script src="{{ asset('template') }}/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ asset('template') }}/assets/plugins/apexchart/chart-data.js"></script>

    <!-- Datepicker Core JS -->
    <script src="{{ asset('template') }}/assets/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="{{ asset('template') }}/assets/plugins/toastr-new/toastr.min.js"></script>
    <script src="{{ asset('template') }}/assets/plugins/sweetalert-1/sweetalert.min.js"></script>

    <script src="{{ asset('template') }}/assets/js/jquery.loading.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('template') }}/assets/js/toastrconfig.js"></script>
    <script src="{{ asset('template') }}/assets/js/custom.js"></script>
    <script src="{{ asset('template') }}/assets/js/app.js"></script>

    @stack('script')
</body>

</html>
