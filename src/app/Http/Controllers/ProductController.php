<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'image' => 'image | max:2048'
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->url = $request->input('url');
        $product->code_url = $request->input('code_url');
        $product->content = $request->input('content');
        $product->user_id = auth()->user()->id;

        if (request('image')){
            if (app()->isLocal()) {
                // ローカル環境
                $time = date("Ymdhis");
                $product->image = $request->image->storeAs('public/images', $time.'_'.Auth::user()->id. '.jpg');
            } else {
                // 本番環境
                $image = $request->file('image');
                $path = Storage::disk('s3')->putFile('/', $image);
                $product->image = $path;
            }
        }

        $product->save();
        return redirect()->route('product.create')->with('message', 'アプリを投稿しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
