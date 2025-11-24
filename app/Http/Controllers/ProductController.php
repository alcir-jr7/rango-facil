<?php


namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;


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
        ]);
    }


            public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id'    => 'required|exists:stores,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price'       => 'required|numeric|min:0',
            'min_price'   => 'nullable|numeric|min:0',
        ]);


        // Upload da imagem
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }


        // Remove o campo 'image' pois salvamos como 'image_path'
        unset($validated['image']);


        Product::create($validated);


        return redirect()->route('products.index', ['store_id' => $validated['store_id']])
            ->with('success', 'Produto criado com sucesso!');
    }
        public function edit(Product $product)
        {
            return Inertia::render('products/edit', [
                'product' => $product
            ]);
        }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);


        $product->update($validated);


        return back()->with('success', 'Product updated successfully!');
    }


    public function destroy(Product $product)
    {
        $store_id = $product->store_id;


        $product->delete();


        return redirect()->route('products.index', [
            'store_id' => $store_id
        ]);
    }
}
