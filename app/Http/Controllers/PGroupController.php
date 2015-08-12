<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class PGroupController extends Controller {

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

		if ($this->auth_user->level() > 6)
		{
			//$participants = Participant::paginate(30);
			$p_groups = PGroups::all();

			//return 'This is Geolocaiton';
			return view('participants.group', compact('p_groups'));
		}
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
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$this->validate($request, ['name' => 'unique:p_groups']);
		$input = $request->all();
		$new_pgroup = PGroups::create($input);

		$message = 'Participant Group '.$new_pgroup->name.' created!';


		\Session::flash('pgroup_success', $message);
		return redirect('participants/group');
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
	public function update($id)
	{
		//
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
		if( 1 == $id)
		{
			$message = 'Default Participant Group cannot be deleted!';
			\Session::flash('pgroup_error', $message);
		}else{
			$pgroup = PGroups::find($id);

			$pgroup->delete();
			$message = 'Participant Group '.$pgroup->name.' deleted!';
			\Session::flash('pgroup_success', $message);
		}



		return redirect('participants/group');
	}

}
