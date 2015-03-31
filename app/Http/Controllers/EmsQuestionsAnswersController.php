<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsFormQuestions;
use App\EmsQuestionsAnswers;
use App\GeneralSettings;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\EmsQuestionsAnswersRequest;
use App\Participant;
use App\PGroups;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmsQuestionsAnswersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->current_user_id = Auth::id();
        $this->auth_user = User::find($this->current_user_id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($form_name_url)
    {
        //
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
            $form_name = $getform->name;
            $form_answers_count = $getform->no_of_answers;
        } elseif (!empty($form_array)) {
            $id = $getform->first()['id'];
            $form_answers_count = $getform->first()['no_of_answers'];
        } else {
            return view('errors/404');
        }

        $form = EmsForm::find($id);
        $questions = EmsFormQuestions::OfNotMain($id)->get();
        $dataentry = EmsQuestionsAnswers::where('form_id', '=', $id)->paginate(50);

        $alldata = EmsQuestionsAnswers::where('form_id', '=', $id)->get();
        foreach($questions as $k => $q){
           // print $q->id;
           // print("<br>");
            if($q->q_type == 'sub') {
                if($q->get_parent->input_type == 'same') {
                    foreach ($q->get_parent->answers as $kk => $answer){
                       // print_r(array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $kk)));
                        if(array_key_exists($kk, array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id)))){
                           // print $q->question_number;
                           // print $q->id;
                           // print $kk;
                           // print(array_count_values(array_column(array_column($alldata->toArray(), 'answers'),$q->id))[$kk]);
                           // print array_count_values(array_column(array_column($alldata->toArray(), 'answers'), $q->id))[$kk];
                        }
                        // print("<br>");
                    }
                }
            }
        }


        return view('dataentry/index', compact('form_name_url','dataentry', 'form', 'questions', 'alldata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($form_name_url)
    {
        if ($this->auth_user->can("add.data")) {
            $form_name = urldecode($form_name_url);

            $getform = EmsForm::where('name', '=', $form_name)->get();
            //return $form->toArray();
            $form_array = $getform->toArray();
            if (empty($form_array)) {
                $getform = EmsForm::find($form_name_url);
                $id = $getform->id;
                $form_name = $getform->name;
                $form_answers_count = $getform->no_of_answers;
            } elseif (!empty($form_array)) {
                $id = $getform->first()['id'];
                $form_answers_count = $getform->first()['no_of_answers'];
            } else {
                return view('errors/404');
            }

            $form = EmsForm::find($id);

            $pgroup_id = $form->pgroup_id;

            $pgroup = PGroups::find($pgroup_id);

            $enumerators = $pgroup->participants()->lists('name', 'id');


            if ($form_answers_count == 0 || empty($form_answers_count)) {
                $form_answers_count = GeneralSettings::options('options', 'answers_per_question');
            }
            //$forms = EmsForm::lists('name', 'id');
            $questions = EmsFormQuestions::OfSingleMain($id)->questionNumberAscending()->get();
            $form_id = $id;
            return view('dataentry/dataentry', compact('questions', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count'));

        } else {
            return view('errors/403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($form_name_url, EmsQuestionsAnswersRequest $request)
    {
        //return $request->all();

        $form_name = urldecode($form_name_url);
        if ($this->auth_user->can("add.data")) {

            /*
             * @var form_id
             * @var enu_id
             * @var q_id
             * @var current user_id
             * @var answers json array
             */
            $form_name = urldecode($form_name_url);

            $form = EmsForm::where('name', '=', $form_name)->get();

            $form_id = $form->first()['id'];

            $input = $request->all();

            //return $input;

            $answers['interviewer_id'] = $input['interviewer_id'];
            $answers['user_id'] = $this->current_user_id;
            $answers['interviewee_id'] = $input['interviewer_id'] . $input['interviewee_id'];
            $answers['interviewee_gender'] = $input['interviewee_gender'];
            $answers['interviewee_age'] = $input['interviewee_age'];

            $answers['answers'] = $input['answers'];
            $answers['notes'] = $input['notes'];
            if (isset($form_id)) {
                $answers['form_id'] = $form_id;
            } else {
                $answers['form_id'] = $input['form_id'];
            }

           // return $answers;
            $new_answer = EmsQuestionsAnswers::updateOrCreate(array('interviewee_id' => $answers['interviewee_id']), $answers);

            $message = 'New Data Added for form ' . $form_name . '!';
            \Session::flash('answer_success', $message);
        } else {
            $message = 'Not allow to add new data for' . $form_name . '!';
            \Session::flash('answer_success', $message);
        }
        return redirect('dataentry/' . $form_name_url . '/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($form_name_url, $interviewee)
    {
        //return $interviewee;
        if ($this->auth_user->can("add.data")) {
            $form_name = urldecode($form_name_url);

            $getform = EmsForm::where('name', '=', $form_name)->get();
            //return $form->toArray();
            $form_array = $getform->toArray();
            if (empty($form_array)) {
                $getform = EmsForm::find($form_name_url);
                $id = $getform->id;
                $form_name = $getform->name;
                $form_answers_count = $getform->no_of_answers;
            } elseif (!empty($form_array)) {
                $id = $getform->first()['id'];
                $form_answers_count = $getform->first()['no_of_answers'];
            } else {
                return view('errors/404');
            }

            $form = EmsForm::find($id);

            $pgroup_id = $form->pgroup_id;

            $pgroup = PGroups::find($pgroup_id);

            $enumerators = $pgroup->participants()->lists('name', 'id');

            //return $enumerators_from_pgroup;

            // $enus = Participant::enumerator()->get();

            // foreach ($enus as $enumerator) {
            //     $enumerators[$enumerator['id']] = $enumerator['name'];
            //   }

            if ($form_answers_count == 0 || empty($form_answers_count)) {
                $form_answers_count = GeneralSettings::options('options', 'answers_per_question');
            }
            //$forms = EmsForm::lists('name', 'id');
            $questions = EmsFormQuestions::OfSingleMain($id)->questionNumberAscending()->get();
            $form_id = $id;
            $dataentry = EmsQuestionsAnswers::where('interviewee_id', '=', $interviewee)->lists('answers', 'q_id');

            //  return $dataentry;

            return view('dataentry/edit_dataentry', compact('dataentry', 'questions', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count', 'interviewee'));
        } else {
            return view('errors/403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($form_name_url, $interviewee, EmsQuestionsAnswersRequest $request)
    {
        //return $interviewee;
        $form_name = urldecode($form_name_url);
        if ($this->auth_user->can("add.data")) {

            /*
             * @var form_id
             * @var enu_id
             * @var q_id
             * @var current user_id
             * @var answers json array
             */
            $form_name = urldecode($form_name_url);

            $form = EmsForm::where('name', '=', $form_name)->get();

            $form_id = $form->first()['id'];

            $input = $request->all();

            //return $input;

            $answers['interviewer_id'] = $input['interviewer_id'];
            $answers['user_id'] = $this->current_user_id;
            $answers['interviewee_id'] = $input['interviewer_id'] . $input['interviewee_id'];
            $answers['interviewee_gender'] = $input['interviewee_gender'];
            $answers['interviewee_age'] = $input['interviewee_age'];

            $answers['answers'] = $input['answers'];
            $answers['notes'] = $input['notes'];
            if (isset($form_id)) {
                $answers['form_id'] = $form_id;
            } else {
                $answers['form_id'] = $input['form_id'];
            }

            // return $answers;
            $new_answer = EmsQuestionsAnswers::updateOrCreate(array('interviewee_id' => $interviewee), $answers);
            $message = 'New Data Added for form ' . $form_name . '!';
            \Session::flash('answer_success', $message);
        } else {
            $message = 'Not allow to add new data for' . $form_name . '!';
            \Session::flash('answer_success', $message);
        }
        return redirect('dataentry/' . $form_name_url . '/dataentry');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
