@extends('layouts.auth')

@section('title', 'Recuperar Senha')

@section('content')

  <div class="row vh-100 align-items-center justify-content-center">
    <div class="col-4">
      <div class="card shadow-lg">
        <div class="card-header pt-5 bg-transparent border-0">
          <h2 class="text-primary text-center">Recuperar Senha</h2>
        </div>
        <div class="card-body">
          @if(session('status'))
            <div class="alert alert-info">
              {{session('status')}}
            </div>
          @endif
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
              <label for="email">E-mail</label>
              <input class="form-control" type="email" name="email" id="email" autofocus autocomplete="off" required="" value="{{old('email')}}" placeholder="usuario@exemplo.com" />
            </div>
            <div class="mb-3">
              <button class="btn btn-primary form-control">
              <i class="fas fa-envelope"></i> Enviar email
            </button>
            </div>
            <div class="mb-3">
              <a class="btn btn-lightform-control" href="{{route('login')}}">
                <i class="fas fa-arrow-left"></i>
                Voltar ao login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection