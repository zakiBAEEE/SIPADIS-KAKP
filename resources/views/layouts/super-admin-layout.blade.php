<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipadis</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="h-full bg-[#D9EAFD] flex ">
    <div class="w-[280px] ">
        @include('components.layout.nav')
    </div>
    <div class=" p-4 min-w-4/5">
        @yield('content')
    </div>
    @stack('scripts')
</body>

</html>
