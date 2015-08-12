<?php namespace App\Http\Controllers;

use App\Districts;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParticipantsFormRequest;
use App\Participant;
use App\PGroups;
use App\States;
use App\Townships;
use App\User;
use App\Villages;
use Illuminate\Database\QueryException;
//use Illuminate\HttpResponse;
//use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Exception\ErrorException;

class ParticipantsController extends Controller {

	public function __construct() {
		$this->middleware('auth');
		$this->current_user_id = Auth::id();
		$this->auth_user = User::find($this->current_user_id);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		if ($this->auth_user->level() > 6) {
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
	public function create() {
		//
		$states = States::lists('state', 'state');
		$districts = Districts::lists('district', 'district');
		$townships = Townships::lists('township', 'township');
		$villages = Villages::lists('village', 'village');
		$coordinators = Participant::where('participant_type', '=', 'coordinator')->lists('name', 'nrc_id');

		return view('participants.create', compact('states', 'districts', 'townships', 'villages', 'coordinators'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ParticipantsFormRequest $request
	 * @return Response
	 */
	public function store(ParticipantsFormRequest $request) {
		//
		$input = $request->all();
		//die(print_r($input));
		if ($this->auth_user->level() > 6) {
			$this->CreatAndStore($input);
		}

		return redirect('participants');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		if ($this->auth_user->level() > 6) {
			//
			$p_group = PGroups::lists('name', 'id');
			if ($id == 'coordinator') {

				$participants = Participant::where('participant_type', '=', 'coordinator')->paginate(30);

				$viewport = 'participants.index';

				//return $participants;
				//return 'This is Geolocaiton';

			} elseif ($id == 'enumerator') {

				$participants = Participant::where('participant_type', '=', 'enumerator')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			} elseif ($id == 'spotchecker') {

				$participants = Participant::where('participant_type', '=', 'spotchecker')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			} else {
				$participants = Participant::find($id);
				if ($participants->participant_type == 'coordinator') {
					$location = isset($participants->states->first()['state']) ? $participants->states->first()['state'] : $participants->districts->first()['district'];
					//$locations = array('Dtates' => $states, 'Districts' => $districts);
				} else {

					$location = $participants->villages->first()['village'];
					//$locations = array('Villages' => $villages);
				}
				$viewport = 'participants.profile';
			}

			return view($viewport, compact('participants', 'p_group', 'location'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		if ($this->auth_user->level() > 6) {
			//
			$p_group = PGroups::lists('name', 'id');

			$states = States::lists('state', 'state');
			$districts = Districts::lists('district', 'district');
			$townships = Townships::lists('township', 'township');
			$villages = Villages::lists('village', 'village');
			$coordinators = Participant::where('participant_type', '=', 'coordinator')->lists('name', 'nrc_id');

			if ($id == 'coordinator') {

				$participants = Participant::where('participant_type', '=', 'coordinator')->paginate(30);

				$viewport = 'participants.index';

				//return $participants;
				//return 'This is Geolocaiton';

			} elseif ($id == 'enumerator') {

				$participants = Participant::where('participant_type', '=', 'enumerator')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			} elseif ($id == 'spotchecker') {

				$participants = Participant::where('participant_type', '=', 'spotchecker')->paginate(30);
				$viewport = 'participants.index';
				//return $participants;
				//return 'This is Geolocaiton';

			} else {
				$participant = Participant::find($id);
				if ($participant->participant_type == 'coordinator') {
					$location = isset($participant->states->first()['state']) ? $participant->states->first()['state'] : $participant->districts->first()['district'];
					$locations = array('Dtates' => $states, 'Districts' => $districts);
				} else {

					$location = $participant->villages->first()['village'];
					$locations = array('Villages' => $villages);
				}
				$viewport = 'participants.edit';
			}

			return view($viewport, compact('participant', 'p_group', 'locations', 'location', 'states', 'districts', 'townships', 'villages', 'coordinators'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ParticipantsFormRequest $request) {
		//
		$participant = Participant::findOrFail($id);
		$input = $request->all();
		$this->CreatAndStore($input);

		return redirect('participants');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$participant = Participant::find($id);

		$participant->delete();
		$message = 'Participant ' . $participant->name . ' deleted!';

		\Session::flash('participant_deleted', $message);

		return redirect('participants');
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function import() {

		$file = Input::file('file');

		if (!empty($file)) {
			$file = $file->getRealPath();
			$excel = Excel::load($file, 'UTF-8');
			$csv_array = $excel->get()->toArray();
			foreach ($csv_array as $line) {
				$this->CreatAndStore($line);
			}
			$message = 'Participant List imported!';
		} else {
			$message = 'No file to import!';
		}

		\Session::flash('participant_import_error', $message);
		return redirect('participants');
	}

	public function setgroup(Request $request) {
		$input = $request->all();
		//return $input;

		$participant_id = $input['participant_id'];
		$p_group = $input['p_groups'];
		foreach ($participant_id as $id) {
			$participant = Participant::find($id);
			if (isset($input['change_group'])) {
				$participant->pgroups()->attach($p_group);
				$message = 'Participants added to ' . PGroups::find($p_group)->name . ' group!';
			}
			if (isset($input['delete'])) {
				$participant->delete();
				$message = 'Participants deleted!';
			}

		}

		\Session::flash('participant_success', $message);

		return redirect('participants');
	}

	private function CreatAndStore($input) {
		//dd($input);

		$participant['name'] = $input['name'];

		if (isset($input['email'])) {
			$participant['email'] = $input['email'];
		} else {
			$participant['email'] = '';
		}

		$participant['nrc_id'] = $input['nrc_id'];
		$participant['ethnicity'] = $input['ethnicity'];
		$participant['dob'] = $input['dob'];
		if (isset($input['participant_type'])) {
			$participant['participant_type'] = $input['participant_type'];
		} elseif (isset($input['type'])) {
			$participant['participant_type'] = $input['type'];
		} else {
			$participant['participant_type'] = 'enumerator';
		}
		//$participant['location'] = $input['location'];
		if (isset($input['user_gender'])) {
			$participant['user_gender'] = $input['user_gender'];
		} elseif (isset($input['gender'])) {
			$participant['user_gender'] = $input['gender'];
		} else {
			$participant['user_gender'] = '';
		}
		if (isset($input['user_biography'])) {
			$participant['user_biography'] = $input['user_biography'];
		} else {
			$participant['user_biography'] = '';
		}
		if (isset($input['user_mobile_phone'])) {
			$participant['user_mobile_phone'] = $input['user_mobile_phone'];
		} elseif (isset($input['mobile'])) {
			$participant['user_mobile_phone'] = $input['mobile'];
		} else {
			$participant['user_mobile_phone'] = '';
		}
		if (isset($input['user_line_phone'])) {
			$participant['user_line_phone'] = $input['user_line_phone'];
		} elseif (isset($input['line_phone'])) {
			$participant['user_line_phone'] = $input['line_phone'];
		} else {
			$participant['user_line_phone'] = '';
		}
		if (isset($input['current_org'])) {
			$participant['current_org'] = $input['current_org'];
		}
		if (null == $input['current_org'] || empty($input['current_org']) || $input['current_org'] == '') {
			$participant['current_org'] = 'No Organization';
		}
		if (isset($input['user_mailing_address'])) {
			$participant['user_mailing_address'] = $input['user_mailing_address'];
		} elseif (isset($input['mailing_address'])) {
			$participant['user_mailing_address'] = $input['mailing_address'];
		} else {
			$participant['user_mailing_address'] = '';
		}
		if (isset($input['education_level'])) {
			$participant['education_level'] = $input['education_level'];
		}
		if (isset($input['payment_type'])) {
			$participant['payment_type'] = $input['payment_type'];
		}
		if (isset($input['bank'])) {
			$participant['bank'] = $input['bank'];
		}

		//dd((int)$input['location_id']);

		if (isset($input['location_id'])) {

			//die('this is true');
			$location_id = (int) $input['location_id'];
			//dd($location_id);
			preg_match('/([1-9][0-9]{2})([0-9]{3})/', $location_id, $matches);

			$state_id = $matches[1];
			$village_id = $matches[2];

		} else {

			if (isset($input['location'])) {
				try {
					$village_id = Villages::where('village', '=', $input['location'])->pluck('village_id');
				} catch (QueryException $e) {

				}
				try {
					$township_id = Townships::where('township', '=', $input['location'])->pluck('id');
				} catch (QueryException $e) {

				}
				try {
					$state_id = States::where('state', '=', $input['location'])->pluck('state_id');
				} catch (QueryException $e) {

				}
				try {
					$district_id = Districts::where('district', '=', $input['location'])->pluck('id');
				} catch (QueryException $e) {

				}
			}

			if (isset($input['village'])) {
				try {
					$village_id = Villages::where('village', '=', $input['village'])->pluck('village_id');
				} catch (QueryException $e) {

				}
			}

			if (isset($input['state'])) {
				try {
					$state_id = States::where('state', '=', $input['state'])->pluck('state_id');
				} catch (QueryException $e) {

				}
			}

			if (isset($input['district'])) {
				try {
					$district_id = Districts::where('district', '=', $input['district'])->pluck('id');
				} catch (QueryException $e) {

				}
			}

			if (isset($input['region'])) {
				try {
					$district_id = Districts::where('district', '=', $input['region'])->pluck('id');
				} catch (QueryException $e) {

				}
			}
			if (isset($input['township'])) {
				try {
					$township_id = Townships::where('township', '=', $input['township'])->pluck('id');
				} catch (QueryException $e) {

				}
			}

		}
		$parent_id = array();
		$nrc_id = $participant['nrc_id'];
		$nrc_id = preg_replace('/\s+/', '', $nrc_id);

		$nrc_id = strtolower($nrc_id);

		$pattern = '/(\d+){1,2}\/(\w+a|ah)(\w+a|ah)(\w+a|ah)\((\w)(\w+)?\)(\d+)/i';
		$nrc_id_format = preg_replace_callback($pattern, function ($matches) {
			return $matches[1] . "/" . ucwords($matches[2]) . ucwords($matches[3]) . ucwords($matches[4]) . "(" . ucwords($matches[5]) . ")" . $matches[7];
		}, $nrc_id);

		$last = Participant::firstOrNew(['name' => $participant['name'], 'nrc_id' => $nrc_id_format, 'participant_type' => 'coordinator']);
		//dd($last);
		if ($participant['participant_type'] == 'coordinator') {
			if ($last->id) {
				$current_inserting_participant_id = $last->participant_id;
			} else {
				$current_inserting_participant_id = count(Participant::where('participant_type', '=', 'coordinator')->get()) + 1;
			}
			//dd($current_inserting_participant_id);

			$new_pid = sprintf('%04d', $current_inserting_participant_id);

			$participant['participant_id'] = $new_pid;

		} elseif ($participant['participant_type'] == 'spotchecker') {
			if (isset($input['state_id'])) {

				$state_id_for_spotchecker = $input['state_id'];
				$state_id = States::where('state_id', '=', $input['state_id'])->pluck('id');
			} elseif (isset($township_id) && (!empty($township_id) || null != $township_id)) {

				$get_locations = Townships::getLocations($township_id);
				$state_id = $get_locations['state']['id'];

				$state_id_for_spotchecker = $get_locations['state']['state_id'];

			} else {
				$state_id_for_spotchecker = rand(500, 999);
			}
			if (isset($input['spotchecker_id'])) {
				$participant['participant_id'] = $input['spotchecker_id'];
			} else {
				$participant['participant_id'] = $township_id . $state_id_for_spotchecker;
			}

			$coordinator = States::find($state_id);

			//return $coordinator->coordinators;
			if (null != $coordinator->coordinators->first() || !empty($coordinator->coordinators->first()) || $coordinator->coordinators->first() != '') {
				try {
					$parent_id[] = $coordinator->coordinators->first()->pivot->coordinators_id;
				} catch (ErrorException $e) {

				}
			} else {
				$parent_id[] = null;
			}

		} else {
			//$village_id = Villages::where('village', '=', $input['village'])->pluck('village_id');
			//$participant['parent_id'] = $line['parent_id'];

			//var_dump($village_id);
			if (isset($village_id) && (!empty($village_id) || null != $village_id)) {

				$get_locations = Villages::getLocations($village_id);

				$state_id = $get_locations['state']['id'];

				$township_id = $get_locations['township']['id'];

				$state_id_for_enu = $get_locations['state']['state_id'];

				$spotchecker_tsp = Townships::find($township_id);

				$coordinator = States::find($state_id);

				//return $coordinator->coordinators;
				$parent_id = array();
				if (null != $coordinator->coordinators->first() || !empty($coordinator->coordinators->first()) || $coordinator->coordinators->first() != '') {
					try {
						//print($coordinator->coordinators->first()->id);
						$parent_id[0] = $coordinator->coordinators->first()->id;
					} catch (ErrorException $e) {

					}
				}

				if (isset($input['spotchecker_id'])) {
					$parent_id[1] = Participant::where('participant_id', $input['spotchecker_id'])->pluck('id');
				} elseif (null != $spotchecker_tsp->spotcheckers->first() || !empty($spotchecker_tsp->spotcheckers->first()) || $spotchecker_tsp->spotcheckers->first() != '') {
					//print($spotchecker_tsp->spotcheckers->first()->id);
					try {
						$parent_id[1] = $spotchecker_tsp->spotcheckers->first()->id;
					} catch (ErrorException $e) {

					}
					//dd($parent_id);
				}

				$participant['participant_id'] = (int) $state_id_for_enu . sprintf('%03d', $village_id);
			} else {
				return;
			}

		}
		//dd($participant);
		if (null == $participant['name'] || empty($participant['name']) || $participant['name'] == '') {
			$participant['name'] = (string) $participant['participant_id'];
		}

		if ((!empty($participant['name']) || $participant['name'] != '') && (null == $participant['email'] || empty($participant['email']) || $participant['email'] == '')) {
			$participant['email'] = snake_case($participant['name'] . $participant['participant_id']) . '@' . substr(strstr(url(), '.'), 1);
		}

		$participant['participant_id'] = (int) $participant['participant_id'];

		//dd($participant);
		try {
			$new_participant = Participant::updateOrCreate(['participant_id' => $participant['participant_id']], $participant);
		} catch (QueryException $e) {
			//dd($participant);
		}
		//try {

		//	$new_participant = Participant::find($new_participant->id);
		//}catch (QueryException $e){
		//	$update_error = true;
		//}

		if (isset($new_participant) && (!empty($new_participant) || null != $new_participant || $new_participant != '')) {

			$new_participant->parents()->sync($parent_id, false);
			//dd($parent_id);
			if ($participant['participant_type'] == 'coordinator') {
				//return var_dump($new_participant->states());
				if (isset($state_id)) {
					//return var_dump($state_id);
					try {
						$p_id = Participant::find($new_participant->id);

					} catch (QueryException $e) {

					}
//				var_dump($p_id->states->toArray());
					//dd($p_id->states());

					if (!empty($p_id->states->toArray())) {
//					dd($p_id->states);
						$previous_state_id = $p_id->states->first()->id;
					}
					//dd($state_id);
					//dd($previous_state_id);

					$realstateid = States::where('state_id', '=', $state_id)->pluck('id');

					if (isset($previous_state_id)) {

						//dd($realstateid);
						$new_participant->states()->sync([$realstateid, $previous_state_id], false);

					} else {
						//dd($previous_state_id);
						$new_participant->states()->sync([$realstateid]);
					}

				}
				if (isset($district_id)) {

					$new_participant->districts()->sync([$district_id]);
				}
			} elseif ($participant['participant_type'] == 'spotchecker') {
				//$township = Townships::where('township', '=', $input['township'])->get();
				if (isset($input['enumerator_id'])) {

					$enumerators = explode(',', $input['enumerator_id']);
					$townships = array();
					foreach ($enumerators as $enumerator_id) {

						preg_match('/[0-9]{3}([0-9]{3})/', $enumerator_id, $matches);

						$village_id = (int) $matches[1];
						$townships[] = Villages::where('village_id', '=', $village_id)->pluck('townships_id');
					}

				} else {
					$townships = array($township_id);
				}
				try {
					$new_participant->townships()->sync($townships, false);
				} catch (QueryException $e) {

				}
			} elseif ($participant['participant_type'] == 'enumerator') {

				if (isset($village_id)) {

					try {

						$realvillageid = Villages::where('village_id', '=', $village_id)->pluck('id');
						$new_participant->villages()->sync([$realvillageid], false);
					} catch (QueryException $e) {

					}
				}

				if (isset($input['spotchecker_id']) && '' != $input['spotchecker_id']) {
					try {
						$spotchecker_id = Participant::where('participant_id', '=', $input['spotchecker_id'])->pluck('id');
						$spotchecker = Participant::find($spotchecker_id);
						//dd($new_participant->villages);
						$township_id = $new_participant->villages->first()->townships_id;

						$spotchecker->townships()->sync([$township_id]);
					} catch (QueryException $e) {

					}
				}
			} else {
				return;
			}

			$pgroup = PGroups::all();

			$new_participant->pgroups()->sync([$pgroup->first()->id]);

		}
	}
}
