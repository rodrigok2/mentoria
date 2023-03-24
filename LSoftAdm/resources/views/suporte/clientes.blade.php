@extends('adminlte::page')

@section('title', 'Ordens de serviços')

@section('content_header')
    <h1 class="text-center">Clientes</h1>
@stop

@section('content')
    <div class="form" style="border: 1px solid #b7c1d1">
        <form method="POST" action="{{ route('suporte.buscarCliente') }}">
            @csrf
            <div class="text-center">
                <h6 class="text-center"><b>Pesquisar clientes</b></h6>
                <label style="width: 50px; text-align: right;" for="idCliente">Id:</label>
                <input style="width: 50px" type="text" name="idCliente" id="idCliente" value=""/>
                <label style="width: 100px; text-align: right;" for="cnpj">CNPJ:</label>
                <input style="width: 200px" type="text" name="cnpj" id="cnpj" value=""/>
                <label style="width: 100px; text-align: right;" for="fantasia">Fantasia:</label>
                <input style="width: 370px" type="text" name="fantasia" id="fantasia" value=""/>
                <p></p>
                <label style="width: 100px; text-align: right;" for="cliente">Razão social:</label>
                <input style="width: 790px" type="text" name="cliente" id="cliente" value=""/>
                <p></p>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button style="width: 100px" type="submit" class="btn btn-secondary btn-sm">Pesquisar</button>
            </div>
        </form>
    </div>
    <br><br>

    <!-- DADOS CLIENTE -->
    @if($clientes == 1)
        <p></p>
    @elseif($clientes == null)
        <div class="text-center">
            <p style="color: red;">Cliente não encontrado!</p>
        </div>
    @else
        <div class="container">
            <table class="table table-striped table-sm" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Contrato</th>
                        <th class="text-center">CNPJ</th>
                        <th class="text-center">Razao Social</th>
                        <th class="text-center">Nome Fantasia</th>
                        <th class="text-center">Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($clientes); $i++)
                        <tr>
                            <td class="text-center">{{ $clientes[$i]["id"] }}</td>
                            <td class="text-center">{{ $clientes[$i]["contrato"] }}</td>
                            <td class="text-center">{{ $clientes[$i]["cnpj"] }}</td>
                            <td class="text-center">{{ $clientes[$i]["cliente"] }}</td>
                            <td class="text-center">{{ $clientes[$i]["fantasia"] }}</td>
                            <td class="text-center">{{ $clientes[$i]["status"] }}</td>
                            <td class="text-right">
                                <button class="btn btn-primary btn-sm">Detalhes</button>
                            </td>
                            <td class="text-right">
                                <form method="POST" action="{{ route('suporte.ClienteId') }}">
                                    @csrf
                                    @php
                                        $idCliente = $clientes[$i]["id"];
                                        $contrato = $clientes[$i]["contrato"];
                                    @endphp
                                    <input type="hidden" name="idCliente" id="idCliente" value="{{ $idCliente }}"/>
                                    <input type="hidden" name="contrato" id="contrato" value="{{ $contrato }}"/>
                                    <button type="submit" class="btn btn-success btn-sm">Selecionar</button>
                                </form>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    @endif
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
@stop
