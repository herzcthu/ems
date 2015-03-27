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


    protected $fillable = ['pgroup_id', 'name', 'descriptions', 'q_prefix', 'no_of_answers', 'start_date', 'end_date'];

    public function questions()
    {
        return $this->hasMany('App\EmsFormQuestions', 'form_id');
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

}
