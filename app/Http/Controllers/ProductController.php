<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $name = $request->input('name');
        $price = $request->input('price');
        $product_description = $request->input('description');


        $product = Product::create([
            'name' => $name,
            'price' => $price,
            'description' => $product_description,
        ]);
        return response()->json([
            'data' => $product
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
       //$data = DB::table('products')->where('id', $id)->select('name','price')->first();

       //return $product;
        return  new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $name = $request->input('name');
        // $price = $request->input('price');
        // $product_description = $request->input('description');

        // $product = Product::findOrfail($id);

        // $product->update([
        //     'name' => $name,
        //     'price' => $price,
        //     'description' => $product_description,
        // ]);
        // return response()->json([
        //     'product news data' => $product
        // ], 201);

          // Check if the Content-Type header is present and is 'application/json'


     return response()->json($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return response()->json([
            'product news data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $p = Product::findOrfail($id);

        $p->delete();

        return response()->json(null,204);
    }
}
