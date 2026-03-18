<?php
namespace App\Http\Controllers;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller {

    public function index() {
        $items = CartItem::with('product')->where('user_id', auth()->id())->get();
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        $total = $items->sum(fn($i) => $i->quantity * $i->product->price);
        return view('checkout.index', compact('items', 'total'));
    }

    public function store(Request $request) {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'notes'            => 'nullable|string',
        ]);

        $items = CartItem::with('product')->where('user_id', auth()->id())->get();
        if ($items->isEmpty()) return redirect()->route('cart.index');

        $total = $items->sum(fn($i) => $i->quantity * $i->product->price);

        DB::transaction(function () use ($request, $items, $total) {
            $order = Order::create([
                'user_id'          => auth()->id(),
                'total'            => $total,
                'shipping_address' => $request->shipping_address,
                'shipping_city'    => $request->shipping_city,
                'shipping_phone'   => $request->shipping_phone,
                'notes'            => $request->notes,
            ]);
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }
            CartItem::where('user_id', auth()->id())->delete();
            session(['last_order_id' => $order->id]);
        });

        return redirect()->route('checkout.success');
    }

    public function success() {
        $orderId = session('last_order_id');
        $order = $orderId ? Order::with('items.product')->find($orderId) : null;
        return view('checkout.success', compact('order'));
    }
}
