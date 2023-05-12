<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\FeedStock;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $products = Product::all();
        $feedstocks = FeedStock::all();

        return view('erp.product.index')
            ->with(compact('feedstocks', 'products'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'quantity' => 'required|min:1',
            'price' => 'required|min:1',
        ]);

        if(!$validator->fails()){
            $product = new Product();
            $product->name = $request->name;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
        }

        if($product->save()){
            return redirect()->route('products.index')->with('status', 'Cadastro realizado com sucesso');
        } else {
            return redirect()->route('products.index')->with('error', 'Falha ao tentar salvar. Certifique-se de que o produto não está cadastrado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $product = Product::where('id', $id)->first();

        return view('erp.product.show')
            ->with(compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id', $id)->first();

        return view('erp.product.edit')
            ->with(compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::where('id', $id)
            ->update([
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'status' => $request->status,
                'feedstocks' => $request->feedstocks,
            ]);

        if($product->save()) {
            return redirect()->route('product.edit', ['id' => $id])->with('status', 'Informações atualizadas com sucesso.');
        } else {
            return redirect()->route('product.edit', ['id' => $id])->with('error', 'Falha ao tentar atualizar dados.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id', $id)
            ->delete();

        if($product) {
            return redirect()->route('product.index')
                ->with('status', 'Produto deletado com sucesso.');
        } else {
            return redirect()->route('product.index')
                ->with('status', 'Falha ao tentar deletar produto.');
        }
    }


    public function addToCart(Request $request) {
        // return response()->json($request->all());
        $request->session()->push('cart', $request->all());
        $cart = $request->session()->get('cart');
        
        return response()->json($cart);
        return response()->json(['message' => 'Adicionado ao carrinho']);

    }

    public function clearToCart(Request $request) {
        // return response()->json($request->all());
        $request->session()->forget('cart');
        $cart = $request->session()->get('cart');
        
        
        return response()->json(['message' => 'Carrinho limpo']);

    }

}
