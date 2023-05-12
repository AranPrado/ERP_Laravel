@extends('layouts.base')

@section('title', 'Usuários')

@section('content')

<div class="row mt-4">
  <div class="col-12">
    <div class="card shadow">
          <div class="card-header border-0 bg-trasparent d-flex justify-content-between">
              <h4>Lista de usuários</h4>
              @if(Auth::user()->is_admin)
              <a href="{{route('users.create')}}" class="btn btn-primary">
                <i class="fa fa-user-plus"></i>
                Cadastrar Novo Usuário
              </a>
              @endif
          </div>
          <div class="card-body">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-client-tab" data-bs-toggle="tab" data-bs-target="#nav-client" type="button" role="tab" aria-controls="nav-client" aria-selected="true">Cliente</button>
        @if(Auth::user()->is_admin)
        <button class="nav-link" id="nav-admin-tab" data-bs-toggle="tab" data-bs-target="#nav-admin" type="button" role="tab" aria-controls="nav-admin" aria-selected="false">Administradores</button>
        @endif
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-client" role="tabpanel" aria-labelledby="nav-client-tab">
        
            <table class="table table-stripe">
              <thead>
                <tr>
                  <th scope="row">ID</th>
                  <th>Nome Completo</th>
                  <th>Email</th>
                  <th>Data/Hora</th>
                  @if(Auth::user()->is_admin)
                  <th>Ação</th>
                  @endif
                </tr>
              </thead>
              <tbody>

                @if($clients->count() > 0)
                  @foreach($clients as $client)
                    <tr>
                      <th scope="row">{{$client->id}}</th>
                      <td>{{$client->name}}</td>
                      <td>{{$client->email}}</td>
                      <td>{{date('d/m/Y - H:i', strtotime($client->created_at))}}</td>
                      <td>
                        @if(Auth::user()->is_admin)
                        <a href="{{route('users.edit', ['id' => $client->id])}}"><i class="fa fa-pen"></i> Editar</a> &nbsp; | &nbsp;
                        <a href="#" onclick="deleteProfile('{{$client->id}}')"><i class="fa fa-eye"></i> Deletar</a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endif
                
              </tbody>
            </table>
          
      </div>
      @if(Auth::user()->is_admin)
      <div class="tab-pane fade" id="nav-admin" role="tabpanel" aria-labelledby="nav-admin-tab">

        <table class="table table-stripe">
          <thead>
            <tr>
              <th scope="row">#</th>
              <th>Nome Completo</th>
              <th>Email</th>
              <th>Data/Hora</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>

            @if($admins->count() > 0)
              @foreach($admins as $admin)
                <tr>
                  <th scope="row">{{$admin->id}}</th>
                  <td>{{$admin->name}}</td>
                  <td>{{$admin->email}}</td>
                  
                  <td>{{date('d/m/Y - H:i', strtotime($admin->created_at))}}</td>
                  
                  <td>
                    <a href="{{route('users.edit', ['id' => $admin->id])}}"><i class="fa fa-pen"></i> Editar</a> &nbsp; | &nbsp;
                    <a href="#" onclick="deleteProfile('{{$admin->id}}')"><i class="fa fa-trash"></i> Deletar</a>
                  </td>
                </tr>
              @endforeach
            @endif
            
          </tbody>
        </table>
      </div>
      @endif
    </div> 
      
      </div>
    </div> 
    
  </div>
</div>

@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function deleteProfile(id) {
      Swal.fire({
        title: 'Tem certeza?',
        text: "Você está prestes a deleta uma conta de usuário!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, deletar!'
      }).then((result) => {
        if (result.isConfirmed) {

          fetch(`/users/delete/${id}`)
            .then(data => data.json())
            .then(res => {
              if(res.code === 200) {
                Swal.fire(
                  'Deletado!',
                  'O perfil foi deletado com sucesso.',
                  'success'
                ).then(function() {
                  location.reload();
                })
              } else {
                Swal.fire(
                  'Falha!',
                  'Não foi possível deltar o perfil.',
                  'error'
                )
              }
            });

          
        }
      })
    }
  </script>
@endsection