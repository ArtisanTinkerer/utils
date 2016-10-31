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

        $SQL = str_replace("{WHERE_TOKEN}", $request->parameter, $SQL);

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
