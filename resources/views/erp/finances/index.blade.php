@extends('layouts.base')

@section('title', 'Financeiro')

@section('content')

  <div class="row mt-4">
    <div class="col-12 col-md-12">
      <div class="card">
        <div class="card-header border-0 bg-transparent">
          <h4>Relatório Financeiro</h4>
        </div>
        <div class="card-body">
          <table class="table table-stripe">
            <thead>
              <tr>
              <th scope="row">#</th>
              <th>Cliente</th>
              <th>Valor</th>
              <th>Data/Hora</th>
            </tr>
            </thead>
            <tbody>
              @if($clients->count() > 0 && $products->count() > 0)
                @foreach($products as $product)                
                  <tr>
                    <th scope="row">1</th>
                    <td>Teste</td>
                    <td><strong>R$ {{$product->price}}</strong></td>
                    <td></td>
                  </tr>
                @endforeach  
              @endif
            </tbody>
          
            <tfoot>
              <tr>
                <td><h4>Valor total:</h4></td>
                <td></td>
                <td class="h5 fn-bold">R$ {{number_format($totalPrice, 2, ',', '.')}}</td>
              </tr>
            </tfoot>
          
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
