<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Tag;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'price' => 'required|decimal:2|min:0',
            'expiration_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,expired',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produkts veiksmīgi izveidots!');
    }

    public function show(Product $product)
    {
           $product->load('tags');

        $allTags = Tag::orderBy('name')->get();

        return view('products.show', compact('product', 'allTags'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'price' => 'required|decimal:2|min:0',
        'expiration_date' => 'nullable|date',
        'status' => 'required|in:active,inactive,expired',

        'tags' => 'nullable|array',
        'tags.*' => 'required|string|max:255',
    ]);

    $product->update([
        'name' => $validated['name'],
        'quantity' => $validated['quantity'],
        'description' => $validated['description'] ?? null,
        'price' => $validated['price'],
        'expiration_date' => $validated['expiration_date'] ?? null,
        'status' => $validated['status'],
    ]);

    $tagIds = [];

    foreach ($validated['tags'] ?? [] as $tagName) {
        $tag = Tag::firstOrCreate([
            'name' => trim($tagName),
        ]);

        $tagIds[] = $tag->id;
    }

    $product->tags()->sync($tagIds);

    return redirect()->route('products.show', $product)
        ->with('success', 'Produkts un tā birkas veiksmīgi atjauninātas!');
}

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produkts veiksmīgi dzēsts!');
    }

public function increaseQuantity(Product $product)
{
    $product->changeQuantity(1);

    return response()->json([
        'success' => true,
        'message' => 'Produkta daudzums veiksmīgi palielināts!',
        'quantity' => $product->fresh()->quantity,
    ]);
}

public function decreaseQuantity(Product $product)
{
    try {
        $product->changeQuantity(-1);

        return response()->json([
            'success' => true,
            'message' => 'Produkta daudzums veiksmīgi samazināts!',
            'quantity' => $product->fresh()->quantity,
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}
}