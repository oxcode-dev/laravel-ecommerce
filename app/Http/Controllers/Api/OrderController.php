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
        $user = $request->user();

        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }

        $validator = Validator::make($request->all(), [
            'address_id' => ['string', 'uuid', 'required', 'exists:addresses,id'],
            'name_on_card' => ['string', 'max:200', 'min:2', 'required'],
            'card_number' => ['string', 'max:15', 'min:10', 'required'],
            'cvv' => ['integer', 'required'],
            'expiry_month' => ['integer', 'required'],
            'expiry_year' => ['integer', 'required'],
            'cart' => ['array', 'required'],
            'cart.*.product_id' => ['required', 'exists:products,id', 'uuid'],
            'cart.*.quantity' => ['required', 'integer'],
        ]);

        if($validator->fails()){
            return $this->sendError('Error Occurred.', $validator->errors());       
        }

        $order  = new Order();
        $order['user_id'] = $user->id;
        $order['address_id'] = $request->get('address_id');
        $order['total_amount'] = $request->get('totalAmount');
        $order['delivery_cost'] = $request->get('shippingCost');
            // 'payment_status';
            // 'payment_method' => 'card';
        $order->save();

        return $order;
        
    }
}