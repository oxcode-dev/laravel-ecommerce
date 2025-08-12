<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\OrderDeleteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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

        // dd($orders->toArray());

        return Inertia::render('orders/index', [
            'status' => $request->session()->get('status'),
            'orders' => $orders,
        ]);
    }

    public function view(Request $request, Order $order)//: Response
    {
        $order = $order::search('')->whereId($order->id)->firstOrFail();

        return Inertia::render('orders/show', [
            'status' => $request->session()->get('status'),
            'order' => $order,
        ]);
    }

    public function delete(Request $request, Order $order)
    {
        $user = User::where('id', $order->user_id)->first();
        
        OrderItem::where('order_id', $order->id)->delete();
        $order->delete();

        // Notification::send($user, new OrderDeleteNotification($order));
        return redirect('/orders')->with([
            'status' => $request->session()->get('status'),
        ]);
    }
}
