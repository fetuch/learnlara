@use(App\Enums\TransactionType)

@extends('app')

@section('title', 'Transakcje')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Transakcje</h1>
        <a href="{{ route('transactions.create') }}"
            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            + Dodaj
        </a>
    </div>

    {{-- flash message ustawiony przez redirect()->with('success', ...) w store() --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-xl bg-white shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3 font-medium">Data</th>
                    <th class="px-4 py-3 font-medium">Tytuł</th>
                    <th class="px-4 py-3 font-medium">Typ</th>
                    <th class="px-4 py-3 text-right font-medium">Kwota</th>
                    <th class="px-4 py-3 text-right font-medium">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($transactions as $transaction)
                    <tr>
                        {{-- occurred_on jest castowane na Carbon (date), więc mamy ->format() --}}
                        <td class="px-4 py-3 text-gray-500">{{ $transaction->occurred_on->format('d.m.Y') }}</td>
                        <td class="px-4 py-3 font-medium">{{ $transaction->title }}</td>
                        <td class="px-4 py-3">
                            @if ($transaction->type === TransactionType::Income)
                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-700">Przychód</span>
                            @else
                                <span class="rounded-full bg-red-100 px-2 py-1 text-xs text-red-700">Wydatek</span>
                            @endif
                        </td>
                        {{-- grosze -> złotówki dopiero TU, w warstwie prezentacji --}}
                        <td class="px-4 py-3 text-right font-mono">
                            {{ number_format($transaction->amount / 100, 2, ',', "\u{00A0}") }} zł
                        </td>
                        <td>
                            <a href="{{ route('transactions.edit', $transaction) }}" class="">
                                Edytuj
                            </a>

                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}"
                                onsubmit="return confirm('Na pewno?')">
                                @csrf
                                @method('DELETE') {{-- to "podszywa" POST pod DELETE --}}
                                <button type="submit">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            Brak transakcji. Dodaj pierwszą.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
