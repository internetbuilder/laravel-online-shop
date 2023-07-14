<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="app sidebar-mini rtl">
        {{ $slot }}
</body>
</html>
