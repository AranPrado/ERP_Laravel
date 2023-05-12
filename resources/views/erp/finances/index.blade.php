@extends('layouts.base')

@section('title', 'Financeiro')

@section('content')

  <div class="row mt-4">
    <div class="col-12 col-md-12">
      <div class="card">
        <div class="card-header border-0 bg-transparent">
          <h4>Relatório Financeiro</h4>
        </div>
        <div class="card-body">
          <table class="table table-stripe">
            <thead>
              <tr>
              <th scope="row">#</th>
              <th>Cliente</th>
              <th>Valor</th>
              <th>Data/Hora</th>
            </tr>
            </thead>
            <tbody>
              
              <tr>
                <th scope="row">1</th>
                <td>John Doe</td>
                <td><strong>R$450,00</strong></td>
                <td>20/2023 - 13:38</td>
              </tr>
            

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
