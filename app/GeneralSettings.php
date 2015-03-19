<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GeneralSettings extends Model {

    //
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'general_settings';


    protected $fillable = ['options_name', 'options'];


    protected  $cast = [
      'options' => 'array',
    ];

    /**
     * Decode options json string from database
     * @param $value
     * @return object
     */
    public function setOptionsAttribute($value)
    {
        // return $value;
        $this->attributes['options'] = json_encode($value);
       // return json_encode($value);
    }

    /**
     * Decode options json string from database
     * @param $value
     * @return object
     */
    public function getOptionsAttribute($value)
    {
       // return $value;
        return json_decode($value, true);
    }

    /**
     * Get site settings from general_settings database
     * @param $query
     * @param $option
     * @param string $option1
     * @return string
     */
    public static function scopeOptions($query, $option, $option1 = '')
    {
            $options = $query->whereOptionsName($option);
            $value = $options->first()[$option][$option1];

            return $value;
    }
}
