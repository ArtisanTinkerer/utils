<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 12:22
 */

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class OracleQuery extends ParamaterizedQuery
{
    protected function executeQuery()
    {
        $conOracle = DB::connection('oracle');
        $results = $conOracle->select($this->SQL);

        return $results;
    }
}