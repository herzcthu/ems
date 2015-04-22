<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsQuestionsAnswers;
use App\GeneralSettings;
use App\States;
use Stevebauman\Translation\Facades\Translation;

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

		//return array_count_values(array_column($data_array,'State'))['Ayeyarwady'];


		$forms = EmsForm::paginate(5);
		/*
		$no_answers = array_count_values(array_flatten(array_column($dataentry->toArray(),'answers')));
		$total_answers = array_sum($no_answers);
		if(array_key_exists(0, $no_answers)) {
			$no_answers_percent = ($no_answers[0] / $total_answers) * 100;
		}else{
			$no_answers_percent = 0;
		}
		*/
		$incomplete_form = EmsQuestionsAnswers::where('form_id', $form_id)->where('form_complete', false)->get();
		$no_answers_percent = ( count($incomplete_form) / count($dataentry) ) * 100;

		$all_state = States::lists('state', 'id');
		//dd($all_state);
		foreach($all_state as $state_id => $state_name){

			if($state_name == 'Ayeyarwady'){
				$abbr_state = 'AWD';
			}
			if($state_name == 'Bago (East)'){
				$abbr_state = 'BG(E)';
			}
			if($state_name == 'Bago (West)'){
				$abbr_state = 'BG(W)';
			}
			if($state_name == 'Chin'){
				$abbr_state = 'CHN';
			}
			if($state_name == 'Sagaing'){
				$abbr_state = 'SGG';
			}
			if($state_name == 'Mandalay'){
				$abbr_state = 'MDY';
			}
			if($state_name == 'Yangon'){
				$abbr_state = 'YGN';
			}
			if($state_name == 'Shan (East)'){
				$abbr_state = 'SH(E)';
			}
			if($state_name == 'Shan (South)'){
				$abbr_state = 'SH(S)';
			}
			if($state_name == 'Shan (North)'){
				$abbr_state = 'SH(N)';
			}
			if($state_name == 'Tanintharyi'){
				$abbr_state = 'TNTY';
			}
			if($state_name == 'Mon'){
				$abbr_state = 'MON';
			}
			if($state_name == 'Kachin'){
				$abbr_state = 'KCN';
			}
			if($state_name == 'Kayin'){
				$abbr_state = 'KYN';
			}
			if($state_name == 'Rakhine'){
				$abbr_state = 'RKH';
			}
			if($state_name == 'Naypyitaw'){
				$abbr_state = 'NPW';
			}
			if($state_name == 'Magway'){
				$abbr_state = 'MGW';
			}
			$dataByState = EmsQuestionsAnswers::getAllByState($state_name, $data_array);
			$location_data[$state_name]['answers'] = $dataByState;
			$count = 0;
			for($i=0;$i < count($dataByState); $i++){
				if(in_array('Incomplete',$dataByState[$i])){
					$count++;
				}
			}
			$location_data[$state_name]['incomplete_count'] = $count;
			$location_data[$state_name]['abbr'] = $abbr_state;
			if(array_key_exists($state_name, array_count_values(array_column($data_array,'State')))) {

				$location_data[$state_name]['answer_count'] = array_count_values(array_column($data_array, 'State'))[$state_name];
				$state = States::find($state_id);
				$location_data[$state_name]['townships'] = $state->townships;

				States::where('id' , $state_id)->with(['townships.villages' => function ($q) use (&$villages) {
					$villages = $q->get()->unique();
				}])->get();
				$location_data[$state_name]['villages'] = $villages;

			}else{
				$location_data[$state_name]['answer_count'] = 0;
			}

		}


		//dd($test);
		//$townships = States::townships()->get();
		//dd($townships);
		//dd($all_state);
		//dd($data_array);
		//if(in_array('Complete' , array_values($location_data['Ayeyarwady']['answers'][0])))
		//	dd(array_values($location_data['Ayeyarwady']['answers'][0]));

		//dd($location_data);
		//$ayewaddy = EmsQuestionsAnswers::getAllByState('Bago (West)', $data_array);
		//print $no_answers_percent;
		//print_r($ayewaddy);
		//return;

		return view('home', compact('data_array', 'dataentry', 'forms', 'no_answers_percent', 'location_data', 'all_state'));
	}

}
