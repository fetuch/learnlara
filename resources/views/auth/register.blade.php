@extends('app')

@section('title', 'Rejestracja')

@section('content')

    <form method="POST" action="{{ route('register') }}" class="space-y-5 rounded-xl bg-white p-6 shadow">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="mb-1 block text-sm font-medium">Imię</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="mb-1 block text-sm font-medium">Hasło</label>
            <input type="password" name="password" id="password" value=""
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Confirmation --}}
        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium">Powtórz hasło</label>
            <input type="password" name="password_confirmation" id="password_confirmation" value=""
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        </div>

        <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
            Zarejestruj się
        </button>
    </form>
@endsection
