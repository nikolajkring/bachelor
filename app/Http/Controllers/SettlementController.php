<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Kitchen;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    /**
     * Show all credit and debit for the kitchen.
     */
    public function show_settlements($kitchen_id)
    {
        $transactions = Transaction::where('kitchen_id', $kitchen_id)->get();
        $credits = Credit::where('kitchen_id', $kitchen_id)->where('settled', false)->get();
        $debits = Debit::where('kitchen_id', $kitchen_id)->where('settled', false)->get();
        $kitchen = Kitchen::findOrFail($kitchen_id);

        return view('settlements-details', compact('transactions', 'credits', 'debits', 'kitchen'));
    }

    /**
     * Settle transactions for a specific kitchen.
     */
    public function settle_transactions($kitchen_id)
    {
        $transactions = Transaction::where('kitchen_id', $kitchen_id)->get();

        foreach ($transactions as $transaction) {
            $transaction->status = 'settled';
            $transaction->save();
        }

        return redirect()->back()->with('success', 'Transactions settled successfully.');
    }

    /**
     * Settle transactions for a specific user in a specific kitchen.
     */
    public function settle_user($kitchen_id, $user_id)
    {
        $credits = Credit::where('kitchen_id', $kitchen_id)->where('user_id', $user_id)->where('settled', false)->get();
        $debits = Debit::where('kitchen_id', $kitchen_id)->where('user_id', $user_id)->where('settled', false)->get();

        // Perform settlement logic here
        foreach ($credits as $credit) {
            $credit->settled = true;
            $credit->save();
        }

        foreach ($debits as $debit) {
            $debit->settled = true;
            $debit->save();
        }

        return redirect()->back()->with('success', 'Transactions settled successfully.');
    }
}