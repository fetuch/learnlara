<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LearnLara')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow">
        <nav class="mx-auto flex max-w-3xl items-center justify-between p-4">
            <a href="{{ route('transactions.index') }}" class="text-lg font-semibold text-gray-900">LearnLara</a>

            @auth
                <div class="flex items-center gap-4">
                    <a href="{{ route('transactions.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-gray-900">Transakcje</a>
                    <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200">
                            Wyloguj
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-700 hover:text-gray-900">Logowanie</a>
                    <a href="{{ route('register') }}"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Rejestracja</a>
                </div>
            @endguest
        </nav>
    </header>

    <main class="mx-auto max-w-3xl p-6">
        @yield('content')
    </main>
</body>

</html>
