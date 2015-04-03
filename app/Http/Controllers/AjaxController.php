<?php namespace App\Http\Controllers;

use App\Districts;
use App\EmsForm;
use App\EmsQuestionsAnswers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\States;
use App\Townships;
use App\User;
use App\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->current_user_id = Auth::id();
		$this->auth_user = User::find($this->current_user_id);
	}

	public function check($form_url){


		$form_name = urldecode($form_url);
		if ($this->auth_user->can("add.data")) {

			$form_name = urldecode($form_url);

			$form = EmsForm::where('name', '=', $form_name)->get();

			$form_id = $form->first()['id'];

		$interviewer_id = Input::get('interviewer_id');
		$interviewee_id = Input::get('interviewee_id');
		if(isset($interviewee_id)){
			$answers_id = $interviewer_id.$interviewee_id;
			$answer = EmsQuestionsAnswers::where('interviewee_id', '=', $answers_id)->pluck('interviewee_id');

			if(!empty($answer)){
				$ajax_response['status'] = false;
				$ajax_response['message'] = '<p class="text-red">Data already exists.</p>';
			}else{
				$ajax_response['status'] = true;
				$ajax_response['message'] = '<p class="text-green">Good to go!</p>';
			}

		} else {
			if (strlen($interviewer_id) != 6) {

				$ajax_response['status'] = false;
				$ajax_response['message'] = '<p class="text-red">Enumerator ID need to be exactly 6 digits</p>';                //	break;

			} else {

				preg_match('/([0-9]{3})([0-9]{3})/', $interviewer_id, $matches);

				if (empty($matches)) {

					$ajax_response['status'] = false;
					$ajax_response['message'] = '<p class="text-red">Wrong Enumerator ID</p>';
				}

				try {
					$state = States::where('state_id', '=', (int)$matches[1]);
				} catch (\Exception $e) {
					$ajax_response['status'] = false;
					$ajax_response['message'] = '<p class="text-red">No state with ID ' . $matches[1] . '. Check again Enumerator ID!</p>';
				}
				try {
					$village_id = Villages::where('village_id', '=', (int)$matches[2])->first()['id'];

					$village = Villages::find($village_id);

					$township = Townships::find($village->township->id);

					$district = Districts::find($township->district->id);

					$state_for_village = States::find($district->state->id);

					$enumerator = $village->enumerator->first()->name;


				} catch (\Exception $e) {
					$ajax_response['status'] = false;
					$ajax_response['message'] = '<p class="text-red">No village with ID ' . $matches[2] . '. Check again Enumerator ID!</p>';
				}


				if (isset($state_for_village) && !empty($state_for_village)) {
					if ($state_for_village->state_id != (int)$matches[1]) {
						$ajax_response['status'] = false;
						$ajax_response['message'] = '<p class="text-red">' . $village->village . ' does not exist in ' . $state->first()['state'] . '. Check again Enumerator ID!</p>';
					} elseif (isset($enumerator)) {
						$ajax_response['status'] = true;
						$ajax_response['message'] = '<p class="text-green">' . $village->village . ' exist in ' . $state->first()['state'] . '. Enumerator name is ' . $enumerator . '!</p>';
					} else {
						$ajax_response['status'] = false;
						$ajax_response['message'] = '<p class="text-red">Enumerator cannot find in database!</p>';
					}
				}


			}
		}

		//echo 'true';



		} else {
			$ajax_response['status'] = false;
			$ajax_response['message'] = 'User has no permission to add data';
		}


		echo json_encode($ajax_response);

	}

}
