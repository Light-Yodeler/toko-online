<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <!-- component -->
    <div class="min-h-screen bg-gray-50/50">
        {{-- sidebar --}}
        @include('layouts.partials.sidebar')
        {{-- end sidebar --}}
        <div class="p-4 xl:ml-80">
            {{-- navbar --}}
            @include('layouts.partials.header')
            {{-- end navbar --}}
            <div class="mt-12">
                {{-- content --}}
                @yield('content')
                {{-- end content --}}
                {{-- footer --}}
                @include('layouts.partials.footer')
                {{-- end footer --}}
            </div>
        </div>

</body>

</html>
