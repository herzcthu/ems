<?php namespace App\Http\Controllers;

use App\GeneralSettings;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GeneralSettingsController extends Controller {

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
			$options = GeneralSettings::all();
			//return $options[0]->options;
			//$options = json_decode($settings[0]->options, true);

			//return $options[0]['options']['site_name'];
			return view('settings.index', compact('options'));
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
		return false;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		return false;
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
		return false;
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
		return false;
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
		$this->validate($request, ['options' => 'unique:general_settings']);
		$requests = $request->all();

		$requests_array = $requests;
		unset($requests_array['_method']);
		unset($requests_array['_token']);
		foreach(array_keys($requests_array) as $key )
		{
			//return $key;
			$requests['options_name'] = $key;
			$new_settings = GeneralSettings::updateOrCreate(array('options_name' => $requests['options_name']), $requests);

		}

		return $this->index();
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
