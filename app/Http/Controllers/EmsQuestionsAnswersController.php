<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsFormQuestions;
use App\EmsQuestionsAnswers;
use App\GeneralSettings;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmsQuestionsAnswersRequest;
use App\Participant;
use App\PGroups;
use App\SpotCheckerAnswers;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmsQuestionsAnswersController extends Controller {

	public function __construct() {
		$this->middleware('auth');
		$this->current_user_id = Auth::id();
		$this->auth_user = User::find($this->current_user_id);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($form_name_url) {
		//
		$form_name = urldecode($form_name_url);
		try {
			$getform = EmsForm::where('name', '=', $form_name)->get();
			$form_array = $getform->toArray();
		} catch (QueryException $e) {
			$form_array = '';
		}
		//return $form->toArray();

		if (empty($form_array)) {
			$getform = EmsForm::find($form_name_url);
			$id = $getform->id;
			$form_name = $getform->name;
			$form_answers_count = $getform->no_of_answers;
		} elseif (!empty($form_array)) {
			$id = $getform->first()['id'];
			$form_answers_count = $getform->first()['no_of_answers'];
		} else {
			return view('errors/404');
		}

		$form = EmsForm::find($id);
		$questions = EmsFormQuestions::OfNotMain($id)->get();
		//dd($form->type);

		if ($form->type == 'spotchecker') {

			$dataentry = SpotCheckerAnswers::where('form_id', '=', $id)->paginate(50);

			$alldata = SpotCheckerAnswers::where('form_id', '=', $id)->get();

		} else {

			$dataentry = EmsQuestionsAnswers::where('form_id', '=', $id)->paginate(50);
			$alldata = EmsQuestionsAnswers::where('form_id', '=', $id)->get();
		}
		//dd($dataentry);
		//dd($alldata);

		foreach ($questions as $k => $q) {
			// print $q->id;
			// print("<br>");
			if ($q->q_type == 'sub') {
				if ($q->get_parent->input_type == 'same') {
					foreach ($q->get_parent->answers as $kk => $answer) {
						// print_r(array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $kk)));
						if (array_key_exists($kk, array_count_values(array_dot(array_column(array_column($alldata->toArray(), 'answers'), $q->id))))) {
							// print $q->question_number;
							// print $q->id;
							// print $kk;
							// print(array_count_values(array_column(array_column($alldata->toArray(), 'answers'),$q->id))[$kk]);
							// print array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id))[$kk];
						}
						// print("<br>");
					}
				}
			}
		}

		//return;

		return view('dataentry/index', compact('form_name_url', 'dataentry', 'form', 'questions', 'alldata'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($form_name_url, Request $request) {
		$form_name = $request->route('form');
		//dd($form_name);
		if ($this->auth_user->can("add.data")) {
			$form_name = urldecode($form_name_url);

			$getform = EmsForm::where('name', '=', $form_name)->get();
			//return $form->toArray();
			$form_array = $getform->toArray();
			if (empty($form_array)) {
				$getform = EmsForm::find($form_name_url);
				$id = $getform->id;
				$form_name = $getform->name;
				$form_answers_count = $getform->no_of_answers;
			} elseif (!empty($form_array)) {
				$id = $getform->first()['id'];
				$form_answers_count = $getform->first()['no_of_answers'];
			} else {
				return view('errors/404');
			}

			$form = EmsForm::find($id);

			$pgroup_id = $form->pgroup_id;

			$pgroup = PGroups::find($pgroup_id);

			$enumerators = $pgroup->participants()->lists('name', 'id');

			if ($form_answers_count == 0 || empty($form_answers_count)) {
				$form_answers_count = GeneralSettings::options('options', 'answers_per_question');
			}
			//$forms = EmsForm::lists('name', 'id');
			$questions = EmsFormQuestions::OfNotSub($id)->ListIdAscending()->get();
			//$questions_array = $questions->toArray();
			//dd($questions_array);
			$form_id = $id;

			return view('dataentry/dataentry', compact('questions', 'form', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count'));

		} else {
			return view('errors/403');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($form_name_url, EmsQuestionsAnswersRequest $request) {
		//dd($request->all());

		$form_name = urldecode($form_name_url);
		if ($this->auth_user->can("add.data")) {

			$this->CreateAndStore($form_name, $request);

			$message = 'New Data Added for form ' . $form_name . '!';
			\Session::flash('answer_success', $message);
		} else {
			$message = 'Not allow to add new data for' . $form_name . '!';
			\Session::flash('answer_success', $message);
		}
		return redirect($form_name_url . '/dataentry/create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($form_name_url, $interviewee, Request $request) {
		$form_name = $request->route('form');
		//dd($form_name);
		if ($this->auth_user->can("add.data")) {
			$form_name = urldecode($form_name_url);

			$getform = EmsForm::where('name', '=', $form_name)->get();
			//return $form->toArray();
			$form_array = $getform->toArray();
			if (empty($form_array)) {
				$getform = EmsForm::find($form_name_url);
				$id = $getform->id;
				$form_name = $getform->name;
				$form_answers_count = $getform->no_of_answers;
			} elseif (!empty($form_array)) {
				$id = $getform->first()['id'];
				$form_answers_count = $getform->first()['no_of_answers'];
			} else {
				return view('errors/404');
			}

			$form = EmsForm::find($id);

			$pgroup_id = $form->pgroup_id;

			$pgroup = PGroups::find($pgroup_id);

			$enumerators = $pgroup->participants()->lists('name', 'id');

			if ($form_answers_count == 0 || empty($form_answers_count)) {
				$form_answers_count = GeneralSettings::options('options', 'answers_per_question');
			}
			//$forms = EmsForm::lists('name', 'id');
			$questions = EmsFormQuestions::OfNotSub($id)->ListIdAscending()->get();
			//$questions_array = $questions->toArray();
			//dd($questions_array);
			$form_id = $id;
			if ($form->type == 'enumerator') {
				$dataentry = EmsQuestionsAnswers::find($interviewee);
			}
			if ($form->type == 'spotchecker') {
				$dataentry = SpotCheckerAnswers::find($interviewee);
			}
			$edit = true;
			//return $dataentry;
			return view('dataentry/edit_dataentry', compact('dataentry', 'questions', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count', 'interviewee', 'form', 'edit'));
		} else {
			return view('errors/403');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($form_name_url, $interviewee, EmsQuestionsAnswersRequest $request) {
		//return $interviewee;

		$form_name = urldecode($form_name_url);

		$form = EmsForm::where('name', '=', $form_name)->get();

		$form_id = $form->first()['id'];

		$form_type = $form->first()['type'];
		if ($form_type == 'enumerator') {
			$answer = EmsQuestionsAnswers::find($interviewee);
			$user_id = $answer->user_id;
		}
		if ($form_type == 'spotchecker') {
			$answer = SpotCheckerAnswers::find($interviewee);
			$user_id = $answer->user_id;
		}
		if ($this->auth_user->can("edit.data") || $this->current_user_id == $user_id) {

			$this->CreateAndStore($form_name, $request);

			$message = 'Data updated for form ' . $form_name . '!';
			\Session::flash('answer_success', $message);
		} else {
			$message = 'Not allow to edit data for' . $form_name . '!';
			\Session::flash('answer_success', $message);
		}
		return redirect('/' . $form_name_url . '/dataentry/' . $interviewee . '/edit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

	private function CreateAndStore($form_name, $request) {

		/*
		 * @var form_id
		 * @var enu_id
		 * @var q_id
		 * @var current user_id
		 * @var answers json array
		 */
		//$form_name = urldecode($form_name_url);
		//return $request->all();

		$form = EmsForm::where('name', '=', $form_name)->get();

		$form_id = $form->first()['id'];

		$form_type = $form->first()['type'];

		$input = $request->all();

		$input_answers = $input['answers'];
		array_walk($input_answers, function (&$value, $key) {
			// if you want to change array values then "&" before the $value is mandatory.
			$question = EmsFormQuestions::find($key);
			if (in_array($question->input_type, array('text', 'year', 'time', 'date', 'month'))) {
				if (is_array($value) && !empty($value)) {
					array_walk($value, function (&$val, $k) {
						if (empty($val) || in_array(strtolower($val), array('00:00', 'no', 'no answers', 'no answer', '-99'))) {
							$val = '-99';
						}
					});

				} else {

					if (empty($value) || in_array(strtolower($value), array('00:00', 'no', 'no answers', 'no answer', '-99'))) {
						$value = '-99';
					}
				}
			}
		});

		$answers['user_id'] = $this->current_user_id;
		$answers['psu'] = $input['psu'];
		$answers['answers'] = $input_answers;

		$answers['form_complete'] = (bool) true;
		foreach ($answers['answers'] as $q => $a) {

			$question = EmsFormQuestions::find($q);

			if (is_array($a)) {
				if (in_array('-99', array_values($a))) {
					if ($question->a_view != 'categories' && $question->optional == false) {
						$answers['form_complete'] = (bool) false;

					}
				}

			} else {
				if ($a == '-99') {
					if ($question->a_view != 'categories' && $question->optional == false) {
						$answers['form_complete'] = (bool) false;
					}
				}
			}
		}
		if (isset($input['notes'])) {
			$answers['notes'] = $input['notes'];
		} else {
			$answers['notes'] = array();
		}
		if (isset($form_id)) {
			$answers['form_id'] = $form_id;
		} else {
			$answers['form_id'] = $input['form_id'];
		}
		//dd($input_answers);
		if ($form_type == 'spotchecker') {
			$enu_interviewee_id = $input['enu_form_id'];

			$answers['enumerator_form_id'] = $enu_interviewee_id;
			preg_match('/([0-9]{6})[0-9]/', $enu_interviewee_id, $matches);
			$enu_id = $matches[1];
			$participant_id = Participant::where('participant_id', '=', $enu_id)->pluck('id');
			$participant = Participant::find($participant_id);
			foreach ($participant->parents as $parent) {
				if ($parent->participant_type == 'coordinator') {
					$coordinator = $parent;
				}
				if ($parent->participant_type == 'spotchecker') {
					$spotchecker = $parent;
				}
			}
			$answers['spotchecker_id'] = $spotchecker->participant_id;

			if (isset($form_id)) {
				$answers['form_id'] = $form_id;
			} else {
				$answers['form_id'] = $input_answers;
			}
			//return $answers;
			$new_answer = SpotCheckerAnswers::updateOrCreate(array('enumerator_form_id' => $answers['enumerator_form_id']), $answers);

		} else {
			//return $input;

			$answers['interviewer_id'] = $input['interviewer_id'];
			$answers['interviewee_id'] = $input['interviewer_id'] . $input['interviewee_id'];
			$answers['interviewee_gender'] = $input['interviewee_gender'];

			//return $answers;
			$new_answer = EmsQuestionsAnswers::updateOrCreate(array('interviewee_id' => $answers['interviewee_id']), $answers);

		}
	}

}
