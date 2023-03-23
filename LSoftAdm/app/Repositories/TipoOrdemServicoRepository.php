<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TipoOrdemServicoRepository
{
    public function TiposList()
    {
        $list = DB::connection('mysqlSUL')
        ->select('SELECT sis_os_tipos.id, sis_os_tipos.nome as descricao
                    FROM sis_os_tipos
                    ORDER BY sis_os_tipos.nome');

        $array = json_decode(json_encode($list), true);

        return $array;
    }
}
