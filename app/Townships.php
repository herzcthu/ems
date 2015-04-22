<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Townships extends Model {

    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'townships';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['districts_id', 'township'];

    public function district()
    {
        return $this->belongsTo('App\Districts', 'districts_id');
    }

    public function villages()
    {
        return $this->hasMany('App\Villages', 'townships_id');
    }

    public function spotcheckers()
    {
        return $this->belongsToMany('App\Participant', 'spotcheckers_townships', 'townships_id', 'spotcheckers_id')->withTimestamps();
    }

    public static function getLocations($township_id)
    {
        // return $village_id;
        //$village_id = Villages::where('village_id', '=', $village_id)->pluck('id');

        //$village = Villages::find($village_id);

        $township = Townships::find($township_id);

        $district = Districts::find($township->district->id);

        $state = States::find($district->state->id);

        $query = compact('township','district', 'state');

        return $query;
    }

}
