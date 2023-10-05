<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrders()
    {
        $orders = Order::all();
        return view('orders.index', ['orders' => $orders]);
    }

    public function viewOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            abort(404);
        }

        return view("orders.view", ['order' => $order]);
    }

    public function updateOrder(Request $request, $id)
    {
        $validatedData = $request->validate([
            'bot_name' => 'string',
        ]);

        $order = Order::find($id);

        if (!$order) {
            abort(404);
        }

        $order->bot_name = $validatedData['bot_name'];
        $order->save();

        return redirect("/order/$id");
    }
}
