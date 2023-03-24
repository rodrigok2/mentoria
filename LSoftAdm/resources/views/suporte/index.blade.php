@extends('adminlte::page')

@section('title', 'Ordens de serviços')

@section('content_header')
    <h1 class="text-center">Ordens de Serviços</h1>
@stop

@section('content')
    <div class="form" style="border: 1px solid #b7c1d1">
        <div class="text-center">
            <h6 class="text-center"><b>Pesquisar clientes</b></h6>
            @php
                if($clientes != null)
                {
                    $idCliente = $clientes[0]["id"];
                    $cpnjCliente = $clientes[0]["cnpj"];
                    $cliente = $clientes[0]["cliente"];
                    $contrato = $clientes[0]["contrato"];
                }
                else
                {
                    $idCliente = "";
                    $cpnjCliente = "";
                    $cliente = "";
                    $contrato = "";
                }
            @endphp
            <label style="width: 100px; text-align: right;" for="idCliente">Id:</label>
            <input style="width: 100px" type="text" name="idCliente" id="idCliente" disabled="true"  value="{{ $idCliente }}"/>
            <label style="width: 100px; text-align: right;" for="contrato">Contrato:</label>
            <input style="width: 100px" type="text" name="contrato" id="contrato" value="{{ $contrato }}" disabled="true"/>
            <label style="width: 150px; text-align: right;" for="cnpj">CNPJ:</label>
            <input style="width: 300px" type="text" name="cnpj" id="cnpj" value="{{ $cpnjCliente }}" disabled="true"/>
            <p></p>
            <label style="width: 100px; text-align: right;" for="cliente">Razão social:</label>
            <input style="width: 770px" type="text" name="cliente" id="cliente" value="{{ $cliente }}"  disabled="true"/>
            <p></p>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a  class="btn btn-secondary btn-sm" style="width: 100px" href="{{ route('suporte.clientes') }}">Pesquisar</a>
        </div>
    </div>

    <br><br>

    <br>
    <div class="form" style="border: 1px solid #b7c1d1">
        <form method="POST" action="index" style="border: 1px solid #b7c1d1">
            @csrf
            <div class="input-group input-group-sm mb-3">

                <!--CAMPO CONTRATO HIDDEN-->
                <input type="hidden" name="contrato" id="contrato" value="{{ $contrato }}"/>

                <!--FILTRO DE DATAS DE ABERTURA DA OS-->
                <h6 class="col-12 text-center"><b>Data de abertura</b></h6>
                <div class="col-2 text-right">
                    <label for="data_abertura_inicio">Data inicial:</label>
                </div>
                <div class="col-4 text-left">
                    <input type="date" name="data_abertura_inicio" id="data_abertura_inicio" value=""/>
                </div>
                <div class="col-2  text-right">
                    <label for="data_abertura_fim">Data final:</label>
                </div>
                <div class="col-4 text-left">
                    <input type="date" name="data_abertura_fim" id="data_abertura_fim" value=""/>
                </div>

                <br><br>

                <!--FILTRO DE DATAS DE FECHAMENTO DA OS-->
                <h6 class="col-12 text-center"><b>Data de fechamento</b></h6>
                <div class="col-2 text-right">
                    <label for="data_fechamento_inicio">Data inicial:</label>
                </div>
                <div class="col-4 text-left">
                    <input type="date" name="data_fechamento_inicio" id="data_fechamento_inicio" value="" disabled="true"/>
                </div>
                <div class="col-2  text-right">
                    <label for="data_fechamento_fim">Data final:</label>
                </div>
                <div class="col-4 text-left">
                    <input type="date" name="data_fechamento_fim" id="data_fechamento_fim" value="" disabled="true"/>
                </div>

                <br><br>

                <!--FILTRO DE STATUS, CLASSIFICACAO E TECNICO-->
                <div class="col-2 text-right">
                    <label for="status">Status:</label>
                </div>
                <div class="col-3 text-left">
                    <select class="form-select form-select-sm" id="status" name="status" value="">
                        <option value="1">Aberta</option>
                        <option value="0">Fechada</option>
                    </select>
                </div>
                <div class="col-2 text-right">
                    <label for="classificacao">Classificação:</label>
                </div>
                <div class="col-5 text-left">
                    <select class="form-select form-select-sm" id="classificacao" name="classificacao" value="">
                        <option value="">todas</option>
                        @foreach ($tiposList as $item)
                            <option value="{{ $item['id'] }}">{{ $item['descricao'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 text-right">
                    <label for="tecnico">Técnico:</label>
                </div>
                <div class="col-3 text-left">
                    <select class="form-select form-select-sm" id="tecnico" name="tecnico" value="">
                        <option value="">todos</option>
                        @foreach ($tecnicosList as $item)
                            <option value="{{ $item['id'] }}">{{ $item['usuario'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 text-right">
                    <label for="prioridade">Prioridade:</label>
                </div>
                <div class="col-3 text-left">
                    <select class="form-select form-select-sm" id="prioridade" name="prioridade" value="">
                        <option value="">todas</option>
                        @foreach ($prioridadesList as $item)
                            <option value="{{ $item['id'] }}">{{ $item['descricao'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button style="width: 100px" type="submit" class="btn btn-primary btn-sm">Filtrar</button>
            </div>
        </form>
    </div>

    <br><br>

    <!-- TABELA DE ORDENS DE SERVICO -->
    @if($osList != null)
        <div class="container">
            @php
                $count = count($osList);
            @endphp
            <div class="row">
                <div class="col-12">
                    <h6 class="text-center"><b>Ordens de serviços
                        @if($osList[0]["status"] == 1)
                            abertas
                        @endif
                        @if($osList[0]["status"] == 0)
                            fechadas
                        @endif
                        </b>
                    </h6>
                </div>
                <p></p>
                <div class="col-10">
                </div>
                <div class="col-2">
                    <h6 class="text-center" style="background-color: orange; border-radius: 7px;"><b>total: </b>{{ $count }}</h6>
                </div>
            </div>
            <div class="row" style="background-color: white; padding: 20px">
                <table class="table table-striped table-sm" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th class="text-center">Numero</th>
                            <th class="text-center">Abertura</th>
                            <th class="text-center">Fechamento</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Tecnico</th>
                            <th class="text-center">Prioridade</th>
                            <th class="text-center">Classificação</th>
                            <th class="text-center">Descrição</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < count($osList); $i++)
                            <tr>
                                <td>{{ $osList[$i]["id"] }}</td>
                                <td>{{ $osList[$i]["dataInicial"] }}</td>
                                @if ($osList[$i]["status"] == '1')
                                    <td></td>
                                @else
                                    <td>{{ $osList[$i]["dataFinal"] }}</td>
                                @endif
                                <td>{{ $osList[$i]["cliente"] }}</td>
                                <td>{{ $osList[$i]["usuario"] }}</td>
                                @if ($osList[$i]["prioridade"] == 'Alta')
                                    <td style="background-color: orange; border-radius: 7px;">{{ $osList[$i]["prioridade"] }}</td>
                                @elseif($osList[$i]["prioridade"] == 'Urgente')
                                    <td style="background-color: red; border-radius: 7px;">{{ $osList[$i]["prioridade"] }}</td>
                                @else
                                    <td>{{ $osList[$i]["prioridade"] }}</td>
                                @endif
                                <td>{{ $osList[$i]["classificacao"] }}</td>
                                <td>{{ $osList[$i]["descricao"] }}</td>
                                <td class="text-right">
                                    <a href="{{ route('suporte.detalhes') }}">Detalhes</a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>
    <script>
        $("#status").on("change", function(){
            var status = $("#status").val();
            if (status == 0)
            {
                $('#data_fechamento_inicio').prop("disabled", false);
                $('#data_fechamento_fim').prop("disabled", false);
            }
            if (status == 1)
            {
                $('#data_fechamento_inicio').prop("disabled", true);
                $('#data_fechamento_fim').prop("disabled", true);
            }
        });
    </script>
@stop
