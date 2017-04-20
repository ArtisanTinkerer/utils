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


    /**
     * Gets the MYSQL  query from the Database,
     * Insert the parameters,
     * Execute the query.
     * @param $paramsArray
     * @param $entryPoint
     * @param $name
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function getResults($paramsArray,$entryPoint,$name)
    {

        $this->SQL = Calendar::where([
            ['area','=',$entryPoint],
            ['name','=',$name]
            ])
            ->firstOrFail()->sql;

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

