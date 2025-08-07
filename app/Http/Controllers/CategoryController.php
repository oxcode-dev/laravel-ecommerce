<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)//: Response
    {
        $categories = Category::search($request->get('search', ''))
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10));

        return Inertia::render('categories/index', [
            'status' => $request->session()->get('status'),
            'categories' => $categories,
        ]);
    }

    public function view(Request $request, Category $category)//: Response
    {
        $category = $category::with('articles',)->whereId($category->id)->firstOrFail();

        return Inertia::render('categories/show', [
            'status' => $request->session()->get('status'),
            'category' => $category,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('categories/Form', [
            'status' => $request->session()->get('status'),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => ['sometimes'],
        ]);

        $category = $request->input('id') !== null 
            ? Category::find($request->input('id'))
            : new Category();

        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->slug = Str::slug($data['name']) . '-' . strtotime(now());

        $category->save();

        return back()->with([
            'status' => $request->session()->get('status'),
            'category' => $category,
        ]);
    }

    public function edit(Request $request, Category $category)
    {
        return Inertia::render('categories/Form', [
            'status' => $request->session()->get('status'),
            'category' => $category,
            'categories' => Category::all(),
        ]);
    }

    public function delete(Request $request, Category $category)
    {
        $category->delete();

        return redirect('/categories')->with([
            'status' => $request->session()->get('status'),
        ]);
    }
}
