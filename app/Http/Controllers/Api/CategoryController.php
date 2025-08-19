<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\API\BaseController;
use App\Models\Category;
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

        

    }
}
