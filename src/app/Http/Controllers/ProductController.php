<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('seasons');

        // 検索機能
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('name', 'like', "%{$keyword}%");
        }

        // 並び替え機能
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'high') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'low') {
                $query->orderBy('price', 'asc');
            }
        }

        // ページネーション
        $products = $query->simplePaginate(6);

        return view('index', ['products' => $products]);
    }

    public function store(ProductRequest $request)
    {
        $path = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'description' => $request->description,
        ]);

        $product->seasons()->attach($request->season_ids);

        return redirect('/products');
    }

    public function update(ProductRequest $request, $productId)
    {
        $product = Product::find($productId);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        } else {
            $path = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'description' => $request->description,
        ]);

        $product->seasons()->sync($request->season_ids);

        return redirect('/products');
    }

    public function destroy($productId)
    {
        Product::find($productId)->delete();
        return redirect('/products');
    }

    public function detail($productId)
    {
        $product = Product::find($productId);
        $seasons = Season::all();
        return view('detail', ['product' => $product, 'seasons' => $seasons]);
    }

    public function create()
    {
        $seasons = Season::all();
        return view('register', ['seasons' => $seasons]);
    }
}
