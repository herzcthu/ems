<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\States;
use App\Districts;
use App\Townships;
use App\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class GeolocationsController extends Controller {

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
			$locations = Villages::paginate(30);

			//return var_dump($locations[0]->township->toArray());
			//return var_dump($locations[16]->districts[0]->townships[0]->villages->toArray());
			//die();
			//$locations = States::paginate(30);
			//return 'This is Geolocaiton';
			return view('locations.index', compact('locations'));
		}
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$states = States::lists('state', 'id');
		$districts = Districts::lists('district');
		$townships = Townships::lists('township');
		$villagetracks = Villages::lists('villagetrack');
		$villages = Villages::lists('village');

		return view('locations.create', compact('states','districts','townships','villagetracks','villages'));
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

		//return $input['state'];
		$states = States::where('state', '=', $input['state'])->get();

		$state_array = $states->toArray();
		$new_state = States::updateOrCreate($state_array[0]);

		//return $new_state['id'];

		$districts = Districts::where('district', '=', $input['district'])->get();
		//$district_id = $districts[0]['id'];
		$district_array = $districts->toArray();
		$district_array[0]['state_id'] = $new_state['id'];
		$district_array[0]['district'] = $input['district'];
		$new_district = Districts::updateOrCreate($district_array[0]);

		$townships = Townships::where('township', '=', $input['township'])->get();		
		$township_array = $townships->toArray();
		$township_array[0]['district_id'] = $new_district['id'];
		$township_array[0]['township'] = $input['township'];
		$new_township = Townships::updateOrCreate($township_array[0]);

		//return $township_array[0];
		//return $new_township['id'];

		$villagetrack_input = $input['villagetrack'];
		$village_input = $input['village'];

		$villagetracks = Villages::whereRaw("villagetrack = '$villagetrack_input' and village = '$village_input'")->get();
		$villagetrack_array = $villagetracks->toArray();
		$villagetrack_array[0]['township_id'] = $new_township['id'];
		$villagetrack_array[0]['villagetrack'] = $villagetrack_input;
		$villagetrack_array[0]['village'] = $village_input;

		$new_villagetrack = Villages::updateOrCreate($villagetrack_array[0]);

	/**	$villages = Villages::where('village', '=', $input['village'])->get();
		$village_array = $villages->toArray();
		$village_array[0]['townships_id'] = $new_township['id'];
		$village_array[0]['village'] = $input['village'];
		$new_village = Villages::updateOrCreate($village_array[0]);

		return $new_village;
		return $state_id;
		$new_location = States::create($input);
		$new_coordinator->states()->attach($input['state']);**/

		return redirect('locations');
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
		foreach ($csv_array as $line){

			$state['state_id'] = $line['state_id'];
			$state['state'] = $line['state'];
			$new_state = States::updateOrCreate($state);

			//return $new_state;

			$district['states_id'] = $new_state['id'];
			$district['district'] = $line['district'];
			$new_district = Districts::updateOrCreate($district);

			$township['districts_id'] = $new_district['id'];
			$township['township'] = $line['township'];
			$new_township = Townships::updateOrCreate($township);

			$village['townships_id'] = $new_township['id'];
			$village['villagetrack'] = $line['villagetrack'];
			$village['village'] = $line['village'];
			$village['village_my'] = $line['village_my'];
			$village['village_id'] = $line['village_id'];
			$new_village = Villages::updateOrCreate($village);
		}
		\Session::flash('flash_message', 'Location data imported!');
		return redirect('locations');
	}
}
