<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 12:22
 */

namespace App\Classes;

use App\Interfaces\ReportInterface;
use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Response;


abstract class ChurchillReport implements ReportInterface{


    abstract function displayReport();


}