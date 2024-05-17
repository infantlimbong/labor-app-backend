<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salaries = Salary::all();
        return response()->json(['message' => 'Successfully fetched Salarys', 'data' => $salaries], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salary = Salary::create($request->all());
        return response()->json(['message' => 'Salary successfully created', 'data' => $salary], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        return response()->json(['message' => 'Successfully fetched Salary', 'data' => $salary], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        $salary->update($request->all());
        return response()->json(['message' => 'Salary successfully updated', 'data' => $salary], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        $salary->delete();
        return response()->json(['message' => 'Salary successfully deleted'], 200);
    }
}