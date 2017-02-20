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



    //AJAX

    public function getLookups()
    {

        return response()->json(Lookup::all());


    }





    public function reports()
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
     *
     * @return \Illuminate\Http\Response
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
     *
     * @return \Illuminate\Http\Response
     */
    public function mobile()
    {
        $lookups = Lookup::all();


        return view('lookups.mobile',compact('lookups'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {


        $SQL = "";

        $lookup = Lookup::findOrFail($request->lookup_id);

        $SQL = $lookup->sql;

        $param = $request->parameter;

        //now we want to be able to do IN

        //so the param needs to be 123;12;45;12

        $parameterArray = explode(";",$param);
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

        $SQL = str_replace("{WHERE_TOKEN}", $SQLInString, $SQL);

        $title = $lookup->name;

        try {

            $conOracle = DB::connection('oracle');

            $results = $conOracle->select($SQL);


            if(count($results) == 0 ){
                //redirect with errors
                $arrErrors[0] = "No results found" ;
                
                return Redirect::route('lookups')->withErrors($arrErrors);
                
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
