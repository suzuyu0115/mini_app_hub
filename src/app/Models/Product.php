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

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function stockedByUsers() {
        return $this->belongsToMany(User::class, 'stocks');
    }

    // ストックされているかを判定するメソッド。
    public function isStockedBy($user): bool {
        if (is_null($user)) {
            return false;
        }
        return Stock::where('user_id', $user->id)->where('product_id', $this->id)->first() !== null;
    }
}
