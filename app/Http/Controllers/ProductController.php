<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'category' => 'nullable|string',
                'image' => 'nullable|url',
                'rating' => 'nullable|array',
                'badge' => 'nullable|string',
                'shipping' => 'nullable|string',
            ]);

            $product = new Product($validatedData);
            $product->save();

            return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|required|string',
            'category' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|url',
            'rating' => 'sometimes|nullable|array',
            'badge' => 'sometimes|nullable|string',
            'shipping' => 'sometimes|nullable|string',
        ]);

        // Find the product by its ID
        $product = Product::findOrFail($id);

        // Update the product with the new data
        $updated = false;
        if (!empty($validatedData['title'])) {
            $product->title = $validatedData['title'];
            $updated = true;
        }
        if (!empty($validatedData['price'])) {
            $product->price = $validatedData['price'];
            $updated = true;
        }
        if (!empty($validatedData['description'])) {
            $product->description = $validatedData['description'];
            $updated = true;
        }
        if (!empty($validatedData['category'])) {
            $product->category = $validatedData['category'];
            $updated = true;
        }
        if (!empty($validatedData['image'])) {
            $product->image = $validatedData['image'];
            $updated = true;
        }
        if (!empty($validatedData['rating'])) {
            $product->rating = $validatedData['rating'];
            $updated = true;
        }
        if (!empty($validatedData['badge'])) {
            $product->badge = $validatedData['badge'];
            $updated = true;
        }
        if (!empty($validatedData['shipping'])) {
            $product->shipping = $validatedData['shipping'];
            $updated = true;
        }

        // Save the changes
        if ($updated) {
            $product->save();
            return response()->json(['message' => 'Product updated successfully'], 200);
        } else {
            return response()->json(['message' => 'No changes made'], 304);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
