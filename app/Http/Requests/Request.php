<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

abstract class Request extends FormRequest {

	//
    public function validator(){

        $v = Validator::make($this->input(), $this->rules(), $this->messages(), $this->attributes());

        if(method_exists($this, 'dataentryValidation')){
            $this->dataentryValidation($v);
        }

        return $v;
    }

}
