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


    protected $fillable = ['parent_id', 'form_id', 'list_id', 'question_number', 'question', 'q_type', 'input_type', 'a_view', 'answers', 'pre-answers', 'optional'];

    public function form()
    {
        return $this->belongsToMany('App\EmsForm', 'form_types', 'question_id', 'form_id');

    }

    public function get_parent()
    {
        //return $this->belongsToMany('App\EmsFormQuestions', 'ems_form_questions', 'parent_id', 'id');
        return $this->belongsTo('App\EmsFormQuestions', 'parent_id');
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

    private function compare($a, $b)
    {
        $a = preg_replace('/^[\-]/', '', $a);
        $b = preg_replace('/^[\-]/', '', $b);
        return strcasecmp($a, $b);
    }
    public function setAnswersAttribute($value)
    {
        $answers = array_filter($value);
        uksort($answers, array($this,'compare'));

        $this->attributes['answers'] = json_encode($answers);
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

    public function scopeListIdDescending($query)
    {
        return $query->orderBy('list_id','DESC');
    }

    public function scopeListIdAscending($query)
    {
        return $query->orderBy('list_id','ASC');
    }

    public function scopeQuestionNumberDescending($query)
    {
        return $query->orderBy('question_number','DESC');
    }

    public function scopeQuestionNumberAscending($query)
    {
        return $query->orderByRaw('LENGTH(question_number),question_number');
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

    public function scopeOfQNumber($query, $q_no)
    {
        return $query->where('question_number', '=', $q_no);
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

    public function scopeOfSingleSub($query, $form_id)
    {
        $query->where('form_id', '=', $form_id);
        $query->where(function($query)
        {
            $query->where('q_type', '=', 'single')->orWhere('q_type', '=', 'sub');
        });
        return $query;
    }

    public function scopeOfNotMain($query, $form_id)
    {
        $query->where('form_id', '=', $form_id);
        $query->where(function($query)
        {
            $query->where('q_type', '!=', 'main');
        });
        return $query;
    }

    public function scopeOfNotSub($query, $form_id)
    {
        $query->where('form_id', '=', $form_id);
        $query->where(function($query)
        {
            $query->where('q_type', '!=', 'sub');
        });
        return $query;
    }

    public static function enu_child($query, $enu_qid)
    {

    }
    public static function enu_parent($enu_qid)
    {
        //$query->where('id',$enu_qid);
        $enu_question = self::find($enu_qid);
        $parent = $enu_question->get_parent;
        return $parent;
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