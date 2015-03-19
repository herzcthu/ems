<?php namespace App\Http\Controllers;

use App\Districts;
use App\Http\Requests\ParticipantsFormRequest;
use App\Townships;
use App\User;
use App\Http\Requests;
use App\Participant;
use App\States;
use App\Http\Controllers\Controller;

use App\Villages;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;


use Illuminate\Http\Request;
//use Illuminate\HttpResponse;
//use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

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
			$participants = Participant::paginate(30);

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
		$states = States::lists('state', 'state');
		$districts = Districts::lists('district', 'district');
		$townships = Townships::lists('township', 'township');
		$villages = Villages::lists('village', 'village');
		$coordinators = Participant::where('participant_type', '=', 'coordinator')->lists('name', 'nrc_id');



		return view('participants.create', compact('states', 'districts','townships','villages', 'coordinators'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ParticipantsFormRequest $request
	 * @return Response
	 */
	public function store(ParticipantsFormRequest $request)
	{
		//
		$input = $request->all();
		//die(print_r($input));
		$village = Villages::where('village', '=', $input['location'])->get();
		$state = States::where('state', '=', $input['location'])->get();
		$district = Districts::where('district', '=', $input['location'])->get();
		if($input['parent_id'] == null || $input['participant_type'] == 'coordinator'){
			$input['parent_id'] = null;
		}else{
			//var_dump($input['parent_id']);
			$parent =  Participant::where('nrc_id', '=', $input['parent_id'])->get();

			//var_dump($parent[0]->id);
			$input['parent_id'] = $parent[0]->id;
		}
		$new_participant = Participant::create($input);

		if(array_key_exists(0 ,$village->toArray())){
			$location = $village;
			$new_participant->villages()->attach($location[0]['id']);
		}
		if(array_key_exists(0 ,$state->toArray())){
			$location = $state;
			$new_participant->states()->attach($location[0]['id']);
		}
		if(array_key_exists(0 ,$district->toArray())){
			$location = $district;
			$new_participant->districts()->attach($location[0]['id']);
		}

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
		if ($this->auth_user->level() > 6)
		{		//
			if($id == 'coordinator'){


				$participants = Participant::where('participant_type', '=', 'coordinator')->paginate(30);

				//return $participants;
				//return 'This is Geolocaiton';
				return view('participants.index', compact('participants'));
			}

			if($id == 'enumerator'){


				$participants = Participant::where('participant_type', '=', 'enumerator')->paginate(30);

				//return $participants;
				//return 'This is Geolocaiton';
				return view('participants.index', compact('participants'));
			}
		}
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
		$participant = Participant::find($id);

		$participant->delete();
		$message = 'Participant '.$participant->name.' deleted!';


		\Session::flash('flash_message', $message);

		return redirect('participants');
	}


	public function import(){

		$file = Input::file('file');

		if(!empty($file)) {
			$file = $file->getRealPath();
			$excel = Excel::load($file, 'UTF-8');
			$csv_array = $excel->get()->toArray();
			foreach ($csv_array as $line) {
				$participant['name'] = $line['name'];
				$participant['email'] = $line['email'];
				$participant['dob'] = $line['dob'];
				$participant['ethnicity'] = $line['ethnicity'];
				$participant['user_mobile_phone'] = $line['mobile'];
				$participant['user_line_phone'] = $line['line_phone'];
				$participant['user_biography'] = $line['biography'];
				$participant['user_mailing_address'] = $line['mailing_address'];
				$participant['user_gender'] = $line['gender'];
				$location = $line['region'];

				if(isset($line['type']))
				{
					$participant['participant_type'] = $line['type'];
				}
				else
				{
					$participant['participant_type'] = 'enumerator';
				}


				$participant['current_org'] = $line['current_org'];
				$participant['education_level'] = $line['education_level'];
				$participant['nrc_id'] = $line['nrc_id'];

				$new_participant = Participant::updateOrCreate(array('nrc_id' => $participant['nrc_id']), $participant);
				//$new_participant = Participant::firstOrCreate($participant);
				//$participant = new Participant();
				//$new_participant = $participant;
				//$new_participant->save();

				if($participant['participant_type'] == 'coordinator')
				{
					$state = States::where('state', '=', $line['state'])->get();
					$district = Districts::where('district', '=', $line['region'])->get();
					if(array_key_exists(0 ,$state->toArray())){
						$location = $state;
						$new_participant->states()->attach($location[0]['id']);
					}
					if(array_key_exists(0 ,$district->toArray())){
						$location = $district;
						$new_participant->districts()->attach($location[0]['id']);
					}
				}
				elseif($participant['participant_type'] == 'enumerator')
				{
					$village = Villages::where('village', '=', $line['village'])->get();
					if(array_key_exists(0 ,$village->toArray())){
						$location = $village;
						$new_participant->villages()->attach($location[0]['id']);
					}
				}
				else
				{
					$township = Townships::where('township', '=', $line['township'])->get();
				}




			}
			$message = 'Participant List imported!';
		}else{
			$message = 'No file to import!';
		}

		\Session::flash('participant_import_error', $message);
		return redirect('participants');
	}
}
