<?php

namespace App\Http\Controllers;

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
            ->paginate($request->get('perPage', 10));

        return Inertia::render('products/index', [
            'status' => $request->session()->get('status'),
            'products' => $products,
        ]);
    }

    public function view(Request $request, Product $product)//: Response
    {
        // $product = $product::with('products')->whereId($product->id)->firstOrFail();
        $product = $product::whereId($product->id)->firstOrFail();

        return Inertia::render('products/show', [
            'status' => $request->session()->get('status'),
            'Product' => $product,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('products/form', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => ['sometimes'],
        ]);

        $product = $request->input('id') !== null 
            ? Product::find($request->input('id'))
            : new Product();

        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->slug = Str::slug($data['name']) . '-' . strtotime(now());

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
            'Product' => $product,
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
