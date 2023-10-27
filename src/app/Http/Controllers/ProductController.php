<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function __construct()
    {
        // index アクションのみ認証を必要としないように設定
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        $user=auth()->user();
        return view('product.index', compact('products', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
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
        return redirect()->route('product.index')->with('message', 'アプリを投稿しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
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

        return redirect()->route('product.show', $product)->with('message', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
