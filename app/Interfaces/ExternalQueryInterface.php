<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 11:32
 */
namespace App\Interfaces;

Interface ExternalQueryInterface{

   public function getResults($parameters,$entryPoint,$name);

}
