@extends('layouts.base')

@section('title', 'Carrinho de Compras')

@section('content')

  <div class="row mt-4">
    <div class="col-12 col-md-12">
      <div class="card">
        <div class="card-header border-0 bg-transparent">
          <h4>Meu carrinho</h4>
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
              @if(session('cart'))
                @foreach(session('cart') as $c)
              <tr>
                <th scope="row">{{$c['id']}}</th>
                <td>{{$c['name']}}</td>
                <td><strong>R$ {{number_format($c['price'], 2, ',', '.')}}</strong></td>
                <td>{{date('d/m/Y - H:i', strtotime($c['created_at']))}}</td>
              </tr>
              @endforeach
              @endif
            
            </tbody>
            <tfoot>
              <tr>
                <td class="text-center" colspan="5">
                  <button class="btn btn-primary"> <i class="fa fa-check"></i> Solicitar</button>
                  <button type="reset" id="clearCart" class="btn btn-secondary"> <i class="fa fa-times"></i> Limpar carrinho</button>
                </td>
              </tr>
            </tfoot>
          </table>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')

  <script>
    document.querySelector('#clearCart').addEventListener('click', function(){
      fetch('{{route("products.clearToCart")}}',{
        method: 'POST',
        headers: {'Content-Type': 'application/json',
        'x-csrf-token': '{{csrf_token()}}'
      },
      body: JSON.stringify(
        {
          cart: 'cart'
        }
      )
      })
        .then(data => data.json())
        .then(res => {
          location.reload();
        })
        
    })
  </script>

@endsection