<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'kitchen_id',
        'user_id',
        'price',
        'amount',
        'total',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}