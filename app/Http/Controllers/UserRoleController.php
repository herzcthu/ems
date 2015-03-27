<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Bican\Roles\Models\Role;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRoleController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
		$this->current_user_id = Auth::id();
		$this->auth_user = User::find($this->current_user_id);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 * @internal param int $id
	 */
	public function update(Request $request)
	{
		//
		$input = $request->all();
		//return $input;
		$user_role = $input['user_role'];
		$userid = $input['userid'];
		//var_dump($userid);
		foreach($userid as $k => $id){
			//var_dump($id);
			try{

				if($this->auth_user->allowed('edit.role',$this->auth_user )){
					//die('This is true: user allowed to edit roles');
					$roles = Role::find('1');

					if (count($roles->users->toArray()) == 1 && $roles->users[0]->id == $id) {
						$error_message = "Error Role Assignment to Admin!";
					}else {
						User::find($id)->detachAllRoles();
						User::find($id)->attachRole($user_role);
						$flash_message = "Role Updated!";
					}
				}else{
					$error_message = "User not allowed to edit roles!";
				}

			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$error_message = "Error Role Assignment!";
			}

		}
		//die();
		//return $request;
		if(isset($error_message))
		\Session::flash('error_message', $error_message);
		if(isset($flash_message))
		\Session::flash('flash_message', $flash_message);
		return redirect('users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
