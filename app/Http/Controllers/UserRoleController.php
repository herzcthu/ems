<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UsersFormRequest;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;


use Illuminate\Http\Request;
//use Illuminate\HttpResponse;
//use Illuminate\Routing\Controller;
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		//
		$req_array = $request->all();

		//var_dump($req_array);

		foreach($req_array as $k => $v){
			if($k == 'user_role'){
				$user_role = $v;
			}elseif($k == '_token'){

			}else{
				$userid[$k] = $v;
			}
		}
		//var_dump($userid);
		foreach($userid as $k => $id){
			//var_dump($id);
			try{

				if($this->auth_user->allowed('edit.role',$this->auth_user )){
					//die('This is true: user allowed to edit roles');
				User::find($id)->detachAllRoles();
				User::find($id)->attachRole($user_role);
				}
				$flash_message = "Role Updated!";
			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$flash_message = "Error Role Assignment!";
			}

		}
		//die();
		//return $request;
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
