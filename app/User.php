<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Bican\Roles\Contracts\HasRoleContract;
use Bican\Roles\Contracts\HasPermissionContract;
use Bican\Roles\Traits\HasRole;
use Bican\Roles\Traits\HasPermission;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRoleContract, HasPermissionContract {

	use Authenticatable, CanResetPassword, HasRole, HasPermission;

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
	protected $fillable = ['name', 'user_image', 'email', 'password', 'user_gender', 'dob', 'user_line_phone', 'user_mobile_phone', 'user_mailing_address', 'user_biography'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	public function allRoles()
	{
		$roles = HasRole::all();
		die($roles);
	}


}
