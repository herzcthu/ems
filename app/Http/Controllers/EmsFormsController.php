<?php namespace App\Http\Controllers;

use App\EmsForm;
use App\EmsFormQuestions;
use App\EmsQuestionsAnswers;
use App\GeneralSettings;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\EmsFormQuestionsRequest;
use App\Http\Requests\EmsQuestionsAnswersRequest;
use App\Participant;
use App\PGroups;
use App\SpotCheckerAnswers;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
//use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class EmsFormsController extends Controller
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
    public function index()
    {
        //
        //$forms = EmsForm::paginate(30);
        /** @var object $forms */
        //$enu_form = EmsForm::find(2)->enumerator;

        //dd($enu_form->id);


        $forms = EmsForm::all();

        return view('forms/index', compact('forms'));
    }

    /*
     *
     */
    /**
     * @param $form_url
     * @return \Illuminate\View\View
     * @internal param $id
     */
    public function create_question_form($form_name_url = '')
    {
        if ($this->auth_user->can("create.form")) {
            $form_name = urldecode($form_name_url);

            $getform = EmsForm::where('name', '=', $form_name)->get();
            // return $getform->toArray();
            $form_array = $getform->toArray();
            if (empty($form_array)) {
                $getform = EmsForm::find($form_name_url);
                if (!empty($getform) || null !== $getform) {
                    $form_id = $getform->id;
                    $form_name = $getform->name;
                    $form_answers_count = $getform->no_of_answers;
                    $form_type = $getform->type;
                    $enu_form_id = $getform->enu_form_id;
                }
            } elseif (!empty($form_array)) {
                $form_id = $getform->first()['id'];
                $form_name = $getform->first()['name'];
                $form_type = $getform->first()['type'];
                $form_answers_count = $getform->first()['no_of_answers'];
                $enu_form_id = $getform->first()['enu_form_id'];
            } else {
                return view('errors/404');
            }

            $enus = Participant::enumerator()->get();

            foreach ($enus as $enumerator) {
                $enumerators[$enumerator['id']] = $enumerator['name'];
            }

            if (!isset($form_answers_count) || ($form_answers_count == 0 || empty($form_answers_count))) {
                $form_answers_count = GeneralSettings::options('options', 'answers_per_question');
            }
            //$forms = EmsForm::lists('name', 'id');
            $forms = EmsForm::lists('name', 'id');
            if($form_type == 'spotchecker'){
                //dd($enu_form_id);
                $main_questions = EmsFormQuestions::OfSingleMain($enu_form_id)->lists('question_number', 'id');;

            }else {
                $main_questions = EmsFormQuestions::where('q_type', '=', 'main')->lists('question_number', 'id');
            }

            return view('forms/build_qform', compact('forms', 'main_questions', 'form_name_url', 'form_answers_count', 'form_id', 'form_name', 'form_type'));
        } else {
            return view('errors/403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function qedit($question_id)
    {
        //

        if ($this->auth_user->can("create.form")) {



            $enus = Participant::enumerator()->get();

            foreach ($enus as $enumerator) {
                $enumerators[$enumerator['id']] = $enumerator['name'];
            }


            $forms = EmsForm::lists('name', 'id');
            $questions = EmsFormQuestions::where('q_type', '=', 'main')->lists('question_number', 'id');
            $question = EmsFormQuestions::find($question_id);

            if(!empty($question->form->first()) ){
                $form_answers_count = $question->form->first()->no_of_answers;
                $form_type = $question->form->first()->type;
            } else {
                $form_answers_count = GeneralSettings::options('options', 'answers_per_question');
                $form_type = 'enumerator';
            }
            $forms = EmsForm::lists('name', 'id');
            //dd($form_type);
            if($form_type == 'spotchecker'){
                $enu_form = EmsForm::find($question->form->first()->enu_form_id);

                $main_questions = EmsFormQuestions::OfSingleMain($enu_form->id)->lists('question_number', 'id');
            }else {
                $main_questions = EmsFormQuestions::where('q_type', '=', 'main')->lists('question_number', 'id');
            }
            return view('forms/edit_qform', compact('forms', 'main_questions', 'question', 'id', 'form_answers_count', 'form_type'));
        } else {
            return view('errors/403');
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save_question(EmsFormQuestionsRequest $request, $form_url)
    {
       //return $request->all();
        if ($this->auth_user->can("create.form")) {
            $form_input = $request->all();
            $q['form_id'] = $form_input['form_id'];

            if(isset($form_input['list_id'])) {
                $q['list_id'] = $form_input['list_id'];
            }else{
                $form = EmsForm::find($form_input['form_id']);
                //dd($form->questions->toArray());
                $q['list_id'] = count($form->questions->toArray()) + 1;
            }

            $q['question_number'] = $form_input['question_number'];

            $q['question'] = $form_input['question'];

            $q['q_type'] = $form_input['q_type'];

            $q['a_view'] = $form_input['a_view'];

            if ($form_input['q_type'] == 'sub' || $form_input['q_type'] == 'same' || $form_input['q_type'] == 'spotchecker') {
                $q['parent_id'] = $form_input['main_id'];
            } else {
                $q['parent_id'] = null;
            }
            if ($form_input['q_type'] != 'main') {
                $q['input_type'] = $form_input['input_type'];

                $q['answers'] = $form_input['answers'];
            }
            if ( $form_input['q_type'] == 'main' && $form_input['input_type'] == 'same')
            {
                $q['input_type'] = $form_input['input_type'];

                $q['answers'] = $form_input['answers'];
            }

            //return $form['answers'];
            $question = EmsFormQuestions::create($q);
            $question->form()->sync([$form_input['form_id']], false);
            //$form = EmsForm::find($q['form_id']);
            //$form->questions()->attach($question->id);
            $message = 'New Question Created!';
            \Session::flash('form_build_success', $message);


        }
        return redirect('forms/' . $form_url . '/add_question');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     * @internal param int $id
     */
    public function qupdate(EmsFormQuestionsRequest $request, $id)
    {
        //

        $question = EmsFormQuestions::findOrFail($id);
        $form_input = $request->all();
        $question->form_id = $form_input['form_id'];

        $question->question_number = $form_input['question_number'];

        $question->question = $form_input['question'];

        $question->q_type = $form_input['q_type'];

        $question->a_view = $form_input['a_view'];

        if ($form_input['q_type'] == 'sub' || $form_input['q_type'] == 'same' || $form_input['q_type'] == 'spotchecker') {
            $question->parent_id = $form_input['main_id'];
        } else {
            $question->parent_id = null;
        }
        if ($form_input['q_type'] != 'main') {
            $question->input_type = $form_input['input_type'];
            $question->answers = $form_input['answers'];
        }
        if ( $form_input['q_type'] == 'main' && $form_input['input_type'] == 'same')
        {
            $question->input_type = $form_input['input_type'];

            $question->answers = $form_input['answers'];
        }

        //return $question;
        $question->push();
        $question->form()->sync([$form_input['form_id']], false);
        return redirect('forms/question/' . $id);
    }

    public function dataentry_form($form_name_url)
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
            return view('forms/dataentry', compact('questions', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count'));

        } else {
            return view('errors/403');
        }
    }


    /**
     * @param $form_name_url
     * @param Requests\EmsQuestionsAnswersRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dataentry_save($form_name_url, EmsQuestionsAnswersRequest $request)
    {

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
            foreach ($input['answers'] as $q_id => $answer) {
                $answers['enu_id'] = $input['enu_id'];
                $answers['user_id'] = $this->current_user_id;
                $answers['interviewee_id'] = $input['interviewee_id'];
                $answers['interviewee_gender'] = $input['interviewee_gender'];
                $answers['interviewee_age'] = $input['interviewee_age'];
                $enu = Participant::find($input['enu_id']);

                $enu_village_id = $enu->villages->first()['village_id'];

                $answers['interviewee_villageid'] = $enu_village_id;
                $answers['q_id'] = $q_id;
                //$request->q_id = $q_id;
                //$request->interviewee_id;
                //return $request->q_id;
                $this->validate($request, ['q_id' => 'unique']);
                // $this->validate($request, ['q_id' => 'required|unique_with:ems_questions_answers,interviewee_id']);
                $answers['answers'] = $answer;
                if (isset($form_id)) {
                    $answers['form_id'] = $form_id;
                } else {
                    $answers['form_id'] = $input['form_id'];
                }


                $new_answer = EmsQuestionsAnswers::updateOrCreate(array('q_id' => $answers['q_id'],
                    'interviewee_id' => $answers['interviewee_id']), $answers);
                //$new_answer = EmsQuestionsAnswers::create($answers);
            }

            //$input['enu_id']
            //$answers_by_form_id = EmsQuestionsAnswers::ofFormId($form_id)->get();
            //print $answers;
            //print($input['form_id']);
            //print($form_id);
            $message = 'New Data Added for form ' . $form_name . '!';
            \Session::flash('answer_success', $message);
        } else {
            $message = 'Not allow to add new data for' . $form_name . '!';
            \Session::flash('answer_success', $message);
        }
        return redirect('forms/' . $form_name_url . '/dataentry');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function dataentry_edit($form_name_url, $interviewee)
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
            $dataentry = EmsQuestionsAnswers::where('interviewee_id', '=', $interviewee)->lists('answers','q_id');

          //  return $dataentry;

            return view('forms/edit_dataentry', compact('dataentry','questions', 'form_name', 'form_name_url', 'form_id', 'enumerators', 'form_answers_count', 'interviewee'));
        } else {
            return view('errors/403');
        }
    }

    /**
     * This page will show selected results and charts
     * @param $forms
     * @return \Illuminate\View\View
     */
    public function results($forms)
    {
        //$answers = EmsQuestionsAnswers::answersByQ(1);

        $answers = EmsQuestionsAnswers::all();

        return 'This is main result screen';

        return view('results/index', compact('answers'));
    }

    public function paginate($alldata, $perpage, $form_name_url)
    {
        $totalentry = count($alldata);

       // $perpage = 100;

        $alldata = array_chunk($alldata->toArray(), $perpage, true);
        $currentpage = Input::get('page');

        if (!isset($currentpage)) {
            $currentpage = 1;
        }
        //return $currentpage;
        /**
         * currentPage
         * lastPage
         * perPage
         * hasMorePages
         * url
         * nextPageUrl
         * total
         * count*/

        $total = ceil($totalentry / $perpage);

        if($currentpage < $total) {
            $next = $currentpage + 1;

        }else{
            $next = $currentpage;
        }
        if($next <= $total ){
            $nexturl = "?page=".$next;
        }else{
            $nexturl = "";
        }
        // return $next;
        if($currentpage > 1) {
            $previous = $currentpage - 1;
        }else{
            $previous = 1;
        }

        if($previous > 1){
            $previousurl = "?page=".$previous;
        }else{
            $previousurl = "/results/".$form_name_url."/details";
        }



        $menu = "";
        $pn = $currentpage;
        $lastPage = ceil($totalentry / $perpage);
        if ($pn < 1) { // If it is less than 1
            $pn = 1; // force if to be 1
        } else if ($pn > $lastPage) { // if it is greater than $lastpage
            $pn = $lastPage; // force it to be $lastpage's value
        }

        $sub1 = $pn - 1;
        $sub2 = $pn - 2;
        $sub3 = $pn - 3;
        $add1 = $pn + 1;
        $add2 = $pn + 2;
        $add3 = $pn + 3;

        if($pn == 1) {
            $menu .= "<li class='active'><a href='?page=$pn'>$pn</a></li>";
            if($lastPage > 1) {
                $menu .= "<li><a href='?page=$add1'>$add1</a></li>";
                if($lastPage > 2) {
                    $menu .= "<li><a href='?page=$add2'>$add2</a></li>";
                    if($lastPage > 3) {
                        $menu .= "<li><a href='?page=$add3'>$add3</a></li>";
                    }
                }
            }
        }elseif($pn == $lastPage){
            if($lastPage > 1) {
                if($lastPage > 2) {
                    if($lastPage > 3) {
                        $menu .= "<li><a href='?page=$sub3'>$sub3</a></li>";
                    }
                    $menu .= "<li><a href='?page=$sub2'>$sub2</a></li>";
                }
                $menu .= "<li><a href='?page=$sub1'>$sub1</a></li>";
            }
            $menu .= "<li class='active'><a href='?page=$pn'>$pn</a></li>";
        }else if ($pn > 2 && $pn <= ($lastPage - 1)) {
            if($lastPage > 1) {
                if($lastPage > 3) {
                    $menu .= "<li><a href='?page=$sub2'>$sub2</a></li>";
                }
                $menu .= "<li><a href='?page=$sub1'>$sub1</a></li>";
            }
            $menu .= "<li class='active'><a href='?page=$pn'>$pn</a></li>";
            if($lastPage > 1) {
                $menu .= "<li><a href='?page=$add1'>$add1</a></li>";
            }
        }else if ($pn > 1 && $pn <= $lastPage - 1) {
            if($lastPage >= 1) {
                $menu .= "<li><a href='?page=$sub1'>$sub1</a></li>";
            }
            $menu .= "<li class='active'><a href='?page=$pn'>$pn</a></li>";
            if($lastPage > 1) {
                $menu .= "<li><a href='?page=$add1'>$add1</a></li>";
                if ($lastPage > 3){
                    $menu .= "<li><a href='?page=$add2'>$add2</a></li>";
                }
            }
        }

        $first = "/results/".$form_name_url."/details";
        $last = "?page=".$lastPage;
        $page = $currentpage - 1;

        $current_showing = (ceil($totalentry / $total) * ($page + 1 )) - ($perpage - 1 );
        if($current_showing < $totalentry ){
            $current_showing = $totalentry;
        }
        $lastitem_perpage = ceil($totalentry / $total) * ($page + 1 );
        if($lastitem_perpage > $totalentry){
            $lastitem_perpage = $totalentry;
        }

        $page_array = array(
            'totalpage' => $total,
            'currentPageNo' => $page,
            'url' => '?page=',
            'previous' => $previous,
            'next' => $next,
            'previousPageUrl' => $previousurl ,
            'nextPageUrl' =>  $nexturl,
            'totalentry' => $totalentry,
            'menu' => $menu,
            'first' => $first,
            'last' => $last,
            'current_showing' => $current_showing,
            'last_item' => $lastitem_perpage,
        );


        if (array_key_exists($page, $alldata)){

            $items = $alldata[$page];
            //print_r($items);
        }else{
            return view('errors/404');
        }

        return new Paginator($items, $perpage, $currentpage, $page_array);
    }

    public function ajax_array()
    {

    }

    protected function all_array($inv_id)
    {
        //$inv_id = 12345;

        $answers_for_inv = EmsQuestionsAnswers::where('interviewee_id', '=', $inv_id)->get();

        foreach ($answers_for_inv as $k => $v) {
            $questions = EmsFormQuestions::find($v['q_id'])->get();

            $answers = EmsQuestionsAnswers::where('q_id', '=', $v['q_id'])->get();

            $enumerator = Participant::where('id', '=', $v['enu_id'])->get();

            $form = EmsForm::where('id', '=', $v['form_id'])->get();

            $user = User::where('id', '=', $v['user_id'])->get();

        }

        // return $answers->toJson();

        $alldata_for_inv = compact('questions', 'answers', 'enumerator', 'form', 'user');
        return $alldata_for_inv;

    }

    /**
     * Details screen for All questions and answers of given form
     * @param $forms Form ID
     * @return \Illuminate\View\View
     */
    public function results_details(Request $request, $form_name_url)
    {
        $form_name = urldecode($form_name_url);

        $getform = EmsForm::where('name', '=', $form_name)->get();

        $form_array = $getform->toArray();
        if (empty($form_array)) {
            $getform = EmsForm::find($form_name_url);
            if (!empty($getform)) {
                $id = $getform->id;
                $form_name = $getform->name;
                $form_answers_count = $getform->no_of_answers;
            }
        } elseif (!empty($form_array)) {
            $id = $getform->first()['id'];
            $form_answers_count = $getform->first()['no_of_answers'];
        } else {
            return view('errors/404');
        }
        $singlesubquestions = EmsFormQuestions::ofSinglesub($id)->get();
        $singlemainquestions = EmsFormQuestions::ofSingleMain($id)->get();
        $allquestions = EmsFormQuestions::all();
        $totalquestions_per_form = EmsFormQuestions::ofSingleSub($id)->get();

        //return count($totalquestions_per_form);

        $answers = EmsQuestionsAnswers::all();
        $totalinv = EmsQuestionsAnswers::lists('interviewee_id');
        $uniqueinv = array_unique($totalinv);
        //}
        $alldata = EmsQuestionsAnswers::AllArray();

        $allinonedata = $alldata->toArray();
        $paginator = $this->paginate($alldata, 100, $form_name_url);



        return view('results/details2', compact('form_name_url','totalquestions_per_form', 'gettotalinv', 'paginator'));
    }

    /**
     * @param $form_name_url
     * @param Requests\EmsQuestionsAnswersRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dataentry_update($form_name_url, $interviewee, EmsQuestionsAnswersRequest $request)
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
            foreach ($input['answers'] as $q_id => $answer) {
                $answers['interviewee_id'] = $input['interviewee_id'];
                $answers['q_id'] = $q_id;
                $request->q_id = $q_id;
                $request->interviewee_id;
                //return $request->q_id;

                // $this->validate($request, ['q_id' => 'required|unique_with:ems_questions_answers,interviewee_id']);
                $answers['answers'] = $answer;
                if (isset($form_id)) {
                    $answers['form_id'] = $form_id;
                } else {
                    $answers['form_id'] = $input['form_id'];
                }
                $answers['enu_id'] = $input['enu_id'];
                $answers['user_id'] = $this->current_user_id;

                $new_answer = EmsQuestionsAnswers::updateOrCreate(array('q_id' => $answers['q_id'],
                    'interviewee_id' => $answers['interviewee_id']), $answers);
                //$new_answer = EmsQuestionsAnswers::create($answers);
            }

            //$input['enu_id']
            //$answers_by_form_id = EmsQuestionsAnswers::ofFormId($form_id)->get();
            //print $answers;
            //print($input['form_id']);
            //print($form_id);
            $message = 'New Data Added for form ' . $form_name . '!';
            \Session::flash('answer_success', $message);
        } else {
            $message = 'Not allow to add new data for' . $form_name . '!';
            \Session::flash('answer_success', $message);
        }
        return redirect('forms/' . $form_name_url . '/dataentry');
    }

    public function export_dataentry(Excel $excel, $form_name_url)
    {
        $form_name = urldecode($form_name_url);

        $getform = EmsForm::where('name', '=', $form_name)->get();

        $form_array = $getform->toArray();
        if (empty($form_array)) {
            $getform = EmsForm::find($form_name_url);
            if (!empty($getform)) {
                $id = $getform->id;
                $form_name = $getform->name;
                $form_answers_count = $getform->no_of_answers;
                $form_type = $getform->type;
            }
        } elseif (!empty($form_array)) {
            $id = $getform->first()['id'];
            $form_answers_count = $getform->first()['no_of_answers'];
            $form_type = $getform->first()['type'];
        } else {
            return view('errors/404');
        }

        if($form_type == 'enumerator') {
            $data_array = EmsQuestionsAnswers::get_alldataentry($id);
        }
        if($form_type == 'spotchecker'){
            $data_array = SpotCheckerAnswers::get_alldataentry($id);
        }

       // print_r($data_array);
       // return;

        $excel->create($form_name_url, function($excel) use($data_array) {

            $excel->sheet('Sheetname', function($sheet) use($data_array) {

                $sheet->fromArray($data_array);
                //$sheet->fromArray($data_array,null, 'A1', false, true);

               // $sheet->loadview('results/excel');

            });

        })->export('xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        if ($this->auth_user->can("create.form")) {
            $p_group = PGroups::lists('name', 'id');
            $forms = EmsForm::where('type', '=', 'enumerator')->lists('name', 'id');
            return view('forms/create', compact('p_group', 'forms'));
        } else {
            return view('errors/403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
        if ($this->auth_user->can("create.form")) {
            $this->validate($request, ['name' => 'required|unique:ems_forms', 'descriptions' => 'required']);
            $input = $request->all();
            $form['name'] = $input['name'];
            $form['type'] = $input['type'];
            $form['descriptions'] = $input['descriptions'];
            $form['pgroup_id'] = $input['p_group'];
            $form['no_of_answers'] = $input['no_of_answers'];
            $form['start_date'] = date('Y-m-d', strtotime($input['start_date']));
            $form['end_date'] = date('Y-m-d', strtotime($input['end_date']));

            if($input['type'] == 'spotchecker'){
                $form['enu_form_id'] = $input['enumerator_form'];

            }
            //return $form;
            $forms = EmsForm::create($form);
            return redirect('forms');
        } else {
            return view('errors/403');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($form_name_url)
    {
        //
        $form_name = urldecode($form_name_url);

        $form = EmsForm::where('name', '=', $form_name)->get();
        //return $form->toArray();
        $form_array = $form->toArray();
        if (empty($form_array)) {
            $form = EmsForm::find($form_name_url);
            $id = $form->id;
            $form_name = $form->name;
            $form_answers_count = $form->no_of_answers;
        } elseif (!empty($form_array)) {
            $id = $form->first()['id'];
            $form_answers_count = $form->first()['no_of_answers'];
        } else {
            return redirect('forms');
        }
        //$single = EmsFormQuestions::Single();
        //return print_r($single->get());
        //$questions = EmsFormQuestions::ofFormID($id)->singlemain()->idAscending()->paginate(30);

        if ($form_answers_count == 0 || empty($form_answers_count)) {
            $form_answers_count = GeneralSettings::options('options', 'answers_per_question');
        }

        $questions = EmsFormQuestions::OfSingleMain($id)->idAscending()->paginate(30);

        return view('forms/view', compact('questions', 'id', 'form_answers_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($form_name_url)
    {
        //
        $form_name = urldecode($form_name_url);

        $form = EmsForm::where('name', '=', $form_name)->get();
        //return $form->toArray();
        $form_array = $form->toArray();
        if (empty($form_array)) {
            $form = EmsForm::find($form_name_url);
            $id = $form->id;
            $form_name = $form->name;
        } elseif (!empty($form_array)) {
            $id = $form->first()['id'];
        } else {
            return redirect('forms');
        }
        $form = EmsForm::find($id);
        $forms = EmsForm::where('type', '=', 'enumerator')->lists('name', 'id');
        $p_group = PGroups::lists('name', 'id');
        return view('forms/edit_form', compact('form', 'p_group', 'forms'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($form_name_url, Request $request)
    {
        //
        $form_name = urldecode($form_name_url);

        $getform = EmsForm::where('name', '=', $form_name)->get();
        //return $form->toArray();
        $form_array = $getform->toArray();
        if (empty($form_array)) {
            $getform = EmsForm::find($form_name_url);
            $id = $getform->id;
            $form_name = $getform->name;
        } elseif (!empty($form_array)) {
            $id = $getform->first()['id'];
        } else {
            return redirect('forms');
        }
        //return $id;
        $input = $request->all();
        //return $input;
        $message = array(
            'no_of_answers.max' => 'Answers per question may not greater than 20. You are setting ' . $input['no_of_answers'] . ' per question',
        );
        $this->validate($request, ['name' => 'required', 'no_of_answers' => 'Integer|max:20'], $message);
        //$input = $request->all();
        $form['name'] = $input['name'];
        $form['type'] = $input['type'];

        $form['descriptions'] = $input['descriptions'];
        $form['pgroup_id'] = $input['p_group'];
        $form['no_of_answers'] = $input['no_of_answers'];
        $form['start_date'] = date('Y-m-d', strtotime($input['start_date']));
        $form['end_date'] = date('Y-m-d', strtotime($input['end_date']));
        //return $form;
        if($input['type'] == 'spotchecker'){
            $form['enu_form_id'] = $input['enumerator_form'];

        }
            $new_forms = EmsForm::findOrFail($id);
            $new_forms->update($form);


        return redirect('forms');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param $form_name_url
     * @return Response
     * @internal param int $id
     */
    public function destroy($form_name_url)
    {
        //
        $form_name = urldecode($form_name_url);

        $form = EmsForm::where('name', '=', $form_name)->get();
        //return $form->toArray();
        $form_array = $form->toArray();
        if (empty($form_array)) {
            $form = EmsForm::find($form_name_url);
            $id = $form->id;
            $form_name = $form->name;
        } elseif (!empty($form_array)) {
            $id = $form->first()['id'];
        } else {
            return redirect('forms');
        }
        $form = EmsForm::find($id);
        $has_child = $form->questions->toArray();
        if (!empty($has_child)) {
            $message = 'Form ' . $form->name . ' cannot be deleted! Form is not empty. Delete questions and data before deleting this form.';
            \Session::flash('form_error', $message);

            return redirect('forms');
        }


        $form->delete();
        $message = 'Form ' . $form->name . ' deleted!';


        \Session::flash('form_success', $message);

        return redirect('forms');
    }

    public function qdestroy($id)
    {
        //
        $question = EmsFormQuestions::find($id);

        $question->delete();
        $message = 'Question ' . $question->question . ' deleted!';


        \Session::flash('flash_message', $message);

        return redirect('forms/' . $id);
    }


}
