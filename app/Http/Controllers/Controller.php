<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$layout = Request::ajax() ? 'layouts/ajax' : $this->layout;
			$this->layout = View::make($layout);
		}
	}

}
