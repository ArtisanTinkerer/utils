<?php

namespace App\Http\Controllers;

use App\Classes\ReportFactory;

class ReportController extends Controller
{


    /**
     * Create a report object.
     *
     * @param ReportFactory $reportFactory
     * @return mixed
     */
    public function display(ReportFactory $reportFactory)
    {

        $report = $reportFactory->createReport('jasper');

        return $report->displayReport();

    }










}
