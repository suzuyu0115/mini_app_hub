<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'code_url',
        'content',
        'user_id',
        'image'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
