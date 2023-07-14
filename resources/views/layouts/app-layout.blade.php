<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>
<body class="app sidebar-mini rtl">
    @include('./admin.partials.header')
    @include('./admin.partials.sidebar')

    <main class="app-content">
        {{ $slot }}
    </main>
    
    <script src={{ asset("dashboard/js/popper.min.js")}}></script>
    <script src={{ asset("dashboard/js/jquery-3.2.1.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/bootstrap-datepicker.min.js")}}></script>
    <script src={{ asset("dashboard/js/bootstrap.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/bootstrap-notify.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/dataTables.bootstrap.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/chart.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/fullcalendar.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/jquery-ui.custom.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/jquery.dataTables.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/jquery.vmap.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/jquery.vmap.sampledata.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/jquery.vmap.world.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/jquery.vmap.world.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/pace.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/select2.min.js")}}></script>
    <script src={{ asset("dashboard/js/plugins/sweetalert.min.js")}}></script>
    <script src={{ asset("dashboard/js/main.js")}}></script>

    
    @livewireScripts

</body>
</html>
