<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="bg-black text-white">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4 py-5">
            <h1 class="text-3xl">
                <a href="/" wire:navigate>Todo</a>
            </h1>
            <div>
                <a href="/categories" wire:navigate>カテゴリ一覧</a>
            </div>
        </div>
    </header>

    {{ $slot }}
</body>

</html>