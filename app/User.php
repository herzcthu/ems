<?php namespace App;

use Bican\Roles\Contracts\HasRoleAndPermissionContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRoleAndPermissionContract {

	use Authenticatable, CanResetPassword, HasRoleAndPermission;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'user_gender', 'dob'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function enu_answers() {
		return $this->hasMany('App\EmsQuestionsAnswers', 'user_id');
	}

	public function spot_answers() {
		return $this->hasMany('App\SpotCheckerAnswers', 'user_id');
	}

	protected function setDobAttribute($date) {
		$this->attributes['dob'] = date('Y-m-d', strtotime($date));
	}

	protected function getDobAttribute($date) {
		// return $value;
		return date('d-m-Y', strtotime($date));
	}

}
