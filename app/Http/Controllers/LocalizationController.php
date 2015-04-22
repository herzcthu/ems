<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Stevebauman\Translation\Facades\Translation;
use Stevebauman\Translation\Models\Locale;
use Stevebauman\Translation\Models\LocaleTranslation;

class LocalizationController extends Controller {

	public function __construct(Locale $locale,LocaleTranslation $translation)
	{
		$this->middleware('auth');
		$this->current_user_id = Auth::id();
		$this->auth_user = User::find($this->current_user_id);
		$this->locale = $locale;
		$this->translation = $translation;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//return print_r($this->translation->all());
		//return dd($this->locale->translations());
		$locale_list = $this->locale->all();
		$translation_list = $this->translation;

		$current_locale = Translation::getLocale();
		$default_locale = Translation::getDefaultLocale();
		//dd($default_locale);

		//print($locale_list[$default_locale]);
		//return;
		return view('languages/index', compact('locale_list', 'current_locale', 'default_locale', 'translation_list'));
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
	public function update()
	{
		//
		$lang_id = Input::get('lang_id');
		foreach($lang_id as $id => $translation){
			$locale_id = LocaleTranslation::where('translation_id', '=', $id)->pluck('id');
			$locale = LocaleTranslation::find($locale_id);
			$locale->translation_id = $id;
			$locale->translation = $translation;
			$locale->update();
		}
		$json['status'] = true;
		$json['message'] = 'Translation updated!';
		return json_encode($json);
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
