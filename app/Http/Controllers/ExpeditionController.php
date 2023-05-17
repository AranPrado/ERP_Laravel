<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Expedition;
use Illuminate\Http\Request;

use Ramsey\Uuid\Uuid;

class ExpeditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        $expedition = Expedition::where('stauts', 'analise');
        return view('erp.expedition.index')
            ->with(compact('expedition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createOrder(Request $request)
    {
        $expedition = new Expedition();
        $expedition->order = Uuid::uuid4();
        $expedition->status = 'analise';

        try {
            $expedition->save();
        } catch(\PDOException $err) {
            return response()->json($err);
        }

    }

    /**
     * Display the specified resource.
     */
    public function showOrder()
    {
        $expedition = Expedition::where('stauts', 'aproved');
        return view('erp.expedition.orders')
            ->with(compact('expedition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function aprovedOrder(string $order)
    {
        $expedition = Expedition::where('order', $order)
            ->update([
                'status' => 'aproved',
            ]);

        if($expedition) {
            return redirect()->route('expedition.aproved')
                ->with('status', 'A ordem cód.:'.$order.' aprovada');

        } else {
            redirect()->route('expedition.aproved')
                ->with('status', 'Não foi possível aprovar a order cód.:'.$order);
        }

    }


    /**
     * Display the specified resource.
     */
    public function inProduction()
    {
        $expedition = Expedition::where('stauts', 'production');
        return view('erp.expedition.orders')
            ->with(compact('expedition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function toProduction(string $order)
    {
        $expedition = Expedition::where('order', $order)
            ->update([
                'status' => 'production',
            ]);

        if($expedition) {
            return redirect()->route('expedition.aproved')
                ->with('status', 'Pedido cód.:'.$order.' enviado para produção');

        } else {
            redirect()->route('expedition.aproved')
                ->with('status', 'Não foi possível enviar order cód.:'.$order. ' para produção');
        }

    }

    /**
     * Display the specified resource.
     */
    public function inExpedition()
    {
        $expedition = Expedition::where('stauts', 'production');
        return view('erp.expedition.orders')
            ->with(compact('expedition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function toExpedition(Request $request, string $order)
    {
        $expedition = Expedition::where('order', $order)
            ->update([
                'status' => 'expediton',
                'vehicle' => $request->vehicle,
            ]);

        if($expedition) {
            return redirect()->route('expedition.aproved')
                ->with('status', 'Pedido cód.:'.$order.' enviado para produção');

        } else {
            redirect()->route('expedition.aproved')
                ->with('status', 'Não foi possível enviar order cód.:'.$order. ' para produção');
        }

    }
}
