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

}
