<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsFormQuestions;
use App\EmsQuestionsAnswers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\EmsFormQuestionsRequest;
use App\Participant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmsFormsController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->current_user_id = Auth::id();
		$this->auth_user = User::find($this->current_user_id);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$forms = EmsForm::paginate(30);

		return view('forms/index', compact('forms'));
	}

	/*
	 *
	 */
	/**
	 * @param $id
	 * @return \Illuminate\View\View
     */
	public function create_question_form($form_url)
	{
		$forms = EmsForm::lists('name', 'id');
		$questions = EmsFormQuestions::where('q_type', '=', 'main')->lists('question_number', 'id');

		return view('forms/build_qform', compact('forms', 'questions', 'form_url'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function qedit($id)
	{
		//

		$forms = EmsForm::lists('name', 'id');
		$questions = EmsFormQuestions::where('q_type', '=', 'main')->lists('question_number', 'id');
		$question = EmsFormQuestions::find($id);

		return view('forms/edit_qform', compact('forms', 'questions','question', 'id'));
	}

	/**
	 * @param Request $request
	 * @return array
     */
	public function save_question(EmsFormQuestionsRequest $request, $form_url)
	{
		$form_input = $request->all();
		$form['form_id'] = $form_input['form_id'];

		$form['question_number'] = $form_input['question_number'];

		$form['question'] = $form_input['question'];

		$form['q_type'] = $form_input['q_type'];

		if($form_input['q_type'] == 'sub'){
			$form['parent_id'] = $form_input['main_id'];
		}else{
			$form['parent_id'] = null;
		}
		if($form_input['q_type'] != 'main') {
			$form['input_type'] = $form_input['input_type'];
			$form['answers'] =$form_input['answers'];
		}

		//return $form_input['answers']['answer-1'];
		$question = EmsFormQuestions::create($form);
		$message = 'New Question Created!';
		\Session::flash('form_build_success', $message);

		return redirect('forms/'.$form_url.'/build');
	}

	public function dataentry_form($form_name_url)
	{
		$form_name = urldecode($form_name_url);

		$form = EmsForm::where('name', '=', $form_name)->get();

		$form_id = $form->first()['id'];

		$enus = Participant::enumerator()->get();

		foreach($enus as $enumerator)
		{
			$enumerators[$enumerator['id']] = $enumerator['name'];
		}

		//$forms = EmsForm::lists('name', 'id');
		$questions = EmsFormQuestions::OfSingleMain($form_id)->idAscending()->paginate(30);
		return view('forms/dataentry', compact('questions','form_name_url', 'form_id', 'enumerators'));
	}


	public function dataentry_save($form_name_url, Request $request)
	{
		/*
		 * @var form_id
		 * @var enu_id
		 * @var q_id
		 * @var current user_id
		 * @var answers json array
		 */
		$form_name = urldecode($form_name_url);

		$form = EmsForm::where('name', '=', $form_name)->get();

		$form_id = $form->first()['id'];

		$input = $request->all();
		foreach ($input['answers'] as $q_id => $answer)
		{
			$answers['q_id'] = $q_id;
			$answers['answers'] = $answer;
			if(isset($form_id)){
				$answers['form_id'] = $form_id;
			}else {
				$answers['form_id'] = $input['form_id'];
			}
			$answers['enu_id'] = $input['enu_id'];
			$answers['user_id'] = $this->current_user_id;

			$new_answer = EmsQuestionsAnswers::updateOrCreate(array('q_id' => $answers['q_id'],
																	'form_id' => $answers['form_id'],
																	'enu_id' => $answers['enu_id'],
																	'user_id' => $answers['user_id']),$answers);
		}

		//$input['enu_id']
		//$answers_by_form_id = EmsQuestionsAnswers::ofFormId($form_id)->get();
		//print $answers;
		//print($input['form_id']);
		//print($form_id);
		$message = 'New Data Added for form '.$form_name.'!';
		\Session::flash('answer_success', $message);
		return redirect('forms/'.$form_name_url.'/dataentry');
	}

	public function results($forms)
	{
		//$answers = EmsQuestionsAnswers::answersByQ(1);

		$answers = EmsQuestionsAnswers::all();

		return view('results/index', compact('answers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return false;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$forms = EmsForm::create($request->all());
		return redirect('forms');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		//$single = EmsFormQuestions::Single();
		//return print_r($single->get());
		//$questions = EmsFormQuestions::ofFormID($id)->singlemain()->idAscending()->paginate(30);
		$questions = EmsFormQuestions::OfSingleMain($id)->idAscending()->paginate(30);

		return view('forms/view', compact('questions','id'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$form = EmsForm::find($id);
		return view('forms/edit_form', compact('form'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		return false;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 * @internal param int $id
	 */
	public function qupdate(Request $request, $id)
	{
		//
		$question = EmsFormQuestions::findOrFail($id);
		$form_input = $request->all();
		$form['form_id'] = $form_input['form_id'];

		$form['question_number'] = $form_input['question_number'];

		$form['question'] = $form_input['question'];

		$form['q_type'] = $form_input['q_type'];

		if($form_input['q_type'] == 'sub'){
			$form['parent_id'] = $form_input['main_id'];
		}else{
			$form['parent_id'] = null;
		}
		if($form_input['q_type'] != 'main') {
			$form['input_type'] = $form_input['input_type'];
			$form['answers'] =$form_input['answers'];
		}

		$question->update($form);
		return redirect('forms/questions');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$form = EmsForm::find($id);

		$form->delete();
		$message = 'Form '.$form->name.' deleted!';


		\Session::flash('flash_message', $message);

		return redirect('forms');
	}

	public function qdestroy($id)
	{
		//
		$question = EmsFormQuestions::find($id);

		$question->delete();
		$message = 'Question '.$question->question.' deleted!';


		\Session::flash('flash_message', $message);

		return redirect('forms/'.$id);
	}


}
