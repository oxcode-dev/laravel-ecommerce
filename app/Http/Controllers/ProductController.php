<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)//: Response
    {
        $products = Product::search($request->get('search', ''))
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        // dd($products->toArray());

        return Inertia::render('products/index', [
            'status' => $request->session()->get('status'),
            'products' => $products,
        ]);
    }

    public function view(Request $request, Product $product)//: Response
    {
        $product = $product::with('category', 'user', 'reviews.user')->whereId($product->id)->firstOrFail();

        // dd($product->toArray());

        return Inertia::render('products/show', [
            'status' => $request->session()->get('status'),
            'product' => $product,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('products/form', [
            'status' => $request->session()->get('status'),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'summary' => ['sometimes'],
            'description' => ['sometimes'],
            'category_id' => ['sometimes'],
            'price' => ['sometimes'],
            'stock' => ['sometimes'],
            'is_active' => ['sometimes'],
        ]);

        $product = $request->input('id') !== null 
            ? Product::find($request->input('id'))
            : new Product();

        // dd($data);

        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->summary = $data['summary'];
        $product->is_active = $data['is_active'];
        $product->category_id = $data['category_id'];
        $product->price = $data['price'];
        $product->stock = $data['stock'];
        $product->user_id = $request->user()->id;
        $product->slug = Str::slug($data['title']) . '-' . strtotime(now());

        $product->save();

        return back()->with([
            'status' => $request->session()->get('status'),
            'Product' => $product,
        ]);
    }

    public function edit(Request $request, Product $product)
    {
        return Inertia::render('products/form', [
            'status' => $request->session()->get('status'),
            'product' => $product::search('')->whereId($product->id)->firstOrFail(),
            'categories' => Category::all(),
        ]);
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();

        return redirect('/products')->with([
            'status' => $request->session()->get('status'),
        ]);
    }
}
