<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrdemServicoRepository
{
    public function osList($dadosRequest)
    {
        $dataAberturaInicio = $dadosRequest["dataAberturaInicio"] == null ?
            "" :
            " AND sis_os.data_inicio >= '".implode("-",array_reverse(explode("/",$dadosRequest["dataAberturaInicio"])))." 00:00:00'";

        $dataAberturaFim = $dadosRequest["dataAberturaFim"] == null ?
            "" :
            " AND sis_os.data_inicio <= '".implode("-",array_reverse(explode("/",$dadosRequest["dataAberturaFim"])))." 23:59:59'";

        $dataFechamentoInicio = $dadosRequest["dataFechamentoInicio"] == null ?
            "" :
            " AND sis_os.data_fim >= '".implode("-",array_reverse(explode("/",$dadosRequest["dataFechamentoInicio"])))." 00:00:00'";

        $dataFechamentoFim = $dadosRequest["dataFechamentoFim"] == null ?
            "" :
            " AND sis_os.data_fim <= '".implode("-",array_reverse(explode("/",$dadosRequest["dataFechamentoFim"])))." 23:59:59'";

        $status = $dadosRequest["status"] == null ?
            "" :
            "sis_os.status = ".$dadosRequest["status"];

        $tecnico = $dadosRequest["tecnico"] == null ?
            "" :
            " AND users.id = ".$dadosRequest["tecnico"];

        $classificacao = $dadosRequest["classificacao"] == null ?
            "" :
            " AND sis_os_tipos.id = ".$dadosRequest["classificacao"];

        $contrato = $dadosRequest["contrato"] == null ?
            "" :
            " AND sis_os.contrato = ".$dadosRequest["contrato"];

        $prioridade = $dadosRequest["prioridade"] == null ?
            "" :
            " AND sis_prioridades.id = ".$dadosRequest["prioridade"];


        $list = DB::connection('mysqlSUL')
        ->select("SELECT
            sis_os.id AS id,
            sis_os.contrato AS contrato,
            sis_clientes.nome AS cliente,
            sis_clientes.cpf AS cnpj,
            users.username AS usuario,
            sis_os.info AS descricao,
            sis_os.data_inicio AS dataInicial,
            sis_os.data_fim as dataFinal,
            sis_os_tipos.nome AS classificacao,
            sis_os.tempo_total AS duracao,
            sis_prioridades.descricao AS prioridade,
            sis_os.status
        FROM sis_os
        JOIN users ON sis_os.usuario = users.id
        JOIN sis_os_tipos ON sis_os.classificacao = sis_os_tipos.id
        JOIN sis_contratos ON sis_os.contrato = sis_contratos.id
        JOIN sis_clientes ON sis_contratos.cliente = sis_clientes.id
        JOIN sis_prioridades ON sis_prioridades.id = sis_os.prioridade_tarefa_redmine
        WHERE ".$status.$dataAberturaInicio.$dataAberturaFim.$dataFechamentoInicio.$dataFechamentoFim.$tecnico.$classificacao.$contrato.$prioridade.' ORDER BY sis_os.id');

        $array = json_decode(json_encode($list), true);

        return $array;
    }
}
