<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsQuestionsAnswers;
use App\GeneralSettings;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$form_id = GeneralSettings::options('options', 'form_for_dashboard');

		//return $form_id;
		$data_array = EmsQuestionsAnswers::get_alldataentry($form_id);
		$dataentry = EmsQuestionsAnswers::where('form_id', '=', $form_id)->get();
		if(!isset($data_array)){
			$data_array = array();
		}
		//return array_count_values(array_column($data_array,'State'))['Ayeyarwady'];
		$forms = EmsForm::paginate(5);
		$no_answers = array_count_values(array_flatten(array_column($dataentry->toArray(),'answers')));
		$total_answers = array_sum($no_answers);
		if(array_key_exists(0, $no_answers)) {
			$no_answers_percent = ($no_answers[0] / $total_answers) * 100;
		}else{
			$no_answers_percent = 0;
		}

		//$ayewaddy = EmsQuestionsAnswers::getAllByState('Bago (West)', $data_array);
		//print $no_answers_percent;
		//print_r($ayewaddy);
		//return;

		return view('home', compact('data_array', 'dataentry', 'forms', 'no_answers_percent'));
	}

}
