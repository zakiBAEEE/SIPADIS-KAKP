<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipadis</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="min-h-screen h-full bg-[#D9EAFD] flex">

    <!-- Sidebar -->
    @include('components.layout.nav')

    <!-- Konten utama -->
    <main class="flex-1 overflow-auto p-4 h-full pt-20 lg:pt-0">
        <div class="max-w-7xl mx-auto h-full">
            @yield('content')
        </div>
    </main>

</body>



</html>
