<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmsForm extends Model {

	//
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'ems_forms';


    protected $fillable = ['name', 'descriptions', 'start_date', 'end_date'];

    public function questions()
    {
        return $this->hasMany('App\EmsFormQuestions', 'form_id');
    }

}
