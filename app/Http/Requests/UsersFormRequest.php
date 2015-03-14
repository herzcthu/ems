<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Bican\Roles\Models\Role;
use App\User;
use Auth;

class UsersFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$this->current_user = Auth::user();
		$current_user_id = $this->current_user->id;

		$method = Request::method();
		//die($method);
		if('PATCH' == $method) {

			$url_segments = Request::segments();
			$user_id = $url_segments[1];
			$user = User::find($user_id);
		}else{

		}

		//die($user_id .''. $current_user_id .''. var_dump($this->current_user->allowed('edit.user',$user )));

		if ( $this->current_user->is('admin') ){
			return true;
		}elseif ($this->current_user->allowed('edit.user',$user ) && $current_user_id == $user_id)
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
		//$url_segments = Request::segments();
		//$update_user_id = $url_segments[2];

		$method = Request::method();
		//die($method);
		if('PATCH' == $method){
			$rules = [
				//
				'name' => 'required|min:4',
				'email' => 'exists:users|email',
				'password' => 'exists:users|password',
				'user_gender' => 'required',
				'dob' => 'dateformat:Y-m-d',
				'user_line_phone' => '',
				'user_mobile_phone' => 'required',
				'user_mailing_address' => 'required',
				'user_biography' => '',
			];
		}else {
			$rules = [
				//
				'name' => 'required:min:4',
				'email' => 'required|unique:users|email',
				'password' => 'required',
				'user_gender' => 'required',
				'dob' => 'dateformat:Y-m-d',
				'user_line_phone' => '',
				'user_mobile_phone' => 'required',
				'user_mailing_address' => 'required',
				'user_biography' => '',
			];
		}

		return $rules;
	}
}
