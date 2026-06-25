@props([
    'transaction' => null,   // edit przekaże obiekt; create zostawi null
    'action',                // route store albo update
    'method' => 'POST',      // 'POST' dla create, 'PUT' dla edit
])

<form method="POST" action="{{ $action }}"
        class="space-y-5 rounded-xl bg-white p-6 shadow">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- Tytuł --}}
    <div>
        <label for="title" class="mb-1 block text-sm font-medium">Tytuł</label>
        <input type="text" name="title" id="title" value="{{ old('title', $transaction?->title) }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kwota: na razie wpisywana w GROSZACH (patrz uwaga w czacie) --}}
    <div>
        <label for="amount" class="mb-1 block text-sm font-medium">Kwota (w groszach)</label>
        <input type="number" name="amount" id="amount" value="{{ old('amount', $transaction?->amount) }}" min="1"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        @error('amount')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Typ: @selected to dyrektywa Blade (L9+) zamiast ręcznego ternary --}}
    <div>
        <label for="type" class="mb-1 block text-sm font-medium">Typ</label>
        <select name="type" id="type"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
            <option value="expense" @selected(old('type', $transaction?->type) === 'expense')>Wydatek</option>
            <option value="income" @selected(old('type', $transaction?->type) === 'income')>Przychód</option>
        </select>
        @error('type')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Data --}}
    <div>
        <label for="occurred_on" class="mb-1 block text-sm font-medium">Data</label>
        <input type="date" name="occurred_on" id="occurred_on" value="{{ old('occurred_on', $transaction?->occurred_on?->format('Y-m-d')) }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        @error('occurred_on')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Opis (textarea: old() MUSI być tuż po > bez spacji, inaczej doda whitespace) --}}
    <div>
        <label for="description" class="mb-1 block text-sm font-medium">Opis (opcjonalnie)</label>
        <textarea name="description" id="description" rows="3"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">{{ old('description', $transaction?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
        Zapisz
    </button>
</form>