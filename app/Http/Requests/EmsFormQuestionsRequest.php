<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class EmsFormQuestionsRequest extends Request {

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
	public function rules()
	{
		$method = Request::method();
		//die($method);
		if('PATCH' == $method)
		{
			$rules = [
				//
				'question' => 'required',
				'input_type' => 'required',
				'form_id' => 'required',
				'answers' => ''
			];
		}else{
			$rules = [
				//
				'question' => 'required',
				'input_type' => 'required',
				'form_id' => 'required',
				'answers' => ''
			];

		}



		return $rules;
	}

}
