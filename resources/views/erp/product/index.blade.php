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

  <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
          <form id="formModal" method="POST" action="{{route('feedstock.create')}}">
            @csrf
            <input id="uid" type="hidden" value="" />

            <div class="mb-3">
            <label>Nome da matéria-prima</label>
              <input class="form-control" name="name" id="modalName" value="{{old('name')}}" placeholder="Nome da matéria-prima" required autofocus />
            </div>
            <div class="mb-3">
              <label>Quantidade</label>
              <input class="form-control" type="number" min="0" name="quantity" id="modalQuantity" value="{{old('quantity')}}" placeholder="Quantidade" required autofocus />
            </div>
            <div class="mb-3">
              <label>Preço</label>
              <input class="form-control" type="number" min="0" step="0.1" name="price" id="modalPrice" value="{{old('price')}}" placeholder="Preço" required autofocus />
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button id="sendForm" type="button" class="btn btn-primary">
          <i class="fa fa-save"></i>
          Salvar Alteração
        </button>

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times"></i>
          Cancelar
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  

  <script>

  function getFeedstock(id) {

    let uid = document.querySelector('#uid');
    let name = document.querySelector('#modalName');
    let quantity = document.querySelector('#modalQuantity');
    let price = document.querySelector('#modalPrice');

    fetch(`/feedstock/${id}`)
      .then(data => data.json())
      .then(res => {
        uid.value = res.feedstock.id
        name.value = res.feedstock.name
        quantity.value = res.feedstock.quantity
        price.value = res.feedstock.price.toFixed(2)
      })
  }

  function edit(id) {
    var galleryModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
      keyboard: false
    });
    
    getFeedstock(id);

    galleryModal.show();
  }

  document.querySelector('#sendForm').addEventListener('click', function() {
    let uid = document.querySelector('#uid').value;
    let name = document.querySelector('#modalName').value;
    let quantity = document.querySelector('#modalQuantity').value;
    let price = document.querySelector('#modalPrice').value;

    if(uid !== '' && name !== '' && quantity !== '' && price !== '') {

      fetch(`/feedstock/update/${uid}`, {
        method: 'POST',
        headers: {
          'content-type': 'application/json',
          'x-csrf-token': '{{csrf_token()}}'
        },
        body: JSON.stringify({
          id: uid,
          name: name,
          quantity: quantity,
          price: price
        })
      })
      .then(data => data.json())
      .then(res => {
        if(res.code === 200) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: res.message,
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            var galleryModal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
            galleryModal.hide();
            location.reload();
          })
        } else {
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: res.message,
            showConfirmButton: false,
            timer: 1500
          })
        }
      })
    }

  })
  
  let table = new DataTable('#feedstockTable');


  </script>
@endsection









{{-- @section('js')

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

@endsection --}}