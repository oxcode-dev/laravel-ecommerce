<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)//: Response
    {
        $orders = Order::search($request->get('search', ''))
            ->orderBy(
                $request->get('sortField', 'created_at'),
                $request->get('sortAsc') === 'true' ? 'asc' : 'desc'
            )    
            ->paginate($request->get('perPage', 5));

        return Inertia::render('orders/index', [
            'status' => $request->session()->get('status'),
            'orders' => $orders,
        ]);
    }

    public function view(Request $request, Order $order)//: Response
    {
        $order = $order::search('')->whereId($order->id)->firstOrFail();
        // dd($order->toArray());

        return Inertia::render('orders/show', [
            'status' => $request->session()->get('status'),
            'order' => $order,
        ]);
    }


    public function delete(Request $request, Order $order)
    {
        OrderItem::where('order_id', $order->id)->delete();
        $order->delete();

        return redirect('/orders')->with([
            'status' => $request->session()->get('status'),
        ]);
    }
}
