<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index() 
    {
        $orderItems = OrderItem::with('product.user')->whereHas('product', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        dd($orderItems->toArray());
    }
}
