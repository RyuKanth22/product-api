<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\ProductosDivisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
    try{
        DB::beginTransaction();
        $producto = Producto::create($request->validated());
        DB::commit();
        return response()->json($producto, 201);
    }catch(\Exception $e){
        return response()->json([
            'error' => 'Error creating product',
            'message' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            return response()->json(Producto::find($id), 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error creating product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            $producto->update($request->all());
            DB::commit();
            return response()->json("producto modificado", 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error creating product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            $producto->delete();
            DB::commit();
            return response()->json("Producto: ".$producto->name." Eliminado", 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error creating product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function prices($id)
    {
        $product = Producto::findOrFail($id);
        return response()->json($product->prices);
    }

    public function storePrice(Request $request, $id)
    {
        $request->validate([
            'divisa_id' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $product = Producto::findOrFail($id);
        $productPrice = new ProductosDivisa($request->all());
        $product->prices()->save($productPrice);

        return response()->json($productPrice, 201);
    }
}
