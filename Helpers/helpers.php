<?php

use App\Models\Answer;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

//helper function Check
if(!function_exists('numOfUsers')){

	function numOfUsers()
	{
		return User::count();
	}

}

if(!function_exists('numOfSurveys')){

	function numOfSurveys()
	{
		return Survey::count();
	}

}


if(!function_exists('todays_participant')){

	function todays_participant()
	{
		return DB::table('voters')->whereDate('created_at', '>=', date('Y-m-d'))->count();
	}

}

if(!function_exists('totalVote')){

	function totalVote($survey_id=null,$id=null)
	{
		return DB::table('answers')
		->where('survey_id', $survey_id)
		->where('question_id', $id)
		->count();
	}

}

if(!function_exists('hasQuestions')){

	function hasQuestions($id=null)
	{
		return DB::table('questions')->where('survey_id', $id)->count();
	}

}

if(!function_exists('hasVotes')){

	function hasVotes($id=null)
	{
		return DB::table('answers')->where('survey_id', $id)->count();
	}

}

if(!function_exists('hasSubVotes')){

	function hasSubVotes($survey_id=null, $question_id=null,$answer=null)
	{
		return DB::table('answers')
		->where('survey_id', $survey_id)
		->where('question_id', $question_id)
		->where('answer', $answer)
		->count();
	}

}



if(!function_exists('questionTypes')){

	function questionTypes()
	{
		return $types = [
            'radio'     =>'Single Choice',
            'checkbox'  =>'Multiple Choice',
            'textarea'  =>'Text',
            'dropdown'  =>'Dropdown',
        ];
	}

}


if(!function_exists('fetch_editable_options')){

	function fetch_editable_options($type,$json,$viewmode=false,$question=null)
	{
		switch ($type) {
			case 'radio':
				if($viewmode){
					$html=viewModeRadio($json,$question);
					return $html;
				}
				$html=renderRadio($json);
				break;
			case 'checkbox':
				if($viewmode){
					$html=viewModeCheckbox($json,$question);
					return $html;
				}

				$html=renderCheckbox($json);
				break;
			case 'dropdown':

				if($viewmode){
					$html=viewModeDropdown($json,$question);
					return $html;
				}

				$html=renderDropdown($json);
				break;
			case 'textarea':
				if($viewmode){
					$html=viewModeTextarea($json,$question);
					return $html;
				}

				$html =renderTextarea($json);
				break;
		}

		return $html;
	}

}




function viewModeTextarea($json=null,$question)
{

	$required = required($question);
	$el ='
	<div class="form-group">
		<textarea class="form-control question '.$required.'" '.$required.' name="question_id['.$question->id.']" data-question="'.$question->id.'" rows="4" placeholder="Write Something ..."></textarea>
	</div>';

	return $el;					
}


function viewModeRadio($json=null,$question)
{
	$options = json_decode($json);
	if(is_null($options) || count($options)<1) return;

	$el ='';

	foreach ($options as $k => $option) {
		$el .=  '
			<div class="form-group d-flex">
				<label>
					<input name="question_id['.$question->id.']" data-question="'.$question->id.'"  value="'.$option.'" type="radio" class="w-20 question" '.($k==0?'checked':'').' />
					'.$option.'
				</label>
			</div>
		';
	}

	$el .= '';

	return $el;					
}


function viewModeCheckbox($json=null,$question)
{
	$options = json_decode($json);
	if(is_null($options) || count($options)<1) return;

	$required = required($question);

	$el ='';

	foreach ($options as $k => $option) {
		$el .=  '
			<div class="form-group d-flex questionCheck checkboxArea-'.$required.'">
				<label>
					<input name="question_id['.$question->id.'][]" data-question="'.$question->id.'" value="'.$option.'" type="checkbox" class="w-20" '.$required.' />
					'.$option.'
				</label>
			</div>
		';
	}

	$el .= '';

	return $el;					
}

function viewModeDropdown($json=null,$question)
{
	$options = json_decode($json);

	if(is_null($options) || count($options)<1) return;

	$required = required($question);

	$el ='<div class="form-group pl-2">
		<select name="question_id['.$question->id.']" id="dropdown" class="form-control select2 question '.$required.'" '.$required.'>';

		foreach ($options as $key => $option){
			$el .= '
				<option value="'.$option.'" data-question="'.$question->id.'">'.$option.'</option>
			';
		}

		$el .='</select>
		</div>';

	return $el;
}

//------------------

function required($question)
{
	return boolval($question->is_required)?'required':'';
}

function renderRadio($json=null)
{
	$options = json_decode($json);
	if(is_null($options) || count($options)<1) return;

	$el ='<div class="main-container pl-2">';

	foreach ($options as $key => $option) {
		$el .=  '
			<div class="form-group handle d-flex">
				<input name="radio" type="radio" class="w-20 mt-1" checked />
				<input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value="'.$option.'"/>
			</div>
		';
	}

	$el .= '</div>
		<div class="form-group pl-4">
			<button type="button" class="btn btn-sm btn-info addOptionSingleChoice"> + Add</button>
		</div>';

	return $el;					
}


function renderCheckbox($json=null)
{
	$options = json_decode($json);
	if(is_null($options) || count($options)<1) return;

	$el ='<div class="main-container-multi pl-2">';

	foreach ($options as $key => $option) {
		$el .=  '
		<div class="form-group handle d-flex">
			<input name="checkbox" type="checkbox" class="w-20 mt-1" checked/>
			<input type="text" name="json_option[]" class="form-control form-control-sm label-input w-50 ml-2" value="'.$option.'"/>
		</div>
		';
	}

	$el .= '</div>
			<div class="form-group pl-4">
				<button type="button" class="btn btn-sm btn-info addOptionMultipleChoice"> + Add</button>
			</div>';

	return $el;					
}


function renderTextarea()
{

	$el ='
	<div class="main-container-textarea pl-2">
		<div class="form-group handle d-flex">
			<textarea class="form-control" rows="4" disabled>Write Something ...</textarea>
		</div>
	</div>';

	return $el;					
}



function renderDropdown($json=null)
{
	$options = json_decode($json);

	if(is_null($options) || count($options)<1) return;

	$el ='<div class="main-container-dropdown pl-2">
		<i class="fa fa-edit addItem text-success float-right px-2 my-2" type="button"></i>
		<select id="dropdown" class="form-control">';

		foreach ($options as $key => $option){
			$el .= '
				<option value="">'.$option.'</option>
			';
		}

	$el .='</select>
			<div id="dropdown_input_area" class="mt-2"></div>
		</div>';

	return $el;
}



if(!function_exists('auth_user_by_id')){

	function auth_user_by_id($id=null)
	{
		return User::find($id);
	}

}


if(!function_exists('check_internet')){

	function check_internet()
	{
		try 
		{
			$host_name  = 'www.google.com';
            $port_no    = '80';

            $st = (bool)@fsockopen($host_name, $port_no, $err_no, $err_str, 10);
			if (!$st) 
                throw new Exception("Please check Your Internet!.", 403);
				return [
					'success'	=>true,
					'msg'	 	=>'',
					'code'		=>200
				];

		} catch (Exception $e) {
			return [
				'success'	=>false,
				'msg'	 	=>$e->getMessage(),
				'code'		=>$e->getCode()
			];
		}
	}

}


if(!function_exists('month_wise_data')){

	function month_wise_data()
	{
		try 
		{
			$answers = Answer::select('id', 'created_at')
			->get()
			->groupBy(function($date) {
				return Carbon::parse($date->created_at)->format('m');
			});


			$ansCount 	= [];
			$ansArr		= [];
			$newArr		= [];

			foreach ($answers as $key => $value) { $ansCount[(int)$key] = count($value); }

			for($i = 1; $i <= 12; $i++){ $ansArr[$i] = $ansCount[$i]??0; }

			foreach ($ansArr as $key => $value) { $newArr[] = $value; }
			
			return $newArr;

		} catch (Exception $e) {
			return [
				'success'	=>false,
				'msg'	 	=>$e->getMessage(),
				'code'		=>$e->getCode()
			];
		}
	}

}
