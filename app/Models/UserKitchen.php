<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKitchen extends Model
{
    use HasFactory;

    protected $table = 'user_kitchen';
    protected $fillable = ['user_id', 'kitchen_id', 'is_owner'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
