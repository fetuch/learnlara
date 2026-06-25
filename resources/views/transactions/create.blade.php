@extends('app')

@section('title', 'Nowa transakcja')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Nowa transakcja</h1>
        <a href="{{ route('transactions.index') }}" class="text-sm text-gray-500 hover:underline">← Wróć</a>
    </div>

    <x-transaction-form :action="route('transactions.store')" />
@endsection
