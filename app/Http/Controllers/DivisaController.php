<?php

namespace App\Http\Controllers;

use App\Models\Divisa;
use App\Http\Requests\StoreDivisaRequest;
use App\Http\Requests\UpdateDivisaRequest;
use Illuminate\Support\Facades\DB;

class DivisaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Divisa::all());
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
    public function store(StoreDivisaRequest $request)
    {
        try{
            DB::beginTransaction();
            $divisa = Divisa::create($request->validated());
            DB::commit();
            return response()->json($divisa, 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error creating divisa',
                'message' => $e->getMessage()
            ], 500);
        }
        }

    /**
     * Display the specified resource.
     */
    public function show(Divisa $divisa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisa $divisa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDivisaRequest $request, Divisa $divisa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisa $divisa)
    {
        try{
            DB::beginTransaction();
            $divisa->delete();
            DB::commit();
            return response()->json("Divisa: ".$divisa->name." Eliminada", 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error deleting divisa',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
