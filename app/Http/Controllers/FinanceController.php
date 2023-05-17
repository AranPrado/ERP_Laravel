<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        
        $finances = Finance::all();
        

               
        return view('erp.finances.index')
            ->with(compact('finances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'client' => 'required',
            'balance' => 'required',
        ]);

        if(!$validator->fails()) {
            $finance = new Finance();
            $finance->name = $request->client;
            $finance->balance = $request->balance;
            try {
                $finance->save();
                $this->clearToCart();
                return redirect()->route('dashboard')
                    ->with('status', 'Pedido enviado com sucesso');
                
            } catch(\PDOException $err) {
                return response()->json($err);
            }
        } else {
            return redirect()->with('error', 'Verifique se todos os campos foram preenchidos.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $finance = Finance::where('id', $id)->first();

        return view('erp.finances.index')
            ->with(compact('finance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        //
    }

    public function clearToCart() {
        // return response()->json($request->all());
        session()->forget('cart');
        $cart = session()->get('cart');
        
        
        return response()->json(['message' => 'Carrinho limpo']);

    }
    

}
