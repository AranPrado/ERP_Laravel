@extends('layouts.auth')

@section('title', 'Login')

@section('content')
  <div class="row vh-100 align-items-center justify-content-center">
    <div class="col-4">
      <div class="card shadow-lg">
        <div class="card-header pt-5 bg-transparent border-0">
          <h2 class="text-primary text-center">Login</h2>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="email">E-mail</label>
              <input class="form-control" type="email" name="email" id="email" autofocus autocomplete="off" required="" value="{{old('email')}}" placeholder="usuario@exemplo.com" />
            </div>
            <div class="mb-3">
              <label for="password">Senha</label>
              <input class="form-control" type="password" name="password" id="password" autofocus autocomplete="off" required="" value="{{old('password')}}" placeholder="********" />
              <a href="{{route('password.request')}}">Recuperar senha</a>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary form-control">
              <i class="fas fa-sign-in"></i>
                Login</button>
            </div>
          </form>
        </div>
        <div class="card-footer text-center pb-4 bg-transparent border-0">
          <a href="{{route('register')}}">Fazer cadastro</a>
        </div>
      </div>
    </div>
  </div>

@endsection