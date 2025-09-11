<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add product to session cart
    public function addToCart(Request $request, $productId)
    {
        // Use where() instead of findOrFail() to search by product_id field
        $product = Product::where('product_id', $productId)->firstOrFail();

        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity ?? 1,
                'image' => $product->image,
                'category'=> $product->category,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('discover')->with('success', 'Product added to cart!');
    }

    // Show cart page
    public function index() {
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return view('components.cart.index', compact('cart', 'total'));
    }



    // Update quantity
    public function update(Request $request, $productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    // Remove product
    public function remove($productId)
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Item removed!');
    }

    // Checkout - save to orders table
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $order = Order::create([
            'user_id' => Auth::id(),
            'products' => $cart,
            'total_price' => $total,
            'status' => 'pending'
        ]);

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Order placed successfully!');
    }

}
