<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        $storeId = $request->query('store_id');


        return Inertia::render('products/index', [
            'store_id' => $storeId,
            'products' => Product::where('store_id', $storeId)->get(),
        ]);
    }


    public function create(Request $request)
    {
        $storeId = $request->query('store_id');
       
        return Inertia::render('products/create', [
            'store_id' => $storeId,
            'categories' => ProductCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id'    => 'required|exists:stores,id',
            'category_id' => 'required|exists:product_categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price'       => 'required|numeric|min:0',
            'min_price'   => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validated['image']);

        $product = Product::create($validated);

        return redirect()
            ->route('stores.show', $product->store_id)
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        return Inertia::render('products/edit', [
            'product' => [
                ...$product->toArray(),

                // Converte image_path → URL acessível no front
                'image' => $product->image_path
                    ? asset('storage/' . $product->image_path)
                    : null,
            ],

            'store_id' => $product->store_id,
            'categories' => ProductCategory::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'store_id'    => 'required|integer',
            'category_id' => 'sometimes|exists:product_categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'min_price'   => 'nullable|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('stores.show', $product->store_id)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back();
    }

}
