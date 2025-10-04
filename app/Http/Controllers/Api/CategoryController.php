<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\API\BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index (Request $request) 
    {
        $categories = Category::search($request->get('search', ''))
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10));

        return $this->sendResponse(
            Category::withCount('products')->take(20)->get(),
            'Category fetched successfully!!!.',
        );
    }

    public function show (Request $request, Category $category) 
    {
        $category = Category::search($request->get('search', ''))
            ->whereId($category->id)
            ->firstOrFail();

        return $this->sendResponse(
            $category,
            'Category fetched successfully!!!.',
        );
    }

    public function products (Request $request, $slug) 
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::search($request->get('search', ''))
            ->where('category_id', $category->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 20));

        return $this->sendResponse(
            $products,
            'Products fetched successfully!!!.',
        );
    }
}
