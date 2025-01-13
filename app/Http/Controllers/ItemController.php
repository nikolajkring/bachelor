<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kitchen;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Credit;
use App\Models\Debit;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function indexByKitchen($kitchenId)
    {
        $items = Item::where('kitchen_id', $kitchenId)->get();
        return view('items.index', compact('items'));
    }

    public function show($id)
    {
        $kitchen = Kitchen::findOrFail($id);
        $items = Item::where('kitchen_id', $id)->get();
        return view('kitchen-details', compact('kitchen', 'items'));
    }

    public function decrement(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $amount_bought = $request->input('amount_bought');

        $request->validate([
            'amount_bought' => 'required|integer',
        ]);

        if ($item->amount >= $amount_bought) {
            $item->amount -= $amount_bought;
            $item->save();

            // Create a new transaction record
            Transaction::create([
                'item_id' => $item->id,
                'kitchen_id' => $item->kitchen_id,
                'user_id' => Auth::id(), 
                'price' => $item->price,
                'amount' => $amount_bought,
                'total' => $item->price * $amount_bought,
            ]);

            // Create credit record
            Credit::create([
                // get the last transaction id
                'transaction_id' => Transaction::latest()->first()->id,
                'kitchen_id' => $item->kitchen_id,
                // get the last transactions user_id
                'user_id' => Transaction::latest()->first()->user_id,
                'total' => $item->price * $amount_bought,
            ]);

            // Create debit record
            Debit::create([
                // get the last transaction id
                'transaction_id' => Transaction::latest()->first()->id,
                'kitchen_id' => $item->kitchen_id,
                // get the last transactions user_id
                'user_id' => Transaction::latest()->first()->user_id,
                // make the total negative because it's a cost for the kitchen
                'total' => ($item->price * $amount_bought) * -1,
            ]);
        }

        return response()->json($item->amount);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kitchen_id' => 'required|exists:kitchens,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'amount' => 'required|integer',
        ]);

        
        $item = new Item($request->all());
        $item->user_id = Auth::id();
        $item->kitchen_id = $request->kitchen_id;
        $item->save();
        
        $amount_bought = $request->input('amount_bought');
        $items = Item::where('kitchen_id', $request->kitchen_id)->get();

        // Create a new transaction record
        Transaction::create([
            'item_id' => $item->id,
            'kitchen_id' => $item->kitchen_id,
            'user_id' => Auth::id(), 
            'price' => $item->price,
            'amount' => $amount_bought,
            'total' => $item->price * $amount_bought,
        ]);

        // Create debit record
        Debit::create([
            // get the last transaction id
            'transaction_id' => Transaction::latest()->first()->id,
            'kitchen_id' => $item->kitchen_id,
            // get the last transactions user_id
            'user_id' => Transaction::latest()->first()->user_id,
            // make the total negative because it's a cost for the kitchen
            'total' => $item->price * $amount_bought,
        ]);

        // Create credit record
        Credit::create([
            // get the last transaction id
            'transaction_id' => Transaction::latest()->first()->id,
            'kitchen_id' => $item->kitchen_id,
            // get the last transactions user_id
            'user_id' => Transaction::latest()->first()->user_id,
            // make the total negative because it's a cost for the kitchen
            'total' => ($item->price * $amount_bought) * -1,
        ]);

        return view('partials.items', compact('items'));
    }
}
