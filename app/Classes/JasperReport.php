<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 12:22
 */

namespace App\Classes;

use JasperPHP\JasperPHP;
use Illuminate\Support\Facades\Response;


class JasperReport
{


    private function compile()
    {

        $jasper = new JasperPHP;

        // Compile a JRXML to Jasper
        $jasper->compile('reports/lookups.jrxml')->execute();


    }


    private function process()
    {

        $jasper = new JasperPHP;


        // Process a Jasper file to PDF and RTF (you can use directly the .jrxml)
        $jasper->process(
            'reports/lookup.jasper',
            false,
            array("pdf", "rtf"),
            array(), //report parameters
            array(
                'driver' => 'mysql',
                'username' => 'mick',
                'host' => 'devwebapplications-02.churchill1795.local',
                'database' => 'lookups',
                'password' => 'password',
                'port' => '3306',
            ) //db_connection

        )->execute();



    }

    private function display()
    {
        $filename = 'reports/lookups.pdf';
        //$path = storage_path($filename);

        return Response::make(file_get_contents($filename), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function getReport(){
        $this->compile();
        $this->process();
       return $this->display();
    }





}