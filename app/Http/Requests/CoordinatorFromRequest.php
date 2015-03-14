<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Bican\Roles\Models\Role;
use App\User;
use Auth;

class CoordinatorFromRequest extends Request {

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
	public function rules()
	{
		//$url_segments = Request::segments();
		//$update_user_id = $url_segments[2];
		/** 'name' => 'Sithu Thwin',
		 * 'email' => 'sithu@thwin.net',
		 * 'nrc_id' => '5/SaKaNa(N)156828',
		 * 'ethnicity' => '',
		 * 'state' => '101',
		 * 'user_gender' => 'male',
		 * 'dob' => '2015-03-13',
		 * 'user_line_phone' => '',
		 * 'user_mobile_phone' => '09797969695',
		 * 'user_mailing_address' => '',
		 * 'education_level' => 'none',
		 * 'user_biography' =>

		 **/

		$method = Request::method();
		//die($method);
		if('PATCH' == $method){
			$rules = [
				//
				'name' => 'required|min:4',
				'email' => 'exists:coordinators|email',
				'nrc_id' => 'exists:coordinators|nrc_id',
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
				'email' => 'required|unique:cordinators|email',
				'nrc_id' => 'required|unique:coordinators',
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
