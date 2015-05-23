<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsQuestionsAnswers;
use App\GeneralSettings;
use App\States;

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
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index() {

		$form_id = GeneralSettings::options('options', 'form_for_dashboard');
		//dd($form_id);

		$dashboard_form = EmsForm::find($form_id);

		//return $form_id;
		$data_array = EmsQuestionsAnswers::get_alldatainfo($form_id);
		//return $data_array;
		$dataentry = EmsQuestionsAnswers::where('form_id', $form_id)->get();

		$forms = EmsForm::paginate(5);

		//dd(array_column($data_array, 'Form Status', 'Interviewee ID'));
		$form_status_count = array_count_values(array_column($data_array, 'Form Status'));

		if (in_array('Incomplete', $form_status_count)) {
			$no_answers_percent = ($form_status_count['Incomplete'] / count($data_array)) * 100;
		}

		$gender_count = array_count_values(array_column($data_array, 'Interviewee Gender'));

		$gender['M'] = ($gender_count['M'] / count($data_array)) * 100;
		$gender['F'] = ($gender_count['F'] / count($data_array)) * 100;
		$gender['U'] = ($gender_count['U'] / count($data_array)) * 100;
		$gender['0'] = ($gender_count['0'] / count($data_array)) * 100;
		//dd($gender);

		$all_state = States::lists('state', 'id');
		//dd($all_state);
		foreach ($all_state as $state_id => $state_name) {

			if ($state_name == 'Ayeyarwady') {
				$abbr_state = 'AWD';
			}
			if ($state_name == 'Bago (East)') {
				$abbr_state = 'BG(E)';
			}
			if ($state_name == 'Bago (West)') {
				$abbr_state = 'BG(W)';
			}
			if ($state_name == 'Chin') {
				$abbr_state = 'CHN';
			}
			if ($state_name == 'Sagaing') {
				$abbr_state = 'SGG';
			}
			if ($state_name == 'Mandalay') {
				$abbr_state = 'MDY';
			}
			if ($state_name == 'Yangon') {
				$abbr_state = 'YGN';
			}
			if ($state_name == 'Shan (East)') {
				$abbr_state = 'SH(E)';
			}
			if ($state_name == 'Shan (South)') {
				$abbr_state = 'SH(S)';
			}
			if ($state_name == 'Shan (North)') {
				$abbr_state = 'SH(N)';
			}
			if ($state_name == 'Tanintharyi') {
				$abbr_state = 'TNTY';
			}
			if ($state_name == 'Mon') {
				$abbr_state = 'MON';
			}
			if ($state_name == 'Kachin') {
				$abbr_state = 'KCN';
			}
			if ($state_name == 'Kayah') {
				$abbr_state = 'KYA';
			}
			if ($state_name == 'Kayin') {
				$abbr_state = 'KYN';
			}
			if ($state_name == 'Rakhine') {
				$abbr_state = 'RKH';
			}
			if ($state_name == 'Naypyitaw') {
				$abbr_state = 'NPW';
			}
			if ($state_name == 'Magway') {
				$abbr_state = 'MGW';
			}
			$dataByState = EmsQuestionsAnswers::getAllByState($state_name, $data_array);
			$location_data[$state_name]['answers'] = $dataByState;
			$incomplete_count = 0;
			for ($i = 0; $i < count($dataByState); $i++) {
				if (in_array('Incomplete', $dataByState[$i])) {
					$incomplete_count++;
				}
			}
			$location_data[$state_name]['incomplete_count'] = $incomplete_count;
			$location_data[$state_name]['abbr'] = $abbr_state;
			if (array_key_exists($state_name, array_count_values(array_column($data_array, 'State')))) {

				$location_data[$state_name]['answer_count'] = array_count_values(array_column($data_array, 'State'))[$state_name];
				$state = States::find($state_id);
				$location_data[$state_name]['townships'] = $state->townships;

				States::where('id', $state_id)->with(['townships.villages' => function ($q) use (&$villages) {
					$villages = $q->get()->unique();
				}])->get();
				$location_data[$state_name]['villages'] = $villages;

			} else {
				$location_data[$state_name]['answer_count'] = 0;
			}

			if (array_key_exists($state_name, array_count_values(array_column($data_array, 'State')))) {

				$location_data[$state_name]['completed_forms'] = round((($location_data[$state_name]['answer_count'] - $incomplete_count) / (count($location_data[$state_name]['villages']) * 9) * 100), 2);
				$location_data[$state_name]['incomplete_form'] = round(($incomplete_count / (count($location_data[$state_name]['villages']) * 9) * 100), 2);
				$location_data[$state_name]['forms_not_in_db'] = round((((count($location_data[$state_name]['villages']) * 9) - $location_data[$state_name]['answer_count']) / (count($location_data[$state_name]['villages']) * 9) * 100), 2);
			}

		}

		return view('home', compact('data_array', 'dataentry', 'gender', 'forms', 'dashboard_form', 'no_answers_percent', 'location_data', 'all_state'));
	}

}
