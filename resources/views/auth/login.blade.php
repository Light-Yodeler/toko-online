<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login</title>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-sm bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800 dark:text-gray-200">Login</h2>
        <form method="POST" action="{{ route('auth.authentication') }}" autocomplete="off">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">email</label>
                <input id="email" name="email" type="text" autocomplete="off"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 py-2 text-gray-800 dark:text-gray-200 focus:border-sky-500 focus:ring focus:ring-sky-200"
                    autofocus>
                @error('email')
                    {{-- {{ dd($message) }} --}}
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input id="password" name="password" type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 py-2 text-gray-800 dark:text-gray-200 focus:border-sky-500 focus:ring focus:ring-sky-200">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-md transition">
                Login
            </button>
        </form>
    </div>
    @if (session('flash'))
        <script>
            // jadikan objek tunggal, bukan array
            window.flashMessage = @json(session('flash'));
        </script>
    @endif
</body>

</html>
