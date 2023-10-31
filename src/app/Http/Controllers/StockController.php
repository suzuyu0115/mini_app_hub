<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function toggleStock(Request $request, Product $product)
    {
        $user = Auth::user();

        if ($user->stockedProducts()->where('product_id', $product->id)->exists()) {
            $user->stockedProducts()->detach($product->id);
            $status = 'removed';
        } else {
            $user->stockedProducts()->attach($product->id);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}
