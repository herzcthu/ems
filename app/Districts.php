<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model {

    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'districts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['district_id', 'states_id', 'district'];
    public function state()
    {
        return $this->belongsTo('App\States', 'states_id');
    }

    public function townships()
    {
        return $this->hasMany('App\Townships', 'districts_id');
    }

    public function coordinators()
    {
        return $this->belongsToMany('App\Participant', 'coordinators_regions', 'region_id');
    }

}
