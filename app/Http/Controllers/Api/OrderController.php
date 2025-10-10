<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            ->paginate($request->get('perPage', 1));

        return $this->sendResponse(
            $orders,
            'Products fetched successfully!!!.',
        );
    }

    public function show (Request $request, Order $order) 
    {
        $user = $request->user();

        $order = Order::with(['user', 'address', 'orderItems.product'])
            ->where('user_id', $user->id)
            ->whereId($order->id)
            ->first();

        return $this->sendResponse(
            $order,
            'Products fetched successfully!!!.',
        );
    }

    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'address_id' => ['string', 'uuid', 'required', 'exists:addresses,id']
        ]);

        if($validator->fails()){
            return $this->sendError('Error Occurred.', $validator->errors());       
        }
    }
}