@yield('css')
<style>
.dataTables_wrapper .dataTables_processing {
    position: fixed !important;
    top: 60% !important;
    background:#F8F8FB;
}
.pac-container {
    z-index: 10000 !important;
}
</style>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
