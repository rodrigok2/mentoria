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
            " AND sis_clientes.fantasia LIKE '%".$dadosRequest["razaoSocial"]."%'";


        $list = DB::connection('mysqlSUL')
        ->select('SELECT sis_clientes.id,
                    sis_clientes.cpf AS cnpj,
                    sis_clientes.fantasia,
                    sis_clientes.nome AS cliente
                    FROM sis_clientes
                    WHERE sis_clientes.id is not null'.$id.$cnpj.$fantasia.$razaoSocial);

        $array = json_decode(json_encode($list), true);

        return $array;
    }
}
