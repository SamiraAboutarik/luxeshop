<?php
namespace App\Http\Controllers;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {

    public function index() {
        $items = CartItem::with('product')->where('user_id', auth()->id())->get();
        $total = $items->sum(fn($i) => $i->quantity * $i->product->price);
        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request) {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $product = Product::findOrFail($request->product_id);

        $item = CartItem::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $item->increment('quantity', $request->quantity ?? 1);

        return back()->with('success', "« {$product->name} » ajouté au panier !");
    }

    public function update(Request $request, CartItem $cartItem) {
        $this->authorize('update', $cartItem);
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Quantité mise à jour.');
    }

    public function remove(CartItem $cartItem) {
        $cartItem->delete();
        return back()->with('success', 'Article retiré du panier.');
    }

    public function clear() {
        CartItem::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Panier vidé.');
    }
}
