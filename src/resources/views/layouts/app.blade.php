<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:description" content="スナック感覚で楽しめる個人開発サービス投稿サイト" />
        <meta property="og:site_name" content="MiniAppHub" />
        <meta property="og:url" content="http://ec2-35-78-211-144.ap-northeast-1.compute.amazonaws.com:8080" />
        <meta property="og:image" content="https://mini-app-hub.s3.ap-northeast-1.amazonaws.com/kHWuqFHyfQiSGTMeZuDGuUtpXlMLoaWjb0kiDtaE.png" />

        <!-- Twitter-specific tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:image" content="https://mini-app-hub.s3.ap-northeast-1.amazonaws.com/kHWuqFHyfQiSGTMeZuDGuUtpXlMLoaWjb0kiDtaE.png" />
        <meta name="twitter:description" content="スナック感覚で楽しめる個人開発サービス投稿サイト" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
