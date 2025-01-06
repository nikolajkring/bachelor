<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_kitchen');
    }
}