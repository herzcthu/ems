<?php namespace App\Http\Requests;

use App\EmsFormQuestions;
use App\States;
use App\Villages;
use App\Townships;
use App\Districts;
use App\Http\Requests\Request;
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
		}elseif ($this->current_user->level() < 6 )
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
		//die($method);
		if('PATCH' == $method)
		{
			$rules = [
				//
				'interviewer_id' => 'required',
				'interviewee_id' => 'required',
				'answers' => 'required',
				'form_id' => 'required'
			];
		}else{
			$rules = [
				//
				'interviewer_id' => 'required',
				'interviewee_id' => 'required|unique:ems_questions_answers',
				'answers' => 'required',
				'form_id' => 'required'
			];

		}



		return $rules;
	}

	// Here we can do more with the validation instance...
	public function dataentryValidation($validator){

		// Use an "after validation hook" (see laravel docs)
		$validator->after(function($validator)
		{
			$interviewer_id = $this->input('interviewer_id');


			// Check to see if valid numeric array
			//foreach ($this->input('enu_id') as $item) {
				if (strlen($this->input('interviewer_id')) != 6) {
					$validator->errors()->add('interviewer_id', 'Enumerator ID need to be exactly 6 digits');				//	break;

				}else{

					preg_match('/([1-9][0-9]{2})([0-9]{3})/',$interviewer_id, $matches);

					try {
						$state = States::where('state_id', '=', (int)$matches[1]);
					}catch (\Exception $e){
						$validator->errors()->add('interviewer_id', 'No state with ID '.$matches[1].'. Check again Enumerator ID!');
					}
					try {
						$village_id = Villages::where('village_id', '=', (int)$matches[2])->first()['id'];

						$village = Villages::find($village_id);

						$township = Townships::find($village->township->id);

						$district = Districts::find($township->district->id);

						$state_for_village = States::find($district->state->id);


					}catch (\Exception $e){
						$validator->errors()->add('interviewer_id', 'No village with ID '.$matches[2].'. Check again Enumerator ID!');
					}


					if(isset($state_for_village) && $state_for_village->state_id != (int) $matches[1]){

						$validator->errors()->add('interviewer_id', $village->village.' does not exist in '.$state->first()['state'].'. Check again Enumerator ID!');
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
			if( $answers_count != count(EmsFormQuestions::OfNotMain($this->input('form_id'))->get()))
			{
				$validator->errors()->add('answers', 'You need to complete all answers!');
			}

		});
	}

}
