<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

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

    public function index(Request $request)
    {
        $user = Auth::user();

        // ユーザーがストックした製品のクエリを構築
        $query = $user->stockedProducts()->with('tags')->orderBy('created_at', 'desc');

        // 検索キーワードが存在する場合、製品名でフィルタリング
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // タグによる絞り込み
        if ($request->tag_id) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->tag_id);
            });
        }

        $stocks = $query->paginate(15);

        return view('stock.index', compact('stocks'));
    }
}
