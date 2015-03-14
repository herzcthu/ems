<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class States extends Model {

    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['state_id', 'state'];

    public function coordinators()
    {
        return $this->belongsToMany('App\Participants', 'coordinators_regions', 'region_id');
    }

    public function districts()
    {
        return $this->hasMany('App\Districts', 'states_id');
    }

}
