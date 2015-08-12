<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Geolocations extends Model {

	//
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'geolocations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'location_name', 'location_type'];

    public function coordinators()
    {
        return $this->belongsToMany('App\Participant', 'coordinators_geolocations', 'pace_id', 'coordinators_id')->withTimestamps();
    }

    public function participants()
    {
        return $this->belongsToMany('App\Participant', 'participants_geolocations', 'location_id', 'participant_id')->withPivot('pace_id')->withTimestamps();
    }

    public function children()
    {
        return $this->hasMany('App\Geolocations', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Geolocations', 'parent_id');
    }

}
