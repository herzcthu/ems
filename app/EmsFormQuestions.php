<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmsFormQuestions extends Model {

	//
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'ems_form_questions';


    protected $fillable = ['parent_id', 'form_id', 'question_number', 'question', 'q_type', 'input_type', 'answers'];

    public function form()
    {
        return $this->belongsTo('App\EmsForm', 'form_id');

    }

    public function get_children()
    {
        //return $this->belongsToMany('App\EmsFormQuestions', 'ems_form_questions', 'parent_id', 'id');
        return $this->hasMany('App\EmsFormQuestions', 'parent_id');
    }

    public function answers()
    {
        return $this->hasMany('App\EmsQuestionsAnswers', 'q_id');
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
    public function scopeIdDescending($query)
    {
        return $query->orderBy('id','DESC');
    }

    public function scopeIdAscending($query)
    {
        return $query->orderBy('id','ASC');
    }

    public function scopeSingle($query)
    {
        return $query->whereQType('single');
    }
    public function scopeMain($query)
    {
        return $query->whereQType('main');
    }
    public function scopeOrSingle($query)
    {
        return $query->orWhere('q_type', '=', 'single');
    }
    public function scopeOrMain($query)
    {
        return $query->orWhere('q_type', '=', 'main');
    }
    public function scopeInputRadio($query)
    {
        return $query->whereInputType('radio');
    }
    public function scopeInputChoice($query)
    {
        return $query->whereInputType('choice');
    }
    public function scopeInputSelect($query)
    {
        return $query->whereInputType('select');
    }

    public function scopeSingleMain($query)
    {
        $query->Where('q_type', '=', 'single');
        $query->Where('q_type', '=', 'main');
        return $query;
    }
    public function scopeOfFormID($query, $form_id)
    {
        return $query->where('form_id', '=', $form_id);
    }

    /**
     * Search for form id and
     * search for question type is single or main
     * @param $query
     * @param $form_id
     * @return mixed
     */
    public function scopeOfSingleMain($query, $form_id)
    {
        $query->where('form_id', '=', $form_id);
        $query->where(function($query)
        {
            $query->where('q_type', '=', 'single')->orWhere('q_type', '=', 'main');
        });
        return $query;
    }

}
/*
 * ->where('name', '=', 'John')
            ->orWhere(function($query)
            {
                $query->where('votes', '>', 100)
                      ->where('title', '<>', 'Admin');
            })
 */