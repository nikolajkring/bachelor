<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'kitchen_id',
        'user_id',
        'total',
        'settled',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}