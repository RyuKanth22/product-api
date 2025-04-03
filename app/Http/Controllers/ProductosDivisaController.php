<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductosDivisaRequest;
use App\Models\ProductosDivisa;
use App\Models\Divisa;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class ProductosDivisaController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/producto/{id}/precios",
     *     summary="Crea un nuevo precio para un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"divisa_id", "price"},
     *             @OA\Property(property="divisa_id", type="integer", example=1, description="ID de la divisa"),
     *             @OA\Property(property="price", type="number", format="float", example=1200.5, description="Precio del producto en la divisa indicada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Precio agregado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio agregado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor"
     *     )
     * )
     */
    public function storePrice(StoreProductosDivisaRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $producto = Producto::find($id);
            $divisa = Divisa::find($data['divisa_id']);
            
            if (!isset($divisa)) {
                return response()->json('La divisa con id:'.$data['divisa_id']. " No existe", 201);
            }
            if (!isset($producto)) {
                return response()->json('El producto con id:'.$id. " No existe", 201);
            }

            $data['producto_id'] = intval($id);
            ProductosDivisa::create($data);
            DB::commit();

            return response()->json(['message' => 'Precio agregado'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error creando productos divisa',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/producto/{id}/precios",
     *     summary="Obtiene los precios de un producto en diferentes divisas",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de precios por divisa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="nombre", type="string", example="Laptop"),
     *                 @OA\Property(property="divisa", type="string", example="USD"),
     *                 @OA\Property(property="price", type="number", format="float", example=1200.5)
     *             )
     *         )
     *     )
     * )
     */
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

        return response()->json($product, 200);
    }
}
