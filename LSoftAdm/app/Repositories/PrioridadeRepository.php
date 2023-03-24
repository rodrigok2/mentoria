<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PrioridadeRepository
{
    public function PrioridadesList()
    {
        $list = DB::connection('mysqlSUL')
        ->select('SELECT sis_prioridades.id, sis_prioridades.descricao
                    FROM sis_prioridades
                    ORDER BY sis_prioridades.id');

        $array = json_decode(json_encode($list), true);

        return $array;
    }
}
