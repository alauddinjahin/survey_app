<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Exception;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!array_key_exists('DB_HOST',$_SERVER))
            throw new Exception("Please Check Your APP Envirnment!");

        if($_SERVER['DB_HOST'] != '127.0.0.1' && !check_internet()['success'])
            return check_internet();
        

        $survey = Survey::where('is_active',1)
                ->whereDate('end_date','>=',date('Y-m-d'))
                ->first();
                
        return view('frontend.home',compact('survey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function embed_survey()
    {
        $survey = Survey::where('is_active',1)
                ->whereDate('end_date','>=',date('Y-m-d'))
                ->first();
                
        return view('frontend.embed',compact('survey'));
    }
}
