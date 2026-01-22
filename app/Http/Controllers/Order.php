<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Order extends Controller
{
    class OrderController extends Controller
{
    // Customer checkout
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => session()->get('cart_total'),
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
        ]);

        // Loop through cart items and create OrderItems
        foreach(session()->get('cart', []) as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'size' => $item['size'] ?? null,
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order placed!');
    }

    // Show order
    public function show(Order $order)
    {
        $this->authorize('view', $order); 
        return view('orders.show', compact('order'));
    }

    // Admin: view all orders
    public function index()
    {
        $this->authorize('viewAny', Order::class);
        $orders = Order::latest()->paginate(15);
        return view('orders.index', compact('orders'));
    }

    // Admin: update order status
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled',
        ]);

        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated');
    }
}

}
