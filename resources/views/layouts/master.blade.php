<!DOCTYPE html>
<html ng-app="myApp" ng-cloak>
<head>
    <meta charset="utf-8">
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{config('app.name')}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link type="text/css" rel="stylesheet"
          href="{{URL::asset('assets/administrator/bootstrap/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script>FontAwesomeConfig = {autoReplaceSvg: 'nest'}</script>

    <link type="text/css" rel="stylesheet" href="{{URL::asset('assets/administrator/bootstrap/css/ionicons.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::asset('assets/administrator/dist/css/AdminLTE.min.css')}}">
    <link type="text/css" rel="stylesheet"
          href="{{URL::asset('assets/administrator/dist/css/skins/skin-blue.min.css')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{URL::asset('assets/administrator/bootstrap/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="/assets/css/common.css">
    @stack('styles')
    <script src="/vendors/custom-js/myFunctions.js"></script>
    <script src="{{URL::asset('assets/administrator/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{URL::asset('assets/administrator/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('assets/administrator/dist/js/app.min.js')}}"></script>
    <script src="{{URL::asset('assets/administrator/bootstrap/js/jquery.dataTables.min.js')}}"></script>
    <script src="/vendors/momentjs/moment.min.js"></script>
    {{--angular assets--}}
    <script src="/assets/js/angular.min.js"></script>

    <!-------------------------------- Moment Picker -------------------------------->
    <link rel="stylesheet" href="/vendors/moment-picker/angular-moment-picker.min.css">
    <script src="/vendors/moment-picker/angular-moment-picker.min.js"></script>
    <script src="/vendors/moment-picker/moment-with-locales.js"></script>

    <link rel="stylesheet" href="/vendors/angular-toaster/toaster.min.css">
    <script src="/vendors/angular-toaster/toaster.min.js"></script>

    <script src="/vendors/ui-bootstrap/ui-bootstrap-tpls-1.3.2.min.js"></script>

    <link rel="stylesheet" href="/vendors/angular-xeditable/xeditable.min.css"/>
    <script src="/vendors/angular-xeditable/xeditable.min.js"></script>

    <link rel="stylesheet" href="/vendors/croppie/croppie.css">
    <script src="/vendors/croppie/croppie.js"></script>

    <script src="/assets/js/underscore.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    <script src="//cdn.jsdelivr.net/angular.pusher/latest/pusher-angular.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.slim.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.20.0/select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.20.0/select.min.js"></script>
    <script src="/assets/js/angular-sanitize.min.js"></script>

    <script src="/vendors/angular-custom/angular-custom.js"></script>

    @include('layouts.master-ng-app')

    @stack('head-scripts')
</head>
<body class="hold-transition skin-blue sidebar-mini @stack('body-classes')">
<div class="wrapper">

    @include('layouts.header')
    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.side_panel_upper')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('title')
                <small>@yield('page-description')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
            <toaster-container></toaster-container>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    @include('layouts.footer')
{{--    @include('layouts.side_panel_lower')--}}
</div><!-- ./wrapper -->

@stack('scripts')

</body>
</html>
