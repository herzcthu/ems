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


    protected $fillable = ['pgroup_id', 'name', 'type', 'enu_form_id', 'descriptions', 'q_prefix', 'no_of_answers', 'start_date', 'end_date'];

    public function questions()
    {
        return $this->belongsToMany('App\EmsFormQuestions', 'form_types', 'form_id', 'question_id');
    }

    public function setStartDateAttributes($date)
    {
        $this->attributes['start_date'] = date('Y-m-d', strtotime($date));
    }

    public function setEndDateAttributes($date)
    {
        $this->attributes['end_date'] = date('Y-m-d', strtotime($date));
    }

    public function getStartDateAttribute($date)
    {
        // return $value;
        return date('d-m-Y', strtotime($date));
    }

    public function getEndDateAttribute($date)
    {
        // return $value;
        return date('d-m-Y', strtotime($date));
    }

    public function pgroup()
    {
        return $this->belongsTo('App\PGroups');
    }

    public function spotchecker()
    {
        return $this->hasOne('App\EmsForm', 'enu_form_id');
    }

    public function enumerator()
    {
        return $this->belongsTo('App\EmsForm', 'enu_form_id');
    }

}
