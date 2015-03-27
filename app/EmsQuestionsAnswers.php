<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Support\Collection;

class EmsQuestionsAnswers extends Model {

	//
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'ems_questions_answers';


    protected $fillable = ['answers', 'form_id', 'enu_id', 'q_id', 'user_id', 'interviewee_id', 'interviewee_gender', 'interviewee_age', 'interviewee_villageid'];

    public function question()
    {
        return $this->belongsTo('App\EmsFormQuestions', 'q_id');
    }

    public function village()
    {
        return $this->belongsTo('App\Villages', 'interviewee_villageid');
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

    public function setIntervieweeIdAttribute($value)
    {
        // return $value;
        $request = Request::all();

        //print_r($request);

        //die();

        $this->attributes['interviewee_id'] = $value;
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
        return $query->where('q_id', '=', $q_id);
    }

    public static function scopeOfAnswersByInterviewee($query, $interviewee_id)
    {
        return $query->where('interviewee_id', '=', $interviewee_id);
    }

    public static function scopeOfAnswersByEmu($query, $emu_id)
    {
        return $query->where('emu_id', '=', $emu_id);
    }

    public static function scopeOfAnsByInvWithQ($query, $inv, $q_id)
    {
        $query->where('q_id', '=', $q_id)->where('interviewee_id', '=', $inv);
      //  $query->where(function($query)
      //  {
       //     $query->where('q_type', '=', 'single')->orWhere('q_type', '=', 'sub');
      //  });
        return $query;
    }


    public static function AllArray()
    {

        //return $query;
        $totalinv = EmsQuestionsAnswers::lists('interviewee_id');
        $uniqueinv = array_unique($totalinv);

        // $paginated = $this->paginate($uniqueinv, 10);
        // $gettotalinv = $paginated['currentpage'];


        //foreach($uniqueinv as $inv_id){
        for($i=0; $i < count($uniqueinv); $i++){

            //var_dump($inv_id);

            $answers_for_inv = EmsQuestionsAnswers::where('interviewee_id', '=', $uniqueinv[$i])->get();

            //var_dump($answers_for_inv->toArray());



            foreach($answers_for_inv as $k => $v)
            {
                //var_dump($v);
               // $interviewee['interviewee'] = $query->where('interviewee_id', '=', $inv_id)->get();

                $interviewee[$uniqueinv[$i]]['enumerator'] = Participant::where('id', '=', $v['enu_id']);

                $interviewee[$uniqueinv[$i]]['questions'] = EmsFormQuestions::find($v['q_id']);

                $interviewee[$uniqueinv[$i]]['answers'][$k] = EmsQuestionsAnswers::where('interviewee_id', '=', $uniqueinv[$i])->where('q_id', '=', $v['q_id']);


                $interviewee[$uniqueinv[$i]]['form'] = EmsForm::where('id', '=', $v['form_id']);

                $interviewee[$uniqueinv[$i]]['user'] = User::where('id', '=', $v['user_id']);

               // var_dump($alldata);
                //$interviewee[$uniqueinv[$i]] = new Collection();
                //$interviewee[$uniqueinv[$i]]->merge()

            }
           // print_r($interviewee[$uniqueinv[$i]]['answers']);

            //print_r($interviewee);
           // var_dump($interviewee[$inv_id]);
          //  die();
            $onedata[$i][$uniqueinv[$i]] = new Collection($interviewee[$uniqueinv[$i]]);


        }
        return new Collection($onedata);


    }

    public static function ExportArray($form_id)
    {
        //return $form_id;
        $totalinv = EmsQuestionsAnswers::where('form_id','=', $form_id)->lists('interviewee_id');
        //return $totalinv;
        $uniqueinv = array_values(array_unique($totalinv));

        //return $uniqueinv;

        for($i=0; $i < count($uniqueinv); $i++){

            $answers_for_inv = EmsQuestionsAnswers::where('interviewee_id', '=', $uniqueinv[$i])->get();


            foreach($answers_for_inv as $k => $v)
            {


                $enumerator = Participant::find( $v['enu_id']);

                $questions = EmsFormQuestions::find($v['q_id']);

                $answers[$uniqueinv[$i]][$v['q_id']] = EmsQuestionsAnswers::where('interviewee_id', '=', $uniqueinv[$i])->where('q_id', '=', $v['q_id']);

                $form = EmsForm::where('id', '=', $v['form_id']);

                $user = User::where('id', '=', $v['user_id']);

                $totalquestions_per_form = EmsFormQuestions::find($v['form_id'])->get();


            }


        }


        $ans1 = array();

        foreach($answers as $k => $answer)
        {
            ;
            foreach( $answer as $key => $ans){

                $ans1[$k][$key] = $ans->first()['answers']['answer'];
            }



        }
        //print $enumerator->villages->first()['village_id'];


       // print $totalquestions_per_form[1]->id;
        array_walk($ans1, array('self', 'print_ans'), $totalquestions_per_form);


        array_walk($ans1, array('self', 'change_ans_key'), compact('totalquestions_per_form','enumerator'));
        return $ans1;

    }
    public static function print_ans(&$item , $key, $object)
    {
        foreach($object as $question){
            if($question->q_type != 'main') {
                if (!array_key_exists($question->id, $item)) {
                    $item[$question->id] = '';
                    ksort($item);
                }
            }

        }
    }
    public static function array_unshift_assoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        return array_reverse($arr, true);
    }
    public static function change_ans_key(&$item, $key, $object)
    {

        foreach($item as $k => $v){
            $question = EmsFormQuestions::find($k);

           /// print $k;
           // print $v;
            $q_num = '';
            if($question->q_type == 'sub')
            {
                $q_num .= $question->get_parent->question_number;
            }

            $q_num .= $question->question_number;

            $arr[$q_num] = $v;
        }
        $item = $arr;


        $item = self::array_unshift_assoc($item, 'interviewee_id', $key);

      }


}
