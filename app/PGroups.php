<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PGroups extends Model {

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'p_groups';


    protected $fillable = [ 'name', 'descriptions'];

    public function participants()
    {
        return $this->belongsToMany('App\Participant', 'participants_pgroups', 'pgroups_id');
    }
    public function forms()
    {
        return $this->hasMany('App\EmsForm', 'pgroup_id');
    }
}
