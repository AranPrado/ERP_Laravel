@extends('layouts.base')

@section('title', 'Editar Usuário')

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

    <div class="col-12 col-md-6">
      <div class="card shadow">
        <div class="card-header border-0 bg-transparent">
          <h4>Editar Usuário</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{route('users.update', ['id' => $user->id])}}">
            @csrf

            <div class="mb-3">
              <label>Nome Completo</label>
              <input class="form-control" type="text" name="name" id="name" value="{{$user->name}}" required="" />
            </div>

            <div class="mb-3">
              <label>Endereço de E-mail</label>
              <input class="form-control" type="email" name="email" id="email" value="{{$user->email}}" required="" />
            </div>

            <div class="mb-3">
              <label>Tipo de Acesso</label>
              <select name="access" id="access" class="form-control">
                <option value="client" @if(!$user->is_admin) selected @endif> Cliente</option>
                <option value="admin" @if($user->is_admin) selected @endif>Administrador</option>
              </select>
            </div>

            <div class="mb-3 text-center">
              <button class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
              <button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Cancelar</button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card shadow">
        <div class="card-header border-0 bg-transparent">
          <h4>Alterar Senha</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{route('users.update-password', ['id' => $user->id])}}">
            @csrf

            <div class="mb-3">
              <label>Senha</label>
              <input class="form-control" type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" value="" required="" />
            </div>

            <div class="mb-3">
              <label>Confirmar Senha</label>
              <input class="form-control" type="password" name="password-confirm" id="password-confirm" placeholder="Confirme a senha" value="" required="" />
            </div>
            <div class="mb-3 text-center">
              <button class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
              <button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection