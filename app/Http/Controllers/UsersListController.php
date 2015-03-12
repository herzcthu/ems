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


class UsersListController extends Controller {

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

		if ($this->auth_user->is('admin'))
		{
			$users = User::all();
			$roles = Role::all();
			$users_array = $users->toArray();
			$roles_array = $roles->toArray();
			$role_count = count($roles_array);


			foreach($users_array as $k => $v){

				for($i = 1; $i <= $role_count; $i++){
					$role = Role::find($i);
					$role = $role->toArray();
					$role_slug = $role['slug'];
					//var_dump($role['slug']);
					$user = User::find($v['id'])->is($role_slug);
					if(TRUE === $user){
						$users_array[$k]['role'] = $role['name'];
					}
				}
			}
			//var_dump($roles);
			//var_dump(json_decode (json_encode ($users_array), FALSE));
			//var_dump(compact('users'));

			//
			$users = json_decode (json_encode ($users_array), FALSE);
			//var_dump($users);
			//var_dump(compact($users_array));
			//var_dump(compact('users'));
			//var_dump(compact('roles'));
			//die();

			//return view('users.index')->with('users', $users);
			return view('users.index', compact('users'));
			//return view('users.index', compact('users', 'roles'));//->with('users',$users_array);//, compact('users'));
		}else{
			return $this->show($this->current_user_id);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UsersFormRequest $request)
	{
		$input = $request->all();
		$input['password'] = bcrypt($request->get('password'));


		$new_user = User::create($input);
		User::find($new_user->id)->attachRole(4);
		return redirect('users');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id = '')
	{
		if(('' === $id) || (!$this->auth_user->is('admin'))){
			$id = $this->current_user_id;
		}


		// Will return a ModelNotFoundException if no user with that id
		try
		{
			$user = User::findOrFail($id);
		}
			// catch(Exception $e) catch any exception
		catch(ModelNotFoundException $e)
		{
			return view('users.usernotfound');
		}
		return view('users.profile', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id = '')
	{
		if(('' === $id) || (!$this->auth_user->is('admin'))){
			$id = $this->current_user_id;
		}


		// Will return a ModelNotFoundException if no user with that id
		try
		{
			$user = User::findOrFail($id);
		}
			// catch(Exception $e) catch any exception
		catch(ModelNotFoundException $e)
		{
			return view('users.usernotfound');
		}
		return view('users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param UsersFormRequest $request
	 * @return Response
	 */
	public function update($id, UsersFormRequest $request)
	{
//		if(('' === $id) || (!$this->auth_user->is('admin'))){
//			$id = $this->current_user_id;
//		}


		// Will return a ModelNotFoundException if no user with that id
		try
		{
			$user = User::findOrFail($id);
		}
			// catch(Exception $e) catch any exception
		catch(ModelNotFoundException $e)
		{
			return view('users.usernotfound');
		}

		$user_array = $request->all();
		if(!empty($user_array['password'])) {
			$user_array['password'] = bcrypt($request->get('password'));
		}else{
			$user_array['password'] = $user->password;
		}

		$user->update($user_array);

		return redirect('users/'.$id);
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
		$user = User::find($id);

		$user->delete();

		\Session::flash('flash_message', 'User '.$user->name.' Deleted!');

		return redirect('users');
	}

}