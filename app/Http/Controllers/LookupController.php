<?php

namespace App\Http\Controllers;

use App\Models\Lookup;
use Illuminate\Http\Request;

use App\Http\Requests;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class LookupController extends Controller
{



    /**
     * AJAX - this is the new Vue version - just getting the reports
     * If the URL has and area on, filter by that
     * or return all reports
     *
     */

    public function getLookups($area="lookups")
    {

        if($area != 'lookups') {
            $lookups = Lookup::where('area', '=', $area)->get();
        }else{
            $lookups =Lookup::all();
        }


        foreach($lookups as $lookup){
            $lookup->sql = strip_sqlcomment($lookup->sql);
        }

        return response()->json($lookups);
    }


    /**
     * Back button has been pressed and I
     * want to go back to the entry point
     * @return Redirect
     */
    public function back()
    {
        $entryPoint = session('entryPoint');
        return redirect($entryPoint);
    }


    /**
     * Application entry point
     * Just shows the view, everything else is AJAX
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
            storeEntryPoint();
            return view('lookups.list');

    }



    /**
     * Display the specified resource.
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $SQL = "";

        $lookup = Lookup::findOrFail($request->lookup_id);

        $SQL = strip_sqlcomment($lookup->sql);
        //got here and now we have a tokens array for the parameters

        if ($request->tokens != null) {
            insertParams($SQL, $request->tokens);
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
            $neatHeaders =fixUnderscores(array_keys($firstRecordProperties));

        }catch (\Exception $e){

            $arrErrors[0] = "Unable to run report." ;
            Log::error($e->getMessage());

            return Redirect::route('lookups')->withErrors($arrErrors);
        }
        return view('lookups.showLookup',compact('results','title','headers','neatHeaders'));
    }

}
