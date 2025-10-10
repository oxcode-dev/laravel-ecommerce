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
// cart
// [{product_id: "880945c8-eb32-34c0-8e82-f8ae790bc33a", quantity: 4},…]

        // return $request->all();
        $validator = Validator::make($request->all(), [
            'address_id' => ['string', 'uuid', 'required', 'exists:addresses,id'],
            'name_on_card' => ['string', 'max:200', 'min:2', 'required'],
            'card_number' => ['string', 'max:15', 'min:10', 'required'],
            'cvv' => ['integer', 'max:3', 'min:3', 'required'],
            'expiry_month' => ['integer', 'max:2', 'min:1', 'required'],
            'expiry_year' => ['integer', 'max:4', 'min:2', 'required'],
            // 'shippingCost' => ['integer', 'required'],
            // 'tax' => ['integer', 'required'],
            // 'totalAmount' => ['integer', 'required'],
            // 'totalPrice' => ['integer', 'required'],
        ]);

        if($validator->fails()){
            return $this->sendError('Error Occurred.', $validator->errors());       
        }
    }
}