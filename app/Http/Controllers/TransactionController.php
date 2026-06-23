<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('occurred_on', 'desc')->orderBy('id', 'desc')->get();
        
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    public function store(StoreTransactionRequest $request)
    {        
        Transaction::create($request->validated());

        return redirect()->route('transactions.index')->with('success', 'Transakcja dodana');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        return redirect()->route('transactions.index')->with('success', 'Transakcja zaktualizowana');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transakcja usunięta');
    }
}
