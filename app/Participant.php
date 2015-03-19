<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'participants';


  protected $fillable = [ 'name', 'user_image', 'email', 'nrc_id', 'ethincity', 'education_level',
      'user_gender', 'dob','current_org', 'user_line_phone',
      'user_mobile_phone', 'user_mailing_address',
      'user_biography', 'parent_id', 'participant_type'];

    public function states()
    {
        return $this->belongsToMany('App\States', 'coordinators_states', 'coordinators_id', 'state_id');
    }

  public function districts()
  {
    return $this->belongsToMany('App\Districts', 'coordinators_regions', 'coordinators_id', 'region_id');
  }
  public function villages()
  {
    return $this->belongsToMany('App\Villages', 'enumerators_villages', 'enumerators_id');
  }

  public function type()
  {
      return $this->belongsTo('App\ParticipantType', 'participant_id');
  }

    public function get_parent()
    {
        return $this->belongsToMany('App\Participant', 'participants', 'parent_id', 'id');
    }

    public function scopeCoordinator($query)
    {
        return $query->whereParticipantType('coordinator');
    }

    public function scopeEnumerator($query)
    {
        return $query->whereParticipantType('enumerator');
    }

    public function scopeSpotchecker($query)
    {
        return $query->whereParticipantType('spotchecker');
    }

}
