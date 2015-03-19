<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmsQuestionsAnswers extends Model {

	//
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'ems_questions_answers';


    protected $fillable = ['answers', 'form_id', 'enu_id', 'q_id', 'user_id'];

    public function question()
    {
        $this->belongsTo('App\EmsFormQuestions', 'q_id');
    }

    public function scopeOfFormId($query, $formid)
    {
        return $query->whereFormId($formid);
    }

    public function setAnswersAttribute($value)
    {
        // return $value;
        $this->attributes['answers'] = json_encode($value);
        // return json_encode($value);
    }

    /**
     * Decode Answers json string from database
     * @param $value
     * @return object
     */
    public function getAnswersAttribute($value)
    {
        // return $value;
        return json_decode($value, true);
    }

    public static function scopeOfAnswersByQ($query, $q_id)
    {
        $answers = $query->whereAnswersByQ($q_id);
        $result = $answers->first()[$q_id];
        return $result;
    }

    public static function scopeOfAnswersByEmu($query, $emu_id)
    {
        $answers = $query->whereAnswers($emu_id);
        $result = $answers->get();
        return $result;
    }
}
