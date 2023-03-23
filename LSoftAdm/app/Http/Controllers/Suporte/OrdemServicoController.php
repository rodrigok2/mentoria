<?php

namespace App\Http\Controllers\Suporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TecnicoRepository;
use App\Repositories\TipoOrdemServicoRepository;
use App\Repositories\OrdemServicoRepository;
use App\Repositories\ClienteRepository;

class OrdemServicoController extends Controller
{
    public function index(Request $request)
    {
        $tiposList = $this->TiposOrdemBD();
        $tecnicosList = $this->TecnicosBD();
        $osList = null;
        $clientes = null;

        return view ('suporte.index', compact('tecnicosList','tiposList','osList', 'clientes'));
    }

    public function filtrar(Request $request)
    {
        $tiposList = $this->TiposOrdemBD();
        $tecnicosList = $this->TecnicosBD();
        $osList = null;
        $clientes = null;

        $dadosRequest = [
            "dataAberturaInicio" => $request->data_abertura_inicio,
            "dataAberturaFim" => $request->data_abertura_fim,
            "dataFechamentoInicio" => $request->data_fechamento_inicio,
            "dataFechamentoFim" => $request->data_fechamento_fim,
            "status" => $request->status,
            "tecnico" => $request->tecnico,
            "classificacao" => $request->classificacao,
        ];

        $osList = $this->OrdensServicoBD($dadosRequest);

        return view ('suporte.index', compact('tecnicosList','tiposList','osList', 'clientes'));
    }

    public function clientes ()
    {
        $clientes = 1;
        return view ('suporte.clientes', compact('clientes'));
    }

    public function buscarCliente (Request $request)
    {
        $dadosRequest = [
            "id" => $request->idCliente,
            "cnpj" => $request->cnpj,
            "fantasia" => $request->fantasia,
            "razaoSocial" => $request->cliente,
        ];

        if($dadosRequest["id"] == null && $dadosRequest["cnpj"] == null && $dadosRequest["fantasia"] == null && $dadosRequest["razaoSocial"] == null)
        {
            $clientes = null;
            return view ('suporte.clientes', compact('clientes'));
        }
        else
        {
            $clientes = $this->ClientesBD($dadosRequest);
            return view ('suporte.clientes', compact('clientes'));

        }
    }

    public function ClienteId(Request $request)
    {
        $dadosRequest = [
            "id" => $request->idCliente,
            "cnpj" => null,
            "fantasia" => null,
            "razaoSocial" => null,
        ];
        $clientes = $this->ClientesBD($dadosRequest);
        $tiposList = $this->TiposOrdemBD();
        $tecnicosList = $this->TecnicosBD();
        $osList = null;

        return view ('suporte.index', compact('tecnicosList','tiposList','osList', 'clientes'));
    }

    public function TiposOrdemBD ()
    {
        $tipoOrdemServicoRepository = new TipoOrdemServicoRepository();
        $list = $tipoOrdemServicoRepository->TiposList();
        return $list;
    }

    public function TecnicosBD ()
    {
        $tecnicoRepository = new TecnicoRepository();
        $list = $tecnicoRepository->tecnicosList();
        return $list;
    }

    public function OrdensServicoBD ($array)
    {
        $ordemServicoRepository = new OrdemServicoRepository();
        $list = $ordemServicoRepository->osList($array);
        return $list;
    }

    public function ClientesBD ($array)
    {
        $clienteRepository = new ClienteRepository();
        $list = $clienteRepository->BuscarCliente($array);
        return $list;
    }

    public function detalhes(Request $request)
    {
        return view ('suporte.detalhes');
    }
}
