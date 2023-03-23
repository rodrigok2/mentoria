<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TecnicoRepository
{
    public function tecnicosList()
    {
        $list = DB::connection('mysqlSUL')
        ->select('SELECT users.id, users.name as nome, users.username as usuario
                    FROM users
                    WHERE users.active = 1
                    ORDER BY users.name');

        $array = json_decode(json_encode($list), true);

        return $array;
    }
}
