<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\FeedStock;

class FeedStockController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedstocks = FeedStock::all();
        return view('erp.feedstock.index')->with(compact('feedstocks'));
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
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),  [
            'name' => 'required|min:3',
            'quantity' => 'required|min:1',
            'price' => 'required|min:1',
        ]);

        if(!$validator->fails()) {

            $feedStock = new FeedStock();
            $feedStock->name = $request->name;
            $feedStock->quantity = $request->quantity;
            $feedStock->price = $request->price;

            if($feedStock->save()) {
                return redirect()->route('feedstock.index')->with('status', 'Cadastro realizado com sucesso.');
            } else {
                return redirect()->route('feedstock.index')->with('error', 'Falha ao tentar salvar. Certifique-se de que o material não está cadastrado.');
            }

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $feedstock = FeedStock::where('id', $id)
            ->first();
        return response()->json(compact('feedstock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeedStock $feedStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|min:3',
            'quantity' => 'required|min:1',
            'price' => 'required|min:1',
        ]);

        if(!$validator->fails()) {

            $feedstock = FeedStock::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'quantity' => $request->quantity,
                    'price' => $request->price
                ]);

            if($feedstock) {
                return response()->json(['code' => 200, 'message' => 'Informações atualizadas com sucesso.']);
            } else {
                return response()->json(['code' => 400, 'message' => 'Falha ao tentar atualizar dados.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedStock $feedStock)
    {
        //
    }
}
