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

    public static function getLocations($village_id)
    {
       // return $village_id;
        $village_id = Villages::where('village_id', '=', $village_id)->pluck('id');

        $village = Villages::find($village_id);

        $township = Townships::find($village->township->id);

        $district = Districts::find($township->district->id);

        $state = States::find($district->state->id);

        $query = compact('village','township','district', 'state');

        return $query;
    }

    public static function getVillageName($village_id)
    {
        return Villages::where('village_id', '=', $village_id)->pluck('village');
    }

    public static function getTownshipByVillageID($village_id)
    {
        $village_id = Villages::where('village_id', '=', $village_id)->pluck('id');

        $village = Villages::find($village_id);

        $township = Townships::find($village->township->id);

        return $township;
    }
    public static function getDistrictByVillageID($village_id)
    {
        $village_id = Villages::where('village_id', '=', $village_id)->pluck('id');

        $village = Villages::find($village_id);

        $township = Townships::find($village->township->id);

        $district = Districts::find($township->district->id);

        return $district;
    }

    public static function getStateByVillageID($village_id)
    {
        // return $village_id;
        $village_id = Villages::where('village_id', '=', $village_id)->pluck('id');

        $village = Villages::find($village_id);

        $township = Townships::find($village->township->id);

        $district = Districts::find($township->district->id);

        $state = States::find($district->state->id);

        return $state;
    }

}
