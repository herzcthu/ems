<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Participants extends Model {

	//
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'participants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'user_image', 'email', 'nrc_id', 'ethincity', 'education_level',
                            'user_gender', 'dob', 'user_line_phone',
                            'user_mobile_phone', 'user_mailing_address',
                            'user_biography'];

    public function states()
    {
        return $this->belongsToMany('App\States', 'participants_states', 'participants_id');
    }
    public function enumerator()
    {
        return $this->hasMany('App\Participants', 'parent_id')->where('participant_type', 'enumerator');
    }
    public function spotchecker()
    {
        return $this->hasMany('App\Participants', 'parent_id')->where('participant_type', 'spotchecker');
    }
}
