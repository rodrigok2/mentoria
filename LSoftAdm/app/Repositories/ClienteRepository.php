<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ClienteRepository
{
    public function BuscarCliente($dadosRequest)
    {

        $id = $dadosRequest["id"] == null ?
            "" :
            " AND sis_clientes.id = ".$dadosRequest["id"];

        $cnpj = $dadosRequest["cnpj"] == null ?
            "" :
            " AND sis_clientes.cpf = '".$dadosRequest["cnpj"]."'";

        $fantasia = $dadosRequest["fantasia"] == null ?
            "" :
            " AND sis_clientes.fantasia LIKE '%".$dadosRequest["fantasia"]."%'";

        $razaoSocial = $dadosRequest["razaoSocial"] == null ?
            "" :
            " AND sis_clientes.nome LIKE '%".$dadosRequest["razaoSocial"]."%'";

        $contrato = $dadosRequest["contrato"] == null ?
            "" :
            " AND sis_contratos.id = ".$dadosRequest["contrato"];


        $list = DB::connection('mysqlSUL')
        ->select("SELECT sis_clientes.id,
                    sis_clientes.cpf AS cnpj,
                    sis_clientes.fantasia,
                    sis_clientes.nome AS cliente,
                    sis_contratos.id AS contrato,
                    sis_contratos.status AS status
                    FROM sis_clientes
                    JOIN sis_contratos ON sis_clientes.id = sis_contratos.cliente
                    WHERE sis_clientes.id is not null AND sis_contratos.status <> 'Cancelado'".$id.$cnpj.$fantasia.$razaoSocial.$contrato."
                    ORDER BY sis_contratos.id");

        $array = json_decode(json_encode($list), true);

        return $array;
    }
}
