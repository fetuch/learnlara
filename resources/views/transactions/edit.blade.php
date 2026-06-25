@extends('app')

@section('title', 'Edycja transakcji')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Edycja transakcji</h1>
        <a href="{{ route('transactions.index') }}" class="text-sm text-gray-500 hover:underline">← Wróć</a>
    </div>

    <x-transaction-form :transaction="$transaction" :action="route('transactions.update', $transaction)" method="PUT" />
@endsection
