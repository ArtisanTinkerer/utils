<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 11:46
 */

namespace App\Classes;

use App\Models\Calendar;
use App\Interfaces\ExternalQueryInterface;

abstract class ParamaterizedQuery implements ExternalQueryInterface
{

    protected $SQL;

    public function getResults($paramsArray,$entryPoint)
    {

        $this->SQL = Calendar::where('area',$entryPoint)->firstOrFail()->sql;

        $this->insertParams($paramsArray);

        return response($this->executeQuery());

    }

    /**
     * Replaces the SQL tokens with their values
     *
     * @param $parameterArray
     */
    private function insertParams($parameterArray){
        foreach($parameterArray as $key => $value){
            $this->SQL = str_replace("{". $key."}", $value, $this->SQL);
        }
    }



}

