<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 12:22
 */

namespace App\Classes;

use App\Classes\JasperReport;

class ReportFactory
{


    public function createReport($type)
    {

        if($type = 'jasper'){
            $report = new JasperReport;
        }


        return $report;

    }
}