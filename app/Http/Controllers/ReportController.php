<?php

namespace App\Http\Controllers;

use App\Classes\ReportFactory;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function display(ReportFactory $reportFactory)
    {

        $report = $reportFactory->createReport('jasper');

        return $report->getReport();

    }










}
