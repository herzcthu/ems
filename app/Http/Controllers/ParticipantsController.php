<?php namespace App\Http\Controllers;

use App\Districts;

use App\Http\Requests;
use App\Http\Requests\ParticipantsFormRequest;
use App\PGroups;
use App\Townships;
use App\User;

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
			//$participants = Participant::paginate(30);
			$participants = Participant::all();
			$p_group = PGroups::lists('name', 'id');

			//return 'This is Geolocaiton';
			return view('participants.index', compact('participants', 'p_group'));
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
		$participant['name'] = $input['name'];
		$participant['email'] = $input['email'];
		$participant['nrc_id'] = $input['nrc_id'];
		$participant['ethnicity'] = $input['ethnicity'];
		$participant['participant_type'] = $input['participant_type'];
		//$participant['location'] = $input['location'];
		$participant['user_gender'] = $input['user_gender'];
		$participant['user_mobile_phone'] = $input['user_mobile_phone'];
		$participant['user_line_phone'] = $input['user_line_phone'];
		$participant['current_org'] = $input['current_org'];
		$participant['user_mailing_address'] = $input['user_mailing_address'];
		$participant['education_level'] = $input['education_level'];
		$village = Villages::where('village', '=', $input['location'])->get();
		$state = States::where('state', '=', $input['location'])->get();
		$district = Districts::where('district', '=', $input['location'])->get();
		if($input['parent_id'] == null || $input['participant_type'] == 'coordinator'){
			$participant['parent_id'] = null;
		}else{

			$participant['parent_id'] = $input['parent_id'];
		}
		$participant['dob'] = $input['dob'];

		//return $participant['nrc_id'];
		$new_participant = Participant::firstOrNew($participant);
		//$new_participant->nrc_id = $participant['nrc_id'];
		//return $new_participant->nrc_id;
		//$new_participant = Participant::create($participant);
		$new_participant->save();
		//return $new_participant->id;

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
			$p_group = PGroups::lists('name', 'id');
			if($id == 'coordinator'){


				$participants = Participant::where('participant_type', '=', 'coordinator')->paginate(30);

				$viewport = 'participants.index';

				//return $participants;
				//return 'This is Geolocaiton';

			}elseif($id == 'enumerator'){


				$participants = Participant::where('participant_type', '=', 'enumerator')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			}elseif($id == 'spotchecker'){


				$participants = Participant::where('participant_type', '=', 'spotchecker')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			}else{
				$participants = Participant::find($id);
				$viewport = 'participants.profile';
			}

			return view($viewport, compact('participants', 'p_group'));
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
		if ($this->auth_user->level() > 6)
		{		//
			$p_group = PGroups::lists('name', 'id');
			if($id == 'coordinator'){


				$participants = Participant::where('participant_type', '=', 'coordinator')->paginate(30);

				$viewport = 'participants.index';

				//return $participants;
				//return 'This is Geolocaiton';

			}elseif($id == 'enumerator'){


				$participants = Participant::where('participant_type', '=', 'enumerator')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			}elseif($id == 'spotchecker'){


				$participants = Participant::where('participant_type', '=', 'spotchecker')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			}else{
				$participant = Participant::find($id);
				$viewport = 'participants.edit';
			}
			$states = States::lists('state', 'state');
			$districts = Districts::lists('district', 'district');
			$townships = Townships::lists('township', 'township');
			$villages = Villages::lists('village', 'village');
			$coordinators = Participant::where('participant_type', '=', 'coordinator')->lists('name', 'nrc_id');



			return view($viewport, compact('participant','p_group','states', 'districts','townships','villages', 'coordinators'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ParticipantsFormRequest $request)
	{
					//
					$participant = Participant::findOrFail($id);
					$input = $request->all();
					//die(print_r($input));
					//$old_participant = Participant::find($id);
					$participant->name = $input['name'];
					$participant->email = $participant['email'];
					$participant->nrc_id = $input['nrc_id'];
					$participant->ethnicity = $input['ethnicity'];
					$participant->participant_type = $input['participant_type'];
					//$participant['location'] = $input['location'];
					$participant->user_gender = $input['user_gender'];
					$participant->user_mobile_phone = $input['user_mobile_phone'];
					$participant->user_line_phone = $input['user_line_phone'];
					$participant->current_org = $input['current_org'];
					$participant->user_mailing_address = $input['user_mailing_address'];
					$participant->education_level = $input['education_level'];
					$village = Villages::where('village', '=', $input['location'])->get();
					$state = States::where('state', '=', $input['location'])->get();
					$district = Districts::where('district', '=', $input['location'])->get();
					if($input['parent_id'] == null || $input['participant_type'] == 'coordinator'){
						$participant->parent_id = null;
					}else{
					$participant->parent_id = $input['parent_id'];
					}
			$participant->dob = $input['dob'];

			//return $participant['nrc_id'];
			//$new_participant = Participant::findOrNew($participant);
			//$new_participant->nrc_id = $participant['nrc_id'];
			//return $new_participant->nrc_id;
			//$new_participant = Participant::create($participant);
			$participant->push();
			//return $participant->id;

			if(array_key_exists(0 ,$village->toArray())){
				$location = $village;
				$participant->villages()->attach($location[0]['id']);
			}
			if(array_key_exists(0 ,$state->toArray())){
				$location = $state;
				$participant->states()->attach($location[0]['id']);
			}
			if(array_key_exists(0 ,$district->toArray())){
				$location = $district;
				$participant->districts()->attach($location[0]['id']);
			}

			return redirect('participants');
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


		\Session::flash('participant_deleted', $message);

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
				$participant['nrc_id'] = $line['nrc_id'];
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

				//$pattern = '/(\d+){1,2}\/(\w\w)(\w\w)(\w\w)\((\w)(\w+)?\)(\d+)/i';
				// $nrc_id =  preg_replace_callback($pattern, function($matches){
				//	return $matches[1]."/".ucwords($matches[2]).ucwords($matches[3]).ucwords($matches[4])."(".ucwords($matches[5]).")".$matches[7];
				//}, $line['nrc_id']);
				//$participant['nrc_id'] = $nrc_id;
				//return $participant['nrc_id'];
				$new_participant = Participant::updateOrCreate(array('nrc_id' => $participant['nrc_id']), $participant);
				//$new_participant = Participant::firstOrCreate($participant);
				//$participant = new Participant();
				//$new_participant = Participant::firstOrNew($participant);
				//return $new_participant->nrc_id;

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
					$coordinator = Participant::where('name', '=', $line['coordinator']);

					$coordinator = Participant::find($coordinator->first()->id);

					$new_participant->get_parent()->associate($coordinator);
				}
				else
				{
					$township = Townships::where('township', '=', $line['township'])->get();
				}

				$pgroup = PGroups::all();
				$new_participant->pgroups()->attach($pgroup->first()->id);


			}
			$message = 'Participant List imported!';
		}else{
			$message = 'No file to import!';
		}

		\Session::flash('participant_import_error', $message);
		return redirect('participants');
	}

	public function setgroup(Request $request)
	{
		$input = $request->all();
		//return $input;

		$participant_id = $input['participant_id'];
		$p_group = $input['p_groups'];
		foreach($participant_id as $id)
		{
			$participant = Participant::find($id);
			if(isset($input['change_group']))
			{
				$participant->pgroups()->attach($p_group);
				$message = 'Participants added to '.PGroups::find($p_group)->name.' group!';
			}
			if(isset($input['delete']))
			{
				$participant->delete();
				$message = 'Participants deleted!';
			}

		}




		\Session::flash('participant_success', $message);

		return redirect('participants');
	}
}
