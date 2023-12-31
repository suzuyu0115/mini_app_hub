<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;


class ProductController extends Controller
{
    public function __construct()
    {
        // index アクションのみ認証を必要としないように設定
        $this->middleware('auth')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('tags')->orderBy('created_at', 'desc');

        // 検索キーワードが存在する場合、クエリを追加
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // タグの絞り込み
        if ($request->tag_id) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->tag_id);
            });
        }

        $products = $query->paginate(15);

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('product.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|max:255',
            'url' => 'required|max:1000',
            'code_url' => 'max:1000',
            'content' => 'required|max:1000',
            'image' => 'image'
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->url = $request->input('url');
        $product->code_url = $request->input('code_url');
        $product->content = $request->input('content');
        $product->user_id = auth()->user()->id;

        if ($request->has('image')) {
            if (app()->isLocal()) {
                // ローカル環境での処理
                $original = $request->file('image')->getClientOriginalName();
                $name = date('Ymd_His').'_'.$original;
                $request->file('image')->move(public_path('storage/images'), $name);
                $product->image = $name;
            } else {
                // 本番環境での処理
                $path = Storage::disk('s3')->putFile('/', $request->file('image'), 'public');
                $product->image = Storage::disk('s3')->url($path);
            }
        }

        $product->save();

        $tags = $request->input('tag');
        if (!empty($tags)) {
            $product->tags()->attach(array_keys($tags));
        }

        return redirect()->route('product.index')->with('message', 'アプリを投稿しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('tags');
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return redirect()->back()->with('message', '編集権限がありません');
        }
        $tags = Tag::all();
        return view('product.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $inputs=$request->validate([
            'name' => 'required|max:255',
            'url' => 'required|max:1000',
            'code_url' => 'max:1000',
            'content' => 'required|max:1000',
            'image' => 'image'
        ]);

        $product->name=$inputs['name'];
        $product->url=$inputs['url'];
        $product->code_url=$inputs['code_url'];
        $product->content=$inputs['content'];

        if ($request->has('image')) {
            if (app()->isLocal()) {
                // ローカル環境での処理
                $original = $request->file('image')->getClientOriginalName();
                $name = date('Ymd_His').'_'.$original;
                $request->file('image')->move(public_path('storage/images'), $name);
                $product->image = $name;
            } else {
                // 本番環境での処理
                $path = Storage::disk('s3')->putFile('/', $request->file('image'), 'public');
                $product->image = Storage::disk('s3')->url($path);
            }
        }

        $product->save();

        $tags = $request->input('tag', []);

        $product->tags()->sync($tags);

        return redirect()->route('product.show', $product)->with('message', 'アプリを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('message', 'アプリを削除しました');
    }

    public function myProducts(Request $request)
    {
        $user = Auth::user();
        $query = $user->products()->with('tags')->orderBy('created_at', 'desc');

        // 検索キーワードが存在する場合、クエリを追加
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // タグによる絞り込み
        if ($request->tag_id) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('id', $request->tag_id);
            });
        }

        $myProducts = $query->paginate(15);

        return view('product.myProduct', compact('myProducts'));
    }
}
