<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('created_at','desc')->get();
        return view('backend.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $surveys = Survey::pluck('title','id')->toArray();
        return view('backend.questions.create',compact('surveys'));
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
                'question'  => 'required|unique:questions',
                'survey_id' => 'required',
                'step_no'   => 'required|integer',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }    
            
            $data = $request->all();
            if(array_key_exists('is_required',$data)){
                $data['is_required']=1;
            }

            if(array_key_exists('json_option',$data)){
                if(count($data['json_option'])>0){
                    foreach($data['json_option'] as $d){
                        if(is_null($d))
                            throw new Exception("Options can't be Null Or Empty!", 403);      
                    }
                }

                $data['json_option']= json_encode($data['json_option']);
            }

            if(array_key_exists('radio',$data)){
                unset($data['radio']);
            }

            if(array_key_exists('checkbox',$data)){
                unset($data['checkbox']);
            }


            if($data['type']=='dropdown'){
                if(!array_key_exists('json_option',$data)) throw new Exception("Options can't be Null Or Empty!", 403); 
            }

            $data['created_by'] = auth()->user()->id??null;

            Question::create($data);

            return back()->withSuccess('Question Added Successfully!');

        } catch (Exception $e) {
            return redirect()->back()->withDanger($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $surveys = Survey::pluck('title','id')->toArray();
        return view('backend.questions.edit',compact('question','surveys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question)
    {
        try{

            $validator = Validator::make(request()->all(),[
                'question'  => "required|unique:questions,question,{$question->id}",
                'survey_id' => 'required',
                'step_no'   => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data = request()->all();
            if(array_key_exists('is_required',$data)){
                $data['is_required']=1;
            }

            if(array_key_exists('json_option',$data)){
                if(count($data['json_option'])>0){
                    foreach($data['json_option'] as $d){
                        if(is_null($d))
                            throw new Exception("Options can't be Null Or Empty!", 403);      
                    }
                }

                $data['json_option']= json_encode($data['json_option']);
            }

            if(array_key_exists('radio',$data)){
                unset($data['radio']);
            }

            if(array_key_exists('checkbox',$data)){
                unset($data['checkbox']);
            }

            if($data['type']=='dropdown'){
                if(!array_key_exists('json_option',$data)) throw new Exception("Options can't be Null Or Empty!", 403); 
            }

            $data['updated_by'] = auth()->user()->id??null;
            $question->update($data);

            return back()->withSuccess('Question Updated Successfully!');

        } catch (Exception $e) {
            return redirect()->back()->withDanger($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
