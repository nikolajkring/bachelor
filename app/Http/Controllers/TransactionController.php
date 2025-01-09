<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Kitchen;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'kitchen_id' => 'required|exists:kitchens,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
            'amount' => 'required|integer',
            'total' => 'required|numeric',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'kitchen_id' => 'required|exists:kitchens,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
            'amount' => 'required|integer',
            'total' => 'required|numeric',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

     /**
     * Show transactions for a specific kitchen.
     */
    public function show_transaction($kitchen_id)
    {
        // Get all transactions for the kitchen
        $transactions = Transaction::where('kitchen_id', $kitchen_id)->get();
        $credits = Credit::where('kitchen_id', $kitchen_id)->where('settled', false)->get();
        $debits = Debit::where('kitchen_id', $kitchen_id)->where('settled', false)->get();
        $kitchen = Kitchen::findOrFail($kitchen_id);

        return view('transactions-details', compact('transactions', 'credits', 'debits', 'kitchen'));
    }

    /**
     * Show transactions for a specific user in a specific kitchen.
     */
    public function show_user_transaction($kitchen_id, $user_id)
    {
        $kitchen = Kitchen::findOrFail($kitchen_id);
        $transactions = Transaction::where('kitchen_id', $kitchen_id)->where('user_id', $user_id)->get();
        $credits = Credit::where('kitchen_id', $kitchen_id)->where('user_id', $user_id)->where('settled', false)->get();
        $debits = Debit::where('kitchen_id', $kitchen_id)->where('user_id', $user_id)->where('settled', false)->where('total', '>', 0)->get();

  

        return view('user_transactions-details', compact('kitchen', 'transactions', 'credits', 'debits'));
    }

}