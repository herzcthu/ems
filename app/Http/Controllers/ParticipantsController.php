<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Participants;
use App\States;
use App\Http\Controllers\Controller;

use App\Http\Requests\UsersFormRequest;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;


use Illuminate\Http\Request;
//use Illuminate\HttpResponse;
//use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ParticipantsController extends Controller {

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

		if ($this->auth_user->level() > 6)
		{
			$participants = Participants::paginate(30);

			//return 'This is Geolocaiton';
			return view('participants.index', compact('participants'));
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
		$states = States::lists('state', 'id');

		return view('participants.create', compact('states'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$input = $request->all();
		$new_participant = Participants::create($input);
		$new_participant->states()->attach($input['state']);

		return redirect('participants');
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
	}


	public function import(){

		$file = Input::file('file')->getRealPath();
		$excel = Excel::load($file, 'UTF-8');
		$csv_array = $excel->get()->toArray();
		foreach ($csv_array as $line)
		{
			$participant['name'] = $line['name'];
			$participant['email'] = $line['email'];
			$participant['dob'] = $line['dob'];
			$participant['user_gender'] = $line['gender'];
			$participant['district'] = $line['region'];
			$participant['address'] = $line['address'];

		}
		\Session::flash('flash_message', 'participant List imported!');
		return redirect('locations');
	}
}
