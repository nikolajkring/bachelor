<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'amount',
        'kitchen_id',
        'user_id', 
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
        
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}