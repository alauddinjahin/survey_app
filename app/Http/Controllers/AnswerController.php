<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $email; 


    public function index()
    {
        
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

            $data = $request->all();

            if(!array_key_exists('name',$data) && !array_key_exists('email',$data) && !array_key_exists('survey_id',$data) && !array_key_exists('question_id',$data))
                throw new Exception("Invalid Request!", 403);

            if(is_null($data['name']))
                throw new Exception("Name is Required!", 403);

            if(is_null($data['email']))
                throw new Exception("Email is Required!", 403);

            if(!array_key_exists('survey_id',$data))
                throw new Exception("Survey is Required!", 403);

            if(count($data['question_id'])<1)
                throw new Exception("No Answer Fonud!", 404);

            if(array_key_exists('_token',$data)) unset($data['_token']);

            $voter = [
                'name'      => $data['name'],
                'email'     => isset($data['email']) ? $data['email']:null,
                'phone'     => isset($data['phone']) ? $data['phone']:null,
                'address'   => isset($data['address']) ? $data['address']:null
            ];  

            $this->email = $voter['email'];

            DB::beginTransaction();
            
            $voterExits = $this->check_voter_exits();
            if($voterExits){
                $vote_exists = $this->check_already_votes($voterExits->id,$data['survey_id']);
                if($vote_exists)
                {
                    throw new Exception("You already voted!", 403); 
                }

                $voter_id = $voterExits->id;  

            }else{
                $voter_id = DB::table('voters')->insertGetId($voter);
                if(!$voter_id)
                    throw new Exception("Unable to Add Voter!", 403);
            }

                
            foreach ($data['question_id'] as $q => $ans) {
                $answers = [
                    'survey_id'     => $data['survey_id'],
                    'voter_id'      => $voter_id,
                    'question_id'   => $q??null,
                    'answer'        => $ans??null,
                ];

                if(is_array($ans) && count($ans)>0){
                    foreach ($ans as $a) {
                        $answers['answer'] = $a ?? null; 
                        $inserted = DB::table('answers')->insert($answers);
                        
                        if(!$inserted)
                            throw new Exception("Please try again!", 403);
                    } 

                }else{
                    $inserted = DB::table('answers')->insert($answers);
                    if(!$inserted)
                        throw new Exception("Please try again!", 403);
                }

                
                    
            }


            DB::commit();

            return response()->json([
                'success'   => true,
                'msg'       => 'Congrats Your Answer Accepted!',
                'data'      => null,
            ],201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success'   => false,
                'msg'       => $e->getMessage(),
                'data'      => null,
            ],$e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }


    private function check_voter_exits()
    {
        return DB::table('voters')->where('email',$this->email)->first();
    }

    private function check_already_votes($voter_id,$survey_id)
    {
        return DB::table('answers')
        ->where('voter_id',$voter_id)
        ->where('survey_id',$survey_id)
        ->first();
    }
}
