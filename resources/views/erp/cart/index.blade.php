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
                                <th>Produto</th>
                                <th>Valor</th>
                                <th>Data/Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('cart'))
                                @foreach (session('cart') as $c)
                                    <tr>
                                        <th scope="row">{{ $c['id'] }}</th>
                                        <td>{{ $c['name'] }}</td>
                                        <td><strong>R$ {{ number_format($c['price'], 2, ',', '.') }}</strong></td>
                                        <td>{{ date('d/m/Y - H:i', strtotime($c['created_at'])) }}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        <tfoot>


                            <?php
                            $price = 0;
                            ?>
                            @if (session('cart'))
                                @foreach (session('cart') as $c)
                                    <?php
                                    $price = $price + $c['price'];
                                    ?>
                                @endforeach
                              
                            @else
                              <p>Não há produtos no carrinho.</p>    
                            @endif
                            <tr>
                                <td colspan="2" class="h4">Valor total</td>
                                <td colspan="2"><strong class="text-success">R$
                                        {{ number_format($price, 2, ',', '.') }}</strong></td>
                            </tr>

                            <tr>
                                <td class="text-center" colspan="5">
                                    <form action="{{ route('finance.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="balance" value='{{ $price }}'>
                                        <input type="hidden" name="client" value='{{ Auth::user()->name }}'>

                                        <button class="btn btn-primary"> <i class="fa fa-check"></i> Solicitar</button>
                                        <button type="reset" id="clearCart" class="btn btn-secondary"> <i
                                                class="fa fa-times"></i> Limpar carrinho</button>
                                    </form>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        document.querySelector('#clearCart').addEventListener('click', function() {
            fetch('{{ route('products.clearToCart') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart: 'cart'
                    })
                })
                .then(data => data.json())
                .then(res => {
                    location.reload();
                })

        })
    </script>

@endsection
