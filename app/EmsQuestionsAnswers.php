<?php namespace App;

use App\Villages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Request;

class EmsQuestionsAnswers extends Model {

	//
	/**
	 * Table name.
	 *
	 * @var string
	 */
	protected $table = 'ems_questions_answers';

	protected $fillable = ['answers', 'notes', 'form_id',
		'enu_id', 'user_id', 'interviewee_id',
		'interviewee_gender', 'form_complete', 'interviewer_id', 'psu'];

	public function participant() {
		return $this->belongsTo('App\Participant', 'interviewer_id', 'participant_id');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function ScAnswers() {
		return $this->belongsTo('App\SpotCheckerAnswers', 'interviewee_id');
	}

	public function scopeOfFormId($query, $formid) {
		return $query->whereFormId($formid);
	}

	private function compare($a, $b) {
		$a = preg_replace('/^[\-]/', '', $a);
		$b = preg_replace('/^[\-]/', '', $b);
		return strcasecmp($a, $b);
	}
	public function setNotesAttribute($value) {
		$notes = array_filter($value);
		uksort($notes, array($this, 'compare'));

		$this->attributes['notes'] = json_encode($notes);
		// return json_encode($value);
	}

	/**
	 * Decode Answers json string from database
	 * @param $value
	 * @return object
	 */
	public function getNotesAttribute($value) {
		// return $value;
		return json_decode($value, true);
	}

	public function setIntervieweeIdAttribute($value) {
		// return $value;
		$request = Request::all();

		//print_r($request);

		//die();

		$this->attributes['interviewee_id'] = $value;
		// return json_encode($value);
	}

	public function setAnswersAttribute($value) {
		// return $value;
		$this->attributes['answers'] = json_encode($value);
		// return json_encode($value);
	}
	/**
	 * Decode Answers json string from database
	 * @param $value
	 * @return object
	 */
	public function getAnswersAttribute($value) {
		// return $value;
		return json_decode($value, true);
	}

	public static function scopeOfAnswersByQ($query, $q_id) {
		return $query->where('q_id', '=', $q_id);
	}

	public static function scopeOfAnswersByInterviewee($query, $interviewee_id) {
		return $query->where('interviewee_id', '=', $interviewee_id);
	}

	public static function scopeOfAnswersByEmu($query, $emu_id) {
		return $query->where('interviewer_id', $emu_id);
	}

	public static function scopeOfAnsByInvWithQ($query, $inv, $q_id) {
		$query->where('q_id', '=', $q_id)->where('interviewee_id', '=', $inv);
		//  $query->where(function($query)
		//  {
		//     $query->where('q_type', '=', 'single')->orWhere('q_type', '=', 'sub');
		//  });
		return $query;
	}

	/**
	 * Generate all data entry array from database
	 * @param $form_name_url
	 * @return array
	 */
	public static function get_alldataentry($form_name_url) {
		$form_name = urldecode($form_name_url);
		try {
			$getform = EmsForm::where('name', '=', $form_name)->get();
			$form_array = $getform->toArray();
		} catch (QueryException $e) {
			$form_array = '';
		}
		//return $form->toArray();
		try {
			$getform = EmsForm::find($form_name_url);
		} catch (QueryException $e) {
			$error = $e;
		}
		if (null !== $getform) {
			$id = $getform->id;
		} elseif (!empty($form_array)) {
			$id = $getform->first()['id'];
		} else {
			return false;
		}

		$dataentry = EmsQuestionsAnswers::where('form_id', $id)->get();
		//dd($questions, $dataentry);

		if (!empty($dataentry->toArray())) {
			foreach ($dataentry as $data) {

				//var_dump($data->ScAnswers);

				$alldata[$data->interviewee_id]['Interviewee ID'] = $data->interviewee_id;
				$alldata[$data->interviewee_id]['Interviewee Gender'] = $data->interviewee_gender;
				$alldata[$data->interviewee_id]['Interviewer ID'] = $data->interviewer_id;
				$alldata[$data->interviewee_id]['Data Enterer ID'] = $data->user_id;
				$alldata[$data->interviewee_id]['PSU'] = $data->psu;
				if ($data->form_complete == true) {
					$alldata[$data->interviewee_id]['Form Status'] = 'Complete';
				} else {
					$alldata[$data->interviewee_id]['Form Status'] = 'Incomplete';
				}

				preg_match('/([1-9][0-9]{2})([0-9]{3})/', $data->interviewer_id, $matches);

				//return $matches;

				$locations = \Illuminate\Support\Facades\Cache::rememberForever("locations-$matches[2]", function () use ($matches) {
					return Villages::getLocations($matches[2]);
				});

				//$locations = Villages::getLocations($matches[2]);

				//dd($locations);
				//$village_name = Villages::getVillageName($matches[2]);

				$alldata[$data->interviewee_id]['State'] = $locations['state']['state'];
				$alldata[$data->interviewee_id]['District'] = $locations['district']['district'];
				$alldata[$data->interviewee_id]['Township'] = $locations['township']['township'];
				$alldata[$data->interviewee_id]['Village Track'] = $locations['village']['villagetrack'];
				$alldata[$data->interviewee_id]['Village'] = $locations['village']['village'];

				foreach ($data->answers as $key => $value) {
					$q = \Illuminate\Support\Facades\Cache::rememberForever("question-$key", function () use ($key) {
						return EmsFormQuestions::find($key);
					});
					if (!empty($data->notes)) {
						foreach ($data->notes as $nk => $note) {

							//print $note . '=>' . $nk;

						}
					}
					//dd($q);
					//$alldata[$data->interviewee_id]['question'][$key] = $question->question_number;
					if (is_array($value)) {
						foreach ($value as $vk => $va) {
							if (!is_array($va)) {
								if (!in_array($q->q_type, array('main', 'single'))) {
									$alldata[$data->interviewee_id][$q->get_parent->question_number . $q->question_number . $vk] = $va;
								} else {
									$alldata[$data->interviewee_id][$q->question_number . $vk] = $va;
								}
							} else {
								foreach ($va as $nkey => $nvalue) {
									if (!in_array($q->q_type, array('main', 'single'))) {
										$alldata[$data->interviewee_id][$q->get_parent->question_number . $q->question_number . sprintf("Category_%03d", $nkey)] = $nvalue;
									} else {
										$alldata[$data->interviewee_id][$q->question_number . sprintf("Category_%03d", $nkey)] = $nvalue;
									}
								}
							}

						}
						//die();

					} else {
						if (!in_array($q->q_type, array('main', 'single'))) {
							$alldata[$data->interviewee_id][$q->get_parent->question_number . $q->question_number] = $value;
						} else {
							$alldata[$data->interviewee_id][$q->question_number] = $value;
						}
					}
				}

			}
		} else {
			$alldata = array();
		}
		//dd($alldata);
		return $alldata;
	}

	public static function get_alldatainfo($form_name_url) {
		$form_name = urldecode($form_name_url);
		try {
			$getform = EmsForm::where('name', '=', $form_name)->get();
			$form_array = $getform->toArray();
		} catch (QueryException $e) {
			$form_array = '';
		}
		//return $form->toArray();
		try {
			$getform = EmsForm::find($form_name_url);
		} catch (QueryException $e) {
			$error = $e;
		}
		if (null !== $getform) {
			$id = $getform->id;
		} elseif (!empty($form_array)) {
			$id = $getform->first()['id'];
		} else {
			return false;
		}

		$dataentry = EmsQuestionsAnswers::where('form_id', $id)->get();
		//dd($questions, $dataentry);

		if (!empty($dataentry->toArray())) {
			foreach ($dataentry as $data) {

				//var_dump($data->ScAnswers);

				$alldata[$data->interviewee_id]['Interviewee ID'] = $data->interviewee_id;
				$alldata[$data->interviewee_id]['Interviewee Gender'] = $data->interviewee_gender;
				$alldata[$data->interviewee_id]['Interviewer ID'] = $data->interviewer_id;
				if ($data->form_complete == true) {
					$alldata[$data->interviewee_id]['Form Status'] = 'Complete';
				} else {
					$alldata[$data->interviewee_id]['Form Status'] = 'Incomplete';
				}

				preg_match('/([1-9][0-9]{2})([0-9]{3})/', $data->interviewer_id, $matches);

				//return $matches;

				$locations = \Illuminate\Support\Facades\Cache::rememberForever("locations-$matches[2]", function () use ($matches) {
					return Villages::getLocations($matches[2]);
				});

				//$locations = Villages::getLocations($matches[2]);

				//dd($locations);
				//$village_name = Villages::getVillageName($matches[2]);

				$alldata[$data->interviewee_id]['State'] = $locations['state']['state'];
				$alldata[$data->interviewee_id]['District'] = $locations['district']['district'];
				$alldata[$data->interviewee_id]['Township'] = $locations['township']['township'];
				$alldata[$data->interviewee_id]['Village Track'] = $locations['village']['villagetrack'];
				$alldata[$data->interviewee_id]['Village'] = $locations['village']['village'];

			}
		} else {
			$alldata = array();
		}
		//dd($alldata);
		return $alldata;
	}

	public static function getAllByState($state, $alldata) {
		$statedata = array();
		foreach ($alldata as $data) {
			if (in_array($state, $data)) {
				$statedata[] = $data;
			}
		}
		return $statedata;
	}

	/**

	public static function ExportArray($form_id)
	{
	//return $form_id;
	$totalinv = EmsQuestionsAnswers::where('form_id','=', $form_id)->lists('interviewee_id');
	//return $totalinv;
	$uniqueinv = array_values(array_unique($totalinv));

	//return $uniqueinv;

	for($i=0; $i < count($uniqueinv); $i++){

	$answers_for_inv = EmsQuestionsAnswers::where('interviewee_id', '=', $uniqueinv[$i])->get();


	foreach($answers_for_inv as $k => $v)
	{


	$enumerator = Participant::find( $v['enu_id']);

	$questions = EmsFormQuestions::find($v['q_id']);

	$answers[$uniqueinv[$i]][$v['q_id']] = EmsQuestionsAnswers::where('interviewee_id', '=', $uniqueinv[$i])->where('q_id', '=', $v['q_id']);

	$form = EmsForm::where('id', '=', $v['form_id']);

	$user = User::where('id', '=', $v['user_id']);

	$totalquestions_per_form = EmsFormQuestions::find($v['form_id'])->get();


	}


	}


	$ans1 = array();

	foreach($answers as $k => $answer)
	{
	;
	foreach( $answer as $key => $ans){

	$ans1[$k][$key] = $ans->first()['answers']['answer'];
	}



	}
	//print $enumerator->villages->first()['village_id'];


	// print $totalquestions_per_form[1]->id;
	array_walk($ans1, array('self', 'print_ans'), $totalquestions_per_form);


	array_walk($ans1, array('self', 'change_ans_key'), compact('totalquestions_per_form','enumerator'));
	return $ans1;

	}
	public static function print_ans(&$item , $key, $object)
	{
	foreach($object as $question){
	if($question->q_type != 'main') {
	if (!array_key_exists($question->id, $item)) {
	$item[$question->id] = '';
	ksort($item);
	}
	}

	}
	}
	public static function array_unshift_assoc(&$arr, $key, $val)
	{
	$arr = array_reverse($arr, true);
	$arr[$key] = $val;
	return array_reverse($arr, true);
	}
	public static function change_ans_key(&$item, $key, $object)
	{

	foreach($item as $k => $v){
	$question = EmsFormQuestions::find($k);

	/// print $k;
	// print $v;
	$q_num = '';
	if($question->q_type == 'sub')
	{
	$q_num .= $question->get_parent->question_number;
	}

	$q_num .= $question->question_number;

	$arr[$q_num] = $v;
	}
	$item = $arr;


	$item = self::array_unshift_assoc($item, 'interviewee_id', $key);

	}
	 **/

}
