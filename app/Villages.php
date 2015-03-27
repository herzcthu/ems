<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Villages extends Model {

	//
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'villages';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['townships_id', 'village', 'villagetrack', 'village_id', 'village_my'];

    public function township()
    {
        return $this->belongsTo('App\Townships', 'townships_id');
    }

    public function enumerator()
    {
        return $this->belongsToMany('App\Participant');
    }

    public function interviewee()
    {
        return $this->hasMany('App\EmsQuestionsAnswers');
    }

}
