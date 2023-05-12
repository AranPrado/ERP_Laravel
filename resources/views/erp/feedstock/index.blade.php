@extends('layouts.base')

@section('title', 'Matéria-Prima')

@section('css')
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
@endsection

@section('content')

  <div class="row mt-4">

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


    <div class="col-12 col-md-4">
      <div class="card shadow">
        <div class="card-header border-0 bg-transparent">
          <h4>Cadastrar Matéria-Prima</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{route('feedstock.create')}}">
            @csrf
            <div class="mb-3">
            <label>Nome da matéria-prima</label>
              <input class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Nome da matéria-prima" required autofocus />
            </div>
            <div class="mb-3">
              <label>Quantidade</label>
              <input class="form-control" type="number" min="0" name="quantity" id="quantity" value="{{old('quantity')}}" placeholder="Quantidade" required autofocus />
            </div>
            <div class="mb-3">
              <label>Preço</label>
              <input class="form-control" type="number" min="0" step="0.1" name="price" id="price" value="{{old('price')}}" placeholder="Preço" required autofocus />
            </div>
            <div class="mb-3 text-center">
              <button class="btn btn-primary">
                <i class="fa fa-save"></i>
                Salvar
              </button>

              <button type="reset" class="btn btn-secondary">
                <i class="fa fa-timer"></i>
                Cancelar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-header border-0 bg-transparent">
          <h4>Lista de Matéria-Prima</h4>
        </div>
        <div class="card-body">
        <table id="feedstockTable" class="table table-stripe">
          <thead>
            <tr>
              <th scope="row">ID</th>
              <th>Name</th>
              <th>Quantidade</th>
              <th>Preço</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            @if($feedstocks->count() > 0)
              @foreach($feedstocks as $feedstock)
                <tr>
                  <th scope="row">{{$feedstock->id}}</th>
                  <td>{{$feedstock->name}}</td>
                  <td>{{$feedstock->quantity}}</td>
                  <td>R$ {{number_format($feedstock->price, 2, ',', '.')}}</td>
                  <td>
                    <a href="#" onclick="edit('{{$feedstock->id}}')">
                      <i class="fa fa-pen"></i>
                      Editar
                    </a>
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
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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