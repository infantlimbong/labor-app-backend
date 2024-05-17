<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occupations = Occupation::all();
        return response()->json(['message' => 'Successfully fetched Occupations', 'data' => $occupations], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $occupation = Occupation::create($request->all());
        return response()->json(['message' => 'Occupation successfully created', 'data' => $occupation], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Occupation $occupation)
    {
        return response()->json(['message' => 'Successfully fetched Occupation', 'data' => $occupation], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occupation $occupation)
    {
        $occupation->update($request->all());
        return response()->json(['message' => 'Occupation successfully updated', 'data' => $occupation], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occupation $occupation)
    {
        $occupation->delete();
        return response()->json(['message' => 'Occupation successfully deleted'], 200);
    }
}