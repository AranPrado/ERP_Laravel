<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    
    @yield('css')
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
          <a class="navbar-brand" href="{{route('dashboard')}}">{{config('app.name', 'Laravel')}}</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('dashboard')}}">Início</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{route('products.index')}}">Produtos</a>
              </li>
              @if(Auth::user()->is_admin)
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{route('users.index')}}">Usuários</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{route('finance.index')}}">Financeiro</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{route('feedstock.index')}}">Materia Prima</a>
              </li>
              @endif

              @if(!Auth::user()->is_amdin)
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="{{route('cart')}}">
                    <i class="fa fa-shopping-cart"></i>
                    <span id="notificationBadge" class="position-absolute top-10 end-10 translate-middle badge bg-danger rounded-circle">0</span>
                  </a>
                </li>
              @endif

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 {{Auth::user()->name}}
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{route('users.update', ['id' => Auth::user()->id])}}">Perfil</a></li>
                  <li><hr class="dropdown-divider"/></li>
                  
                  <li>

                    <form method="POST" action="{{ route('logout') }}">
                            @csrf

                      <a class="dropdown-item text-danger" href="route('logout')"
                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Sair') }}
                      </a>
                    </form>
                    
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container bg-light">
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    @yield('js')

</body>

</html>
