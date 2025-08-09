<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-base-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="shadow bg-base-200">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset


        {{-- Alert Success or Error --}}

        <!-- Page Content -->
        <main>
            <div class="pt-12">
                <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div role="alert" class="alert alert-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div role="alert" class="shadow alert alert-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    {{-- Notify when email is verified by ?verified=1 --}}
                    @if (request()->has('verified') && request('verified') == 1)
                        <div class="p-4 text-green-700 bg-green-100 rounded">
                            {{ __('Your email has been successfully verified.') }}
                        </div>
                    @endif
                </div>
            </div>

            @yield('content')
            {{-- Uncomment the line below if you want to use slots in this layout --}}
            {{ $slot }}
        </main>
    </div>

    {{ $scripts ?? '' }}
</body>

</html>
