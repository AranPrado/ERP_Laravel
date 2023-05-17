@extends('layouts.base')

@section('title', 'Financeiro')

@section('css')
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')

    <div class="row mt-4">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header border-0 bg-transparent">
                    <h4>Relatório Financeiro</h4>
                </div>
                <div class="card-body">
                    <table id="finance" class="table table-stripe">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Data/Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($finances->count() > 0)
                                @foreach ($finances as $finance)
                                    <tr>
                                        <th scope="row">{{ $finance->id }}</th>
                                        <td>{{ $finance->name }}</td>
                                        <td><strong>R$ {{ $finance->balance }}</strong></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                        <tfoot>
                            <?php
                            $price = 0;
                            ?>
                            @if ($finances->count() > 0)
                                @foreach ($finances as $c)
                                    <?php
                                    $price = $price + $c->balance;
                                    ?>
                                @endforeach
                                
                            @endif
                            <tr>
                                <td colspan="2" class="h4">Valor total</td>
                                <td colspan="2"><strong class="text-success">R$
                                        {{ number_format($price, 2, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
      let table = new DataTable('#finance');
    </script>
@endsection
