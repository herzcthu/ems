<?php namespace App\Http\Controllers;

use App\Districts;

use App\Http\Requests;
use App\Http\Requests\ParticipantsFormRequest;
use App\PGroups;
use App\User;

use App\States;
use App\Villages;
use App\Townships;
use App\Participant;
use App\Http\Controllers\Controller;


use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;


use Illuminate\Database\QueryException;
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
		$this->CreatAndStore($input);

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
				if($participants->participant_type == 'coordinator')
				{
					$location = isset($participants->states->first()['state']) ? $participants->states->first()['state']: $participants->districts->first()['district'];
					//$locations = array('Dtates' => $states, 'Districts' => $districts);
				}else{

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
	public function edit($id)
	{
		if ($this->auth_user->level() > 6)
		{		//
			$p_group = PGroups::lists('name', 'id');

			$states = States::lists('state', 'state');
			$districts = Districts::lists('district', 'district');
			$townships = Townships::lists('township', 'township');
			$villages = Villages::lists('village', 'village');
			$coordinators = Participant::where('participant_type', '=', 'coordinator')->lists('name', 'nrc_id');

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
				if($participant->participant_type == 'coordinator')
				{
					$location = isset($participant->states->first()['state']) ? $participant->states->first()['state']: $participant->districts->first()['district'];
					$locations = array('Dtates' => $states, 'Districts' => $districts);
				}else{

					$location = $participant->villages->first()['village'];
					$locations = array('Villages' => $villages);
				}
				$viewport = 'participants.edit';
			}




			return view($viewport, compact('participant','p_group','locations', 'location', 'states', 'districts','townships','villages', 'coordinators'));
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
					$this->CreatAndStore($input);

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


	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function import(){

		$file = Input::file('file');

		if(!empty($file)) {
			$file = $file->getRealPath();
			$excel = Excel::load($file, 'UTF-8');
			$csv_array = $excel->get()->toArray();
			foreach ($csv_array as $line) {
				$this->CreatAndStore($line);
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

	private function CreatAndStore($input)
	{

		$participant['name'] = $input['name'];

		if(isset($input['email'])){
			$participant['email'] = $input['email'];
		}
		if(null == $input['email'] || empty($input['email']) || $input['email'] == ''){
			$participant['email'] = snake_case($input['name']).'@'.substr(strstr(url(),'.'), 1);
		}
		$participant['nrc_id'] = $input['nrc_id'];
		$participant['ethnicity'] = $input['ethnicity'];
		$participant['dob'] = $input['dob'];
		if(isset($input['participant_type'])) {
			$participant['participant_type'] = $input['participant_type'];
		}elseif(isset($input['type'])) {
			$participant['participant_type'] = $input['type'];
		}else{
			$participant['participant_type'] = 'enumerator';
		}
		//$participant['location'] = $input['location'];
		if(isset($input['user_gender'])) {
			$participant['user_gender'] = $input['user_gender'];
		}elseif(isset($input['gender'])) {
			$participant['user_gender'] = $input['gender'];
		}else{
			$participant['user_gender'] = '';
		}
		if(isset($input['user_biography'])) {
			$participant['user_biography'] = $input['user_biography'];
		}else{
			$participant['user_biography'] = '';
		}
		if(isset($input['user_mobile_phone'])) {
			$participant['user_mobile_phone'] = $input['user_mobile_phone'];
		}elseif(isset($input['mobile'])) {
			$participant['user_mobile_phone'] = $input['mobile'];
		}else{
			$participant['user_mobile_phone'] = '';
		}
		if(isset($input['user_line_phone'])) {
			$participant['user_line_phone'] = $input['user_line_phone'];
		}elseif(isset($input['line_phone'])) {
			$participant['user_line_phone'] = $input['line_phone'];
		}else{
			$participant['user_line_phone'] = '';
		}
		if(isset($input['current_org'])) {
			$participant['current_org'] = $input['current_org'];
		}
		if(null == $input['current_org'] || empty($input['current_org']) || $input['current_org'] == ''){
			$participant['current_org'] = 'No Organization';
		}
		if(isset($input['user_mailing_address'])) {
			$participant['user_mailing_address'] = $input['user_mailing_address'];
		}elseif(isset($input['mailing_address'])){
			$participant['user_mailing_address'] = $input['mailing_address'];
		}else{
			$participant['user_mailing_address'] = '';
		}
		if(isset($input['education_level'])) {
			$participant['education_level'] = $input['education_level'];
		}
		if(isset($input['payment_type'])) {
			$participant['payment_type'] = $input['payment_type'];
		}
		if(isset($input['bank'])) {
			$participant['bank'] = $input['bank'];
		}

		if(isset($input['location_id'])){
			$location_id = $input['location_id'];
			preg_match('/([1-9][0-9]{2})([0-9]{3})/', $location_id, $matches);

				$state_id = $matches[1];
				$village_id = $matches[2];

		}else {


			if (isset($input['location'])) {
				try {
					$village_id = Villages::where('village', '=', $input['location'])->pluck('village_id');
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

		}
		$last = Participant::all();


		$current_inserting_participant_id = $last->last()['id'] + 1;
		$new_pid =  sprintf('%04d',$current_inserting_participant_id);


		if($participant['participant_type'] == 'coordinator'){
			$participant['parent_id'] = null;
			if(isset($state_id)) {
				$participant['participant_id'] = $state_id . $new_pid;
			}
			if(isset($district_id)){
				$participant['participant_id'] = $district_id . $new_pid;
			}

		}else{
			//$village_id = Villages::where('village', '=', $input['village'])->pluck('village_id');
			//$participant['parent_id'] = $line['parent_id'];

			//return $village_id;

			$get_locations = Villages::getLocations($village_id);

			$state_id = $get_locations['state']['id'];

			$state_id_for_enu = $get_locations['state']['state_id'];

			//return $state_id_for_enu;

			$coordinator = States::find($state_id);

			//return $coordinator->coordinators;

			$participant['parent_id'] = $coordinator->coordinators->first()->pivot->coordinators_id;

			$participant['participant_id'] = $state_id_for_enu.sprintf('%03d', $village_id);


		}


		$nrc_id = $participant['nrc_id'];
		$nrc_id = preg_replace('/\s+/', '', $nrc_id);

		$nrc_id = strtolower($nrc_id);

		$pattern = '/(\d+){1,2}\/(\w+a|ah)(\w+a|ah)(\w+a|ah)\((\w)(\w+)?\)(\d+)/i';
		$nrc_id_format =  preg_replace_callback($pattern, function($matches){
			return $matches[1]."/".ucwords($matches[2]).ucwords($matches[3]).ucwords($matches[4])."(".ucwords($matches[5]).")".$matches[7];
		}, $nrc_id);
		//try {
			$new_participant = Participant::updateOrCreate(['nrc_id' => $nrc_id_format], $participant);
		//	$new_participant = Participant::find($new_participant->id);
		//}catch (QueryException $e){
		//	$update_error = true;
		//}


		if($participant['participant_type'] == 'coordinator')
		{
			//return var_dump($new_participant->states());
			if(isset($state_id)) {
				//return var_dump($state_id);
				$realstateid = States::where('state_id', '=', $state_id)->pluck('id');

				$new_participant->states()->sync([$realstateid]);


			}
			if(isset($district_id)){

				$new_participant->districts()->sync([$district_id]);
			}
		}
		elseif($participant['participant_type'] == 'enumerator')
		{

			if(isset($village_id)) {

				try {

					$realvillageid = Villages::where('village_id', '=', $village_id)->pluck('id');
					//return var_dump($new_participant->villages());
					//return var_dump($new_participant);
					$new_participant->villages()->attach([$realvillageid]);
				}catch (QueryException $e){

				}
			}
		}
		else
		{
			$township = Townships::where('township', '=', $input['township'])->get();
		}



		$pgroup = PGroups::all();


		$new_participant->pgroups()->sync([$pgroup->first()->id]);
	}
}
