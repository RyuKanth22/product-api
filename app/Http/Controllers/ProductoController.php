<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Divisa;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API de Productos",
 *      description="Documentación de la API de Productos"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Schema(
 *     schema="Producto",
 *     required={"name", "price", "divisa_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Laptop"),
 *     @OA\Property(property="description", type="string", example="Laptop"),
 *     @OA\Property(property="price", type="number", format="float", example=1200.50),
 *     @OA\Property(property="divisa_id", type="integer", example=1),
 *     @OA\Property(property="tax_cost", type="number", format="float", example=1200.50),
 *     @OA\Property(property="manufacturing_cost", type="number", format="float", example=1200.50),
 * )
 */
class ProductoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/producto",
     *     summary="Lista todos los productos",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista obtenida correctamente",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Producto"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/producto",
     *     summary="Crea un nuevo producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud"
     *     )
     * )
     */
    public function store(StoreProductoRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $divisa = Divisa::find($data['divisa_id']);
            if (!isset($divisa))
                return response()->json(['error' => 'La divisa con id ' . $data['divisa_id'] . ' no existe'], 400);

            Producto::create($data);
            DB::commit();
            return response()->json("Producto creado", 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error creando producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/producto/{id}",
     *     summary="Obtiene un producto por ID",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto obtenido correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            return response()->json($producto, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error mostrando producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/producto/{id}",
     *     summary="Actualiza un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Producto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $producto = Producto::find($id);
            $divisa = Divisa::find($request->input('divisa_id'));
            if (!isset($divisa))
                return response()->json(['error' => 'La divisa con id ' . $request->input('divisa_id') . ' no existe'], 400);
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
            $producto->update($request->all());
            DB::commit();
            return response()->json('Producto Actualizado', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error actualizando producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/producto/{id}",
     *     summary="Elimina un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="No se puede eliminar el producto porque está relacionado con otras tablas"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json('Producto no encontrado', 404);
            }
            $producto->delete();
            DB::commit();
            return response()->json('Producto eliminado', 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'No se puede eliminar el producto porque está relacionado con otras tablas',
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error eliminando producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
