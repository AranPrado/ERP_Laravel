@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')

<div class="row mt-4 mb-4">

    <div class="col-12 col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-users fa-3x text-secondary"></i>
                        <span class="h3 text-secondary">Clientes</span>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        <span class="h1 fw-bold text-primary">{{$clients->count()}}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <a href="{{route('users.index')}}">Ver todos <i class="fa fa-arrow-right"></i> </a>
            </div>
        </div>
    </div>


    @if(Auth::user()->is_admin)
    <div class="col-12 col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-user fa-3x text-secondary"></i>
                        <span class="h3 text-secondary">Admins</span>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        <span class="h1 fw-bold text-primary">{{$admins->count()}}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <a href="{{route('users.index')}}">Ver todos <i class="fa fa-arrow-right"></i> </a>
            </div>
        </div>
    </div>
    @endif

    <div class="col-12 col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-box fa-3x text-secondary"></i>
                        <span class="h3 text-secondary">Produtos</span>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        <span class="h1 fw-bold text-primary">{{$product->count()}}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end border-0">
                <a href="{{route('products.index')}}">Ver todos <i class="fa fa-arrow-right"></i> </a>
            </div>
        </div>
    </div>

</div>


<div class="row">
    @if(Auth::user()->is_admin)
        <div class="col-12 col-md-6">
            <div class="card shadow">
                
                <div class="card-header bg-transparent border-0">
                    <strong>Últimos Clientes Cadastrados</strong>
                </div>
                <div class="card-body">

                    <table class="table table-stripe">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th>Nome Completo</th>
                                <th>Cadastrado em</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @if($clients)
                                @foreach($clients as $client)
                                    <tr>
                                        <th scope="row">{{$client->id}}</th>
                                        <td>{{$client->name}}</td>
                                        <td>{{date('d/m/Y - H:i', strtotime($client->created_at))}}</td>
                                        <td>
                                            <a class="small" href="{{route('users.index')}}"><i class="fa fa-eye small">Ver</i></a> &nbsp; | &nbsp;
                                            <a class="small" href="#"><i class="fa fa-pen small">Editar</i></a>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end bg-transparent border-0">
                        <a href="{{route('users.index')}}">Ver todos <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid py-5">
            <div class="row align-items-center text-center">
                <div class="col-12">
                    <h1>Bem-vindo à nossa loja virtual!</h1>
                    <p>Aqui você encontra os melhores produtos pelo melhor preço.</p>
                    <a href="{{route('products.index')}}" class="btn btn-primary btn-lg">Ver produtos</a>
                </div>
            </div>
        </div>
    
    
    @endif

    @if(Auth::user()->is_admin)    
    <div class="col-12 col-md-6">
        <div class="card shadow">
            <div class="card-header bg-transparent border-0">
                <strong>Últimos Produtos Cadastrados</strong>
            </div>
            <div class="card-body">

                <table class="table table-stripe">
                    <thead>
                        <tr>
                            <th scope="row">#</th>
                            <th>Produto</th>
                            <th>Qtd.</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($product->count() > 0)
                        @foreach($product as $products)
                            <tr>
                                <th scope="row">{{$products->id}}</th>
                                <td>{{$products->name}}</td>
                                <td>{{$products->quantity}}</td>
                                <td><span class="badge bg-primary">venda</span></td>
                                <td><strong>R$ {{number_format($products->price, 2, ',', '.')}}</strong></td>
                                <td>{{date('d/m/Y', strtotime($products->created_at))}}</td>
                            </tr>
                        @endforeach    
                      @endif
                    </tbody>
                </table>

            </div>
            <div class="card-footer text-end bg-transparent border-0">
                <a href="">Ver todos
                    <a href="{{route('products.index')}}">Ver todos <i class="fa fa-arrow-right"></i> </a>
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- <input id="order" value="" />
    <img src="" alt="" id="img-code" /> --}}
</div>


@endsection


{{-- @section('js')
    <script>
        document.querySelector('#order').addEventListener('change', function() {
            
           let text = document.querySelector('#order').value;
            
        if(text !== '' && text !== null) {
            document.querySelector('#img-code').setAttribute('src', `https://api.invertexto.com/v1/barcode?token=3544|zSqLDNTLu80u1S5v2UdEOSeMXTD8U3Tt&text=${text}&type=code39&font=arial`)
        }
    })

    </script>

@endsection --}}