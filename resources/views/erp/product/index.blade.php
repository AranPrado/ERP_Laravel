@extends('layouts.base')

@section('title', 'Produtos')


@section('content')
  <form action="{{route('products.create')}}" method="POST">
  <div class="row mt-4 d-flex justify-content-center">


    @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif

    @if(Auth::user()->is_admin)
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <h4>Cadastrar Produto</h4>
        </div>
        <div class="card-body">
          @csrf

          <div class="mb-3">
            <label for="name">Nome</label>
            <input class="form-control" type="text" name="name" id="name" placeholder="Digite o nome" required autofocus autocomplete="off" value="{{old('name')}}">
          </div>

          <div class="mb-3">
            <label for="">Quantidade</label>
            <input min="0" type="number" placeholder="Digite a quantidade" class="form-control" name='quantity' id="quantity" required autofocos value="{{old('quantity')}}"/>   
          </div>

          <div class="mb-3">
            <label for="">Preço</label>
            <input min="0"  type="number" placeholder="Digite o preço" class="form-control" name='price' id="price" step="0.1" required autofocos value="{{old('price')}}"/>   
        </div>


          <div class="mb-3 text-center">
              <button class="btn btn-primary"> <i class="fa fa-user-plus"></i> Criar</button>
              <button type="reset" class="btn btn-secondary"> <i class="fa fa-times"></i> Cancelar</button>
          </div>


        </div>
      </div>
    </div>
    
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <h4>Lista de Matéria Prima</h4>
        </div>
        <div class="card-body">
        <ul>
          @if($feedstocks->count() > 0)
            @foreach($feedstocks as $feedstock)
            <li>
            <label>
              <input type="checkbox" name="feedstocks[]" value="{{$feedstock->name}}" /> 
              <span>{{$feedstock->name}}</span>
            </label>
            </li>
            @endforeach
          @endif
          <ul>
        </div>
      </div>
    </div>
    @endif
    <div class="col-12 mt-4">
      <div class="card col-12">
        <div class="card-header">
          <h4>Produtos cadastrados</h4>
        </div>
        <div class="card-body">
          @csrf

          <table id="feedstockTable" class="table table-stripe">
            <thead>
                <tr>
                    <th scope="row">ID</th>
                    <th>Name</th>
                    <th>Quantidade</th>
                    <th>Mat. Prima</th>
                    <th>Preço</th>
                    <th>Ação</th>
                </tr>
            </thead>

            
            <tbody>
                @if($products->count() > 0)
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{$product->name}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>...</td>
                        <td>R$ {{number_format($product->price, 2, ',', '.')}}</td>
                        <td>
                          @if(Auth::user()->is_admin)
                            <a onclick="edit('{{$product->id}}')" href="#">
                                <i class="fa fa-pen"></i>
                                Editar
                            </a>

                            @else

                            <a onclick="addCart('{{$product}}')" href="#">
                              <i class="fa fa-shopping-cart"></i>
                              Adicionar
                          </a>

                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endif   
            </tbody>
            

        </table>


        </div>
      </div>
    </div>
  </div>
  </form>
@endsection

@section('js')

  <script>

    let addCart = (product) => {
      fetch('{{route("products.addToCart")}}',{
        method: 'POST',
        headers: {'Content-Type': 'application/json',
        'x-csrf-token': '{{csrf_token()}}'
      },
      body:product
      })
        .then(data => data.json())
        .then(res => 
          console.log(res)
        )
    }

  </script>

@endsection