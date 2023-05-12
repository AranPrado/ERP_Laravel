@extends('layouts.base')

@section('title', 'Cadastrar Usuário')

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

    <div class="col-12">
      <div class="card shadow">
      <form method="POST" action="{{route('users.store')}}">
        @csrf
        <div class="card-header border-0 bg-transparent">
          <h4>Novo Usuário</h4>
        </div>
        <div class="card-body">
          @csrf

          <div class="mb-3">
            <label for="name">Nome Completo</label>
            <input class="form-control" type="text" name="name" id="name" placeholder="John Doe" required="" autofocus autocomplete="off" value="{{old('name')}}" />
          </div>
          
          <div class="mb-3">
            <label for="email">Endereço de E-mail</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="usuario@dominio.com" required="" autofocus autocomplete="off" value="{{old('email')}}" />
          </div>

          <div class="mb-3">
            <label for="access">Tipo de Acesso</label>
            <select name="access" id="access" class="form-control">
              <option value="client" selected>Cliente</option>
              <option value="admin">Administrador</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Senha</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required="" autofocus autocomplete="off" />
          </div>

          <div class="mb-3">
            <label>Confirmar Senha</label>
            <input class="form-control" type="password" name="password-confirm" id="password-confirm" placeholder="Digite a senha novamente" required="" autofocus autocomplete="off" />
          </div>

          <div class="mb-3 text-center">
              <button class="btn btn-primary"><i class="fa fa-user-plus"></i> Criar</button>
              <button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Cancelar</button>
            </div>
        </div>
      </form>
      </div>
    </div>
  </div>

@endsection