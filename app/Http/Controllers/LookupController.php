<?php

namespace App\Http\Controllers;

use App\Lookup;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


use Jenssegers\Agent\Agent;


class LookupController extends Controller
{



    /**
     * AJAX - this is the new Vue version - just getting the reports
     * If the URL has and area on, filter by that
     * or return all reports
     *
     */

    public function getLookups($area)
    {

        if($area != 'lookups') {

            return response()->json(Lookup::where('area', '=', $area)->get());

        }else{

            return response()->json(Lookup::all());

        }


    }


    /**
     * Old, get rid of?
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lookups = Lookup::all();

        $agent = new Agent();

        if ( $agent->isMobile() ) {
            return view('lookups.mobile', compact('lookups'));
        }else{
            return view('lookups.list', compact('lookups'));
        }
    }





    /**
     * Display a listing of the resource.
     * Old, get rid of?
     *
     * @return \Illuminate\Http\Response
     */
    public function mobile()
    {
        $lookups = Lookup::all();


        return view('lookups.mobile',compact('lookups'));
    }



    public function insertParams(&$SQL,$tokensArray){


        foreach($tokensArray as $key => $value){

            //SQL injection?

            //now we want to be able to do IN
            //so the param needs to be 123;12;45;12

            $parameterArray = explode(";",$value);
            $SQLInString = "";

            $sizeOfArray = sizeof($parameterArray);

            for($elementOn = 0; $elementOn < $sizeOfArray; $elementOn++){

                $SQLInString .= "'$parameterArray[$elementOn]'";

                //if we arent on the last one, add a comma
                if($elementOn != $sizeOfArray-1){
                    $SQLInString .=",";
                }

            }

            //123456
            // or 123;123;45;

            $SQL = str_replace("{". $key."}", $SQLInString, $SQL);

        }

    }


    /**
     * Display the specified resource.
     * Old, get rid of?
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {


        $SQL = "";

        $lookup = Lookup::findOrFail($request->lookup_id);

        $SQL = $lookup->sql;



        //got here and now we have a tokens array for the parameters

        if ($request->tokens != null) {
            $this->insertParams($SQL, $request->tokens);
        }


        $title = $lookup->name;

        try {

            $conOracle = DB::connection('oracle');

            $results = $conOracle->select($SQL);


            if(count($results) == 0 ){
                //redirect with errors
                $arrErrors[0] = "No results found" ;
                
                return Redirect::back()->withErrors($arrErrors);
                
            }

            $firstRecordProperties = get_object_vars($results[0]);
            $headers =  array_keys($firstRecordProperties);
            $neatHeaders = $this->fixUnderscores(array_keys($firstRecordProperties));


        }catch (\Exception $e){

            $arrErrors[0] = "Unable to run report." ;
            Log::error($e->getMessage());

            $agent = new Agent();

            if ( $agent->isMobile() ) {
                return Redirect::route('mobile')->withErrors($arrErrors);    
            }{
                return Redirect::route('lookups')->withErrors($arrErrors);
            }

            
        }
        
        return view('lookups.showLookup',compact('results','title','headers','neatHeaders'));

    }


    private function fixUnderscores($headerArray){
        $retArray = array();

        foreach($headerArray as $element){
            $retArray[] = ucwords(str_replace("_"," ",$element));
        }

        return $retArray;

    }

    
    
}
