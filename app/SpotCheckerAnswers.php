<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotCheckerAnswers extends Model {

	//
	/**
	 * Table name.
	 *
	 * @var string
	 */
	protected $table = 'spot_checker_answers';

	protected $fillable = ['answers', 'notes', 'form_id', 'spotchecker_id', 'enumerator_form_id', 'user_id'];

	public function EnuAnswers() {
		return $this->hasOne('App\EmsQuestionsAnswers', 'enumerator_form_id', 'enumerator_form_id');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
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

		//$questions = EmsFormQuestions::OfNotMain($id)->get();
		$dataentry = SpotCheckerAnswers::where('form_id', '=', $id)->get();
		//dd($questions);

		if (!empty($dataentry->toArray())) {
			foreach ($dataentry as $data) {

				//dd($dataentry);

				$alldata[$data->enumerator_form_id]['Interviewee ID'] = $data->enumerator_form_id;
				//$alldata[$data->enumerator_form_id]['Interviewee Gender'] = $data->interviewee_gender;
				$alldata[$data->enumerator_form_id]['Spotchecker ID'] = $data->spotchecker_id;

				$alldata[$data->enumerator_form_id]['Data Enterer ID'] = $data->user_id;
				$alldata[$data->enumerator_form_id]['PSU'] = $data->psu;

				preg_match('/([1-9][0-9]{2})([0-9]{3})[0-9]/', $data->enumerator_form_id, $matches);

				//return $matches;

				$locations = \Illuminate\Support\Facades\Cache::rememberForever("locations-$matches[2]", function () use ($matches) {
					return Villages::getLocations($matches[2]);
				});
				$enumerator_id = $matches[1] . $matches[2];

				//$village_name = Villages::getVillageName($matches[2]);

				$alldata[$data->enumerator_form_id]['State'] = $locations['state']['state'];
				$alldata[$data->enumerator_form_id]['District'] = $locations['district']['district'];
				$alldata[$data->enumerator_form_id]['Township'] = $locations['township']['township'];
				$alldata[$data->enumerator_form_id]['Village Track'] = $locations['village']['villagetrack'];
				$alldata[$data->enumerator_form_id]['Village'] = $locations['village']['village'];

				//dd($data->answers);

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
					//$alldata[$data->enumerator_form_id]['question'][$key] = $question->question_number;
					if (is_array($value)) {
						foreach ($value as $vk => $va) {
							if (!is_array($va)) {
								if (!in_array($q->q_type, array('main', 'single', 'spotchecker'))) {
									$alldata[$data->enumerator_form_id][$q->get_parent->question_number . $q->question_number . $vk] = $va;
								} else {
									$alldata[$data->enumerator_form_id][$q->question_number . $vk] = $va;
								}
							} else {
								foreach ($va as $nkey => $nvalue) {
									if (!in_array($q->q_type, array('main', 'single', 'spotchecker'))) {
										$alldata[$data->enumerator_form_id][$q->get_parent->question_number . $q->question_number . sprintf("Category_%03d", $nkey)] = $nvalue;
									} else {
										$alldata[$data->enumerator_form_id][$q->question_number . sprintf("Category_%03d", $nkey)] = $nvalue;
									}
								}
							}

						}
						//die();

					} else {
						if (!in_array($q->q_type, array('main', 'single', 'spotchecker'))) {
							$alldata[$data->enumerator_form_id][$q->get_parent->question_number . $q->question_number] = $value;
						} else {
							$alldata[$data->enumerator_form_id][$q->question_number] = $value;
						}
					}
				}

			}
		} else {
			$alldata = array();
		}

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

}
