<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.seller.add-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'required|image|max:2048',
        'category' => 'required',
    ]);

    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->category = is_array($request->category) ? implode(',', $request->category) : $request->category;
    $product->user_id = $request->user_id;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }

    $product->save();

    return redirect()->back()->with('success', 'Product added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
       $products = Product::all();

       // Send data to the Blade file
        return view('display-product', ['products' => $products]);
    }

    public function sellerProducts()
    {
        $seller = Auth::user();
        $products = $seller->products()->get();

        // 👇 Pass products to seller.blade.php
        return view('seller.dashboard', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
