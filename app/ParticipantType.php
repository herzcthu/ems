<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipantType extends Model {

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'participant_types';


    protected $fillable = [ 'name', 'participant_id'];

    public function participants()
    {
        return $this->hasMany('App\Participant', 'participant_id');
    }
}
