<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

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
				'interviewee_id' => 'required',
				'answers' => 'required',
				'form_id' => 'required'
			];
		}else{
			$rules = [
				//
				'interviewee_id' => 'required|unique:ems_questions_answers',
				'answers' => 'required',
				'form_id' => 'required'
			];

		}



		return $rules;
	}

}
