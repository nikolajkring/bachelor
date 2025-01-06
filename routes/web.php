<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettlementController;

// Use the KitchenController to handle the dashboard route
Route::get('/dashboard', [KitchenController::class, 'dashboard'])->name('dashboard');

// route for display of individual kitchen with htmx
Route::get('/kitchen/{id}', [ItemController::class, 'show'])->name('kitchen.show');

// route for displaying kitchen items
Route::get('/kitchen/{id}/items', [ItemController::class, 'indexByKitchen'])->name('kitchen.items');

// route for adding a new item
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::post('/create-kitchen', [KitchenController::class, 'create'])->name('kitchen.create');

// route for deleting an item
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

// route for editing item
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit'); 

// route for updating item
Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');

// join kitchen route
Route::post('/join-kitchen', [KitchenController::class, 'joinKitchen'])->name('kitchen.join');

// delete kitchen
Route::delete('/kitchen/{id}', [KitchenController::class, 'destroy'])->name('kitchen.destroy');


// Route for showing transactions for a specific kitchen
Route::get('/transactions/{kitchen_id}', [TransactionController::class, 'show_transaction'])->name('transactions.show_transaction');

// Route for showing transactions for a specific user in a specific kitchen
Route::get('/transactions/{kitchen_id}/{user_id}', [TransactionController::class, 'show_user_transaction'])->name('transactions.show_user_transaction');

// Route for showing settlements for a specific kitchen
Route::get('/settlements/{kitchen_id}', [SettlementController::class, 'show_settlements'])->name('settlements.show_settlements');

// Route for settling transactions page
Route::post('/settlements/{kitchen_id}', [SettlementController::class, 'settle_transactions'])->name('settlements.settle_transactions');

// Route for user to settle account
Route::post('/settlements/{kitchen_id}/{user_id}', [SettlementController::class, 'settle_user'])->name('settlements.settle_user');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/seed-database', function () {
    Artisan::call('db:seed');
    return 'Database seeded!';
});

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::post('/items/decrement/{id}', [ItemController::class, 'decrement'])->name('items.decrement');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
