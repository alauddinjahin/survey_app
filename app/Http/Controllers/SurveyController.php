<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Exception;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::orderBy('created_at','desc')->get();
        return view('backend.surveys.index', compact('surveys'));
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
        try {

            $validator = Validator::make($request->all(),[
                'title' => 'required|unique:surveys',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }    
            
            $data = $request->all();
            if(array_key_exists('is_active',$data)){
                $data['is_active']=1;
            }

            $data['created_by'] = auth()->user()->id??null;

            Survey::create($data);

            return redirect(route('surveys.index'))->withSuccess('Data Inserted Successfully!');

        } catch (Exception $e) {
            return redirect()->back()->withDanger($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey_reports = DB::table('questions')
                    ->selectRaw('questions.*, surveys.title')
                    ->join('surveys','surveys.id','=','questions.survey_id')
                    ->where('survey_id',$id)
                    ->orderBy('position','asc')
                    ->get();

        if(isset($_GET['questions'])){
            return view('backend.surveys.arrange', compact('survey_reports'));
        }   

        return view('backend.surveys.show', compact('survey_reports'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Survey $survey)
    {
        try{

            $validator = Validator::make(request()->all(),[
                'title' => "required|unique:surveys,title,{$survey->id}",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data = request()->all();
            if(array_key_exists('is_active',$data)){
                $data['is_active']=1;
            }else{
                $data['is_active']=0;
            }

            $data['updated_by'] = auth()->user()->id??null;
            $survey->update($data);

            return redirect(route('surveys.index'))->withSuccess('Data Updted Successfully!');

        } catch (Exception $e) {
            return redirect()->back()->withDanger($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }


    public function updateQuestionsOrder(Request $request)
    {
        try
        {
            $positions = $request->only('positions','survey_id');

            if(count($positions['positions'])>0)
            {
                foreach($positions['positions'] as $key=>$position)
                {
                    $question = Question::where('survey_id', $positions['survey_id'])
                                ->where('id', $position[0])
                                ->update([ 'position'  => $position[1]]);

                    if(!$question)
                        throw new Exception("Unable to update position!", 403);   
                    
                }

                return response()->json([
                    'success'   => true,
                    'msg'       => "Position updated successfully!"
                ],200);
            }

        }catch(Exception $e)
        {
            return response()->json([
                'success'   => false,
                'msg'       => $e->getMessage()
            ],$e->getCode());
        }
    }
}
