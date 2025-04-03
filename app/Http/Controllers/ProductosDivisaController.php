<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceRequest;
use App\Models\ProductosDivisa;
use App\Http\Requests\StoreProductosDivisaRequest;
use App\Http\Requests\UpdateProductosDivisaRequest;
use App\Models\Divisa;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ProductosDivisaController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductosDivisaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductosDivisa $productosDivisa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductosDivisa $productosDivisa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductosDivisaRequest $request, ProductosDivisa $productosDivisa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductosDivisa $productosDivisa)
    {
        //
    }
    public function storePrice(StoreProductosDivisaRequest $request, $id)
    {
        try{
            DB::beginTransaction();
                $data = $request->validated();
                $producto = Producto::find($id);
                $divisa = Divisa::find($data['divisa_id']);
                if(!isset($divisa))
                    return response()->json('La divisa con id:'.$data['divisa_id']. " No existe", 201);
                if(!isset($producto))
                    return response()->json('El producto con id:'.$id. " No existe", 201);
                $data['producto_id'] = intval($id);
                ProductosDivisa::create($data);
            DB::commit();
                return response()->json('Precio agregado', 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error creando productos divisa',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function prices($id)
    {
        $producto = Producto::find($id);
        $product = ProductosDivisa::where('producto_id', $id)->get()->map(function ($price) use ($producto) {
            $divisa = Divisa::find($price->divisa_id);
            return [
                'nombre' => $producto->name,
                'divisa' => $divisa->name,
                'price' => $price->price,
            ];
        });
        return response()->json($product, 201);
    }
}
