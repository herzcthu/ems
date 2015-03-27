<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmsQuestionsAnswersController extends Controller {

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
		return 'this will be all questions and answers page';
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($form_name_url)
	{
		//This is Data entry submission page
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

			$enus = Participant::enumerator()->get();

			foreach ($enus as $enumerator) {
				$enumerators[$enumerator['id']] = $enumerator['name'];
			}

			if ($form_answers_count == 0 || empty($form_answers_count)) {
				$form_answers_count = GeneralSettings::options('options', 'answers_per_question');
			}
			//$forms = EmsForm::lists('name', 'id');
			$questions = EmsFormQuestions::OfSingleMain($id)->idAscending()->get();
			$form_id = $id;
			return view('forms/dataentry', compact('questions', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count'));

		} else {
			return view('errors/403');
		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	}

}
