<?php namespace App;

use App\Villages;
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


    protected $fillable = ['answers', 'notes', 'form_id',
        'enu_id', 'q_id', 'user_id', 'interviewee_id',
        'interviewee_gender', 'interviewee_age', 'interviewer_id', 'psu'];



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
    private function compare($a, $b)
    {
        $a = preg_replace('/^[\-]/', '', $a);
        $b = preg_replace('/^[\-]/', '', $b);
        return strcasecmp($a, $b);
    }
    public function setNotesAttribute($value)
    {
        $notes = array_filter($value);
        uksort($notes, array($this,'compare'));

        $this->attributes['notes'] = json_encode($notes);
        // return json_encode($value);
    }

    /**
     * Decode Answers json string from database
     * @param $value
     * @return object
     */
    public function getNotesAttribute($value)
    {
        // return $value;
        return json_decode($value, true);
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


    /**
     * Generate all data entry array from database
     * @param $form_name_url
     * @return array
     */
    public static function get_alldataentry($form_name_url)
    {
        $form_name = urldecode($form_name_url);
        try {
            $getform = EmsForm::where('name', '=', $form_name)->get();
            $form_array = $getform->toArray();
        }catch (QueryException $e){
            $form_array = '';
        }
        //return $form->toArray();

        if (empty($form_array)) {
            $getform = EmsForm::find($form_name_url);
            $id = $getform->id;
        } elseif (!empty($form_array)) {
            $id = $getform->first()['id'];
        } else {
            return false;
        }

        $questions = EmsFormQuestions::OfNotMain($id)->get();
        $dataentry = EmsQuestionsAnswers::where('form_id', '=', $id)->get();
        foreach($dataentry as $data) {

            $alldata[$data->interviewee_id]['Interviewee ID'] = $data->interviewee_id;
            $alldata[$data->interviewee_id]['Interviewee Gender'] = $data->interviewee_gender;
            $alldata[$data->interviewee_id]['Interviewer ID'] = $data->interviewer_id;

            preg_match('/([1-9][0-9]{2})([0-9]{3})/', $data->interviewer_id, $matches);

            //return $matches;

            $locations = Villages::getLocations($matches[2]);

            //$village_name = Villages::getVillageName($matches[2]);

            $alldata[$data->interviewee_id]['State'] = $locations['state']['state'];
            $alldata[$data->interviewee_id]['District'] = $locations['district']['district'];
            $alldata[$data->interviewee_id]['Township'] = $locations['township']['township'];
            $alldata[$data->interviewee_id]['Village Track'] = $locations['village']['villagetrack'];
            $alldata[$data->interviewee_id]['Village'] = $locations['village']['village'];


            foreach ($questions as $q) {
                if($q->q_type == 'sub' || $q->q_type == 'same') {
                    if (array_key_exists($q->id, $data->answers)) {
                        if(is_array($data->answers[$q->id])){

                            for ($i = 1; $i <= 15; $i++) {
                                if (in_array($i, $data->notes)) {

                                    foreach ($data->notes as $note) {
                                        if ($note == $i) {
                                            foreach ($data->answers[$q->id] as $da) {
                                                if (array_key_exists($note, $da)) {

                                                    $alldata[$data->interviewee_id][$q->get_parent->question_number . $q->question_number . $note] = $da[$note];
                                                }

                                            }
                                        }
                                    }
                                }else{
                                    $alldata[$data->interviewee_id][$q->get_parent->question_number . $q->question_number . $i] = '';
                                }
                            }

                        }else {
                            $alldata[$data->interviewee_id][$q->get_parent->question_number . $q->question_number] = $data->answers[$q->id];
                        }
                    }else{
                        $alldata[$data->interviewee_id][$q->get_parent->question_number.$q->question_number] = '';
                    }
                }else{
                    if (array_key_exists($q->id, $data->answers)) {
                        $alldata[$data->interviewee_id][$q->question_number] = $data->answers[$q->id];
                    }else{
                        $alldata[$data->interviewee_id][$q->question_number] = '';
                    }
                }

            }
        }

        return $alldata;
    }

    public static function getAllByState($state, $alldata){
        $statedata = array();
        foreach($alldata as $data) {
            if (in_array($state, $data)) {
                $statedata[] = $data;
            }
        }
        return $statedata;
    }

    /**

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
        **/

}
