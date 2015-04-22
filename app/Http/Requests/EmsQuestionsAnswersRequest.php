<?php namespace App\Http\Requests;

use App\EmsForm;
use App\EmsFormQuestions;
use App\EmsQuestionsAnswers;
use App\Participant;
use App\States;
use App\Villages;
use App\Townships;
use App\Districts;
use App\Http\Requests\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Response;


class EmsQuestionsAnswersRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$this->current_user = Auth::user();

		//die($user_id .''. $current_user_id .''. var_dump($this->current_user->allowed('edit.user',$user )));

		if ( $this->current_user->is('admin') ){
			return true;
		}elseif ($this->current_user->level() > 6 )
		{
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules($interviewee_id = 'NULL')
	{
		$method = Request::method();

		$form_url = $this->route('form');

		$form_name = urldecode($form_url);
		$form = EmsForm::where('name', '=', $form_name)->get();
		$form_id = $form->first()['id'];
		$form_type = $form->first()['type'];

		if($form_type == 'spotchecker') {
			if ('PATCH' == $method) {
				$rules = [
					//
					'enu_form_id' => 'required',
					'answers' => 'required',
					'form_id' => 'required'
				];
			} else {
				$rules = [
					//
					'enu_form_id' => 'required',
					'answers' => 'required',
					'form_id' => 'required'
				];

			}

		}else{
			//die($method);
			if ('PATCH' == $method) {
				$rules = [
					//
					'interviewer_id' => 'required',
					'interviewee_id' => 'required',
					'answers' => 'required',
					'form_id' => 'required'
				];
			} else {
				$rules = [
					//
					'interviewer_id' => 'required',
					'interviewee_id' => 'required|unique:ems_questions_answers',
					'answers' => 'required',
					'form_id' => 'required'
				];

			}
		}



		return $rules;
	}

	// Here we can do more with the validation instance...
	public function dataentryValidation($validator){

		// Use an "after validation hook" (see laravel docs)
		$validator->after(function($validator) {
			$form_url = $this->route('form');

			$form_name = urldecode($form_url);
			$form = EmsForm::where('name', '=', $form_name)->get();
			$form_id = $form->first()['id'];
			$form_type = $form->first()['type'];

			$enu_form_id = $this->input('enu_form_id');



			if ($form_type == 'spotchecker') {
				//dd($form_type);
				if (strlen($this->input('enu_form_id')) != 7) {
					$validator->errors()->add('enu_form_id', 'Enumerator Form ID need to be exactly 7 digits');                //	break;

				} else {
					$enu_form_id = $this->input('enu_form_id');
					//dd($enu_form_id);
					try{
						$enu_form = EmsQuestionsAnswers::where('interviewee_id', '=', $enu_form_id)->get();

					}catch (\Exception $e){
						$validator->errors()->add('enu_form_id', 'Enumerator Form not found!');
					}
					preg_match('/([0-9]{6})[0-9]/', $enu_form_id, $matches);
					$enu_id = $matches[1];
					$participant_id = Participant::where('participant_id', '=', $enu_id)->pluck('id');
					$participant = Participant::find($participant_id);
					foreach($participant->parents as $parent){
						if($parent->participant_type == 'coordinator'){
							$coordinator = $parent;
						}
						if($parent->participant_type == 'spotchecker'){
							$spotchecker = $parent;
						}
					}
					if(!isset($spotchecker)){
						$validator->errors()->add('enu_form_id', 'Spot Checker not found!');
					}

					if(empty($enu_form->toArray()) || null == $enu_form->toArray()){
						//dd($enu_form->toArray());
						$validator->errors()->add('enu_form_id', 'Enumerator Form not found!');
					}

				}
			} else {


			$interviewer_id = $this->input('interviewer_id');


			// Check to see if valid numeric array
			//foreach ($this->input('enu_id') as $item) {
			if (strlen($this->input('interviewer_id')) != 6) {
				$validator->errors()->add('interviewer_id', 'Enumerator ID need to be exactly 6 digits');                //	break;

			} else {

				preg_match('/([1-9][0-9]{2})([0-9]{3})/', $interviewer_id, $matches);

				try {
					$state = States::where('state_id', '=', (int)$matches[1]);
				} catch (\Exception $e) {
					$validator->errors()->add('interviewer_id', 'No state with ID ' . $matches[1] . '. Check again Enumerator ID!');
				}
				try {
					$village_id = Villages::where('village_id', '=', (int)$matches[2])->first()['id'];

					$village = Villages::find($village_id);

					$township = Townships::find($village->township->id);

					$district = Districts::find($township->district->id);

					$state_for_village = States::find($district->state->id);


				} catch (\Exception $e) {
					$validator->errors()->add('interviewer_id', 'No village with ID ' . $matches[2] . '. Check again Enumerator ID!');
				}


				if (isset($state_for_village) && $state_for_village->state_id != (int)$matches[1]) {

					$validator->errors()->add('interviewer_id', $village->village . ' does not exist in ' . $state->first()['state'] . '. Check again Enumerator ID!');
				}


			}
			//}
			//foreach ($this->input('answers') as $answer ){

			//	break;
			//}
			$answers_count = count($this->input('answers'));
			//print($answers_count);
			//print(count(EmsFormQuestions::OfNotMain($this->input('form_id'))->get()));
			//die($answers_count);
			if ($answers_count != count(EmsFormQuestions::OfNotMain($this->input('form_id'))->get())) {
				$validator->errors()->add('answers', 'You need to complete all answers!');
			}

		}

		});
	}

}
