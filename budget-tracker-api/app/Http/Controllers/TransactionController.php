<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all Transactions

        return response()->json(["message" => "Transaction retrieved successfully", "data" => Transaction::all()]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // CREATE TRANSACTIONS

        $validated = $request->validate([
            'title'=> 'required|string|max:255',
            'amount'=> 'required|numeric|min:0',
            'type'=> 'required|string|max:255',
            'category'=> 'required|string|max:255',
            'transaction_date'=> 'required|date',
        ]);

        $transaction = Transaction::create($validated);

        return response()->json(["message" => "Transaction created successfully", "data" => $transaction], 201);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
        $validated = $request->validate([
            'title'=> 'sometimes|required|string|max:255',
            'amount'=> 'sometimes|required|numeric|min:0',
            'type'=> 'sometimes|required|string|max:255',
            'category'=> 'sometimes|required|string|max:255',
            'transaction_date'=> 'required|date',
        ]);

        $transaction->update($validated);

        return response()->json(["message" => "Transactions update successfully", 'data' => $transaction], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
        $transaction->delete();

        return response()->json(null, 204);
    }
}
