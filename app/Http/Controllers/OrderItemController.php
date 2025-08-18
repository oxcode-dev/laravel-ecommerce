<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderItemController extends Controller
{
    public function index(Request $request) 
    {
        $orderItems = OrderItem::with('product.user')
            ->whereHas('product', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        // dd($orderItems->toArray());

        return Inertia::render('order-items/index', [
            'status' => $request->session()->get('status'),
            'orderItems' => $orderItems,
        ]);
    }

    public function view (OrderItem $orderItem) 
    {
        dd($orderItem->toArray());
    }
}
