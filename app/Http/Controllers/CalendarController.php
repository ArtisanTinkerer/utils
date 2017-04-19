<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\OracleQuery;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        storeEntryPoint();

        return view('calendars.basic')->with('entryPoint',session('entryPoint'));
    }


    /**
     * Ajax call from FullCalendar
     * @param OracleQuery $queryObject
     * @param Request $request
     */
    public function  fetchEvents(OracleQuery $queryObject,Request $request){

      return $queryObject->getResults($request->only('start','end'),$request->entryPoint);

    }

}
