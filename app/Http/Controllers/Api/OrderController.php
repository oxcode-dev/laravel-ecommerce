<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index (Request $request) 
    {
        $user = $request->user();

        $orders = Order::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 10));

        return $this->sendResponse(
            $orders,
            'Products fetched successfully!!!.',
        );
    }

    public function show (Request $request, Order $order) 
    {
        $user = $request->user();

        $order = Order::search($request->get('search', ''))
            ->where('user_id', $user->id)
            ->whereId($order->id)
            ->first();

        return $this->sendResponse(
            $order,
            'Products fetched successfully!!!.',
        );
    }
}
