<?php
use App\EmsForm;
use App\EmsFormQuestions;
use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use App\User as User;
 
class EmsFormQuestionsTableSeeder extends Seeder {

    /**
     *
     */
    public function run() {

        $form = EmsForm::create([
            'name' => 'Survey Form',
            'pgroup_id' => 1,
            'no_of_answers' => 10
        ]);

        $question1 = EmsFormQuestions::create( [
                    'form_id' => $form->id,
                    'list_id' => 1,
                    'question_number' => 'Q1',
                    'question' => 'Are you the head of the household?',
                    'q_type' => 'single',
                    'input_type' => 'radio',
                    'a_view' => '',
                    'answers' => array('1' => 'Yes', '2' => 'No', '-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question2 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 2,
            'question_number' => 'Q2',
            'question' => 'Here is a list of groups and organizations; I’d like you to tell me if you have often, sometimes, or never participated in the following types of meetings or activities over the past year.',
            'q_type' => 'main',
            'input_type' => 'same',
            'a_view' => '',
            'answers' => array('1' => 'Often', '2' => 'Sometime', '3' => 'Never', '-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question3 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 3,
            'parent_id' => $question2->id,
            'question_number' => '(a)',
            'question' => 'Cultural Groups',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question4 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 4,
            'parent_id' => $question2->id,
            'question_number' => '(b)',
            'question' => 'Sports Groups',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question5 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 5,
            'parent_id' => $question2->id,
            'question_number' => '(c)',
            'question' => 'Worker Associations',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question6 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 6,
            'parent_id' => $question2->id,
            'question_number' => '(d)',
            'question' => 'Community Development Groups',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question7 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 7,
            'parent_id' => $question2->id,
            'question_number' => '(e)',
            'question' => 'Other Gatherings.Please indicate what kind of other gatherings they attend:',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => 'categories',
            'answers' => array(),

        ] );

        $question8 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 8,
            'question_number' => 'Q3',
            'question' => 'How interested would you say you are in politics?  ',
            'q_type' => 'single',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array('1' => 'Very interested', '2' => 'Somewhat interested', '3' => 'Not very interested','4' => 'Not interested at all','-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question9 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 9,
            'question_number' => 'Q4',
            'question' => 'In many countries, independent groups observe elections. Have you heard of this?',
            'q_type' => 'single',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array('1' => 'Yes', '2' => 'No', '-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question10 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 10,
            'question_number' => 'Q5',
            'question' => 'Sometimes, international groups observe elections. Do you think that the involvement of international observers helps guarantee transparent elections? ',
            'q_type' => 'single',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array('1' => 'Very helpful', '2' => 'They can help a little', '3' => 'I doubt they can help','4' => 'It is of no use at all','-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );
        $question11 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 11,
            'question_number' => 'Q6',
            'question' => 'Sometimes, national groups observe the elections. Do you think the involvement of national observers helps guarantee transparent elections?',
            'q_type' => 'single',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array('1' => 'Very helpful', '2' => 'They can help a little', '3' => 'I doubt they can help','4' => 'It is of no use at all','-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question12 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 12,
            'question_number' => 'Q7',
            'question' => 'Do you expect unrest or violence to occur in connection with election process?',
            'q_type' => 'single',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array('1' => 'Yes', '2' => 'No', '-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question13 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 13,
            'question_number' => 'Q8',
            'question' => 'On a scale of 1 to 5 where ‘1’ means “not important at all” and ‘5’ means “very important," how important are the following things for an election to be run well… ',
            'q_type' => 'main',
            'input_type' => 'same',
            'a_view' => '',
            'answers' => array('1' => '1 (not important)', '2' => '2', '3' => '3' , '4' => '4', '5' => '5 (Very important)', '-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );

        $question14 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 14,
            'parent_id' => $question13->id,
            'question_number' => '(a)',
            'question' => 'Ballot is secret',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question15 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 15,
            'parent_id' => $question13->id,
            'question_number' => '(b)',
            'question' => 'Election commission is neutral',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question16 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 16,
            'parent_id' => $question13->id,
            'question_number' => '(c)',
            'question' => 'There is no fraud',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question17 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 17,
            'parent_id' => $question13->id,
            'question_number' => '(d)',
            'question' => 'The votes are counted properly',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question18 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 18,
            'parent_id' => $question13->id,
            'question_number' => '(e)',
            'question' => 'The correct results are announced',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

        $question19 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 19,
            'parent_id' => $question13->id,
            'question_number' => '(f)',
            'question' => 'Every party has an equal chance to campaign',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );
        $question20 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 20,
            'parent_id' => $question13->id,
            'question_number' => '(g)',
            'question' => 'Voters are free from intimidation or pressure',
            'q_type' => 'sub',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );
        $question21 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 21,
            'question_number' => 'Q9',
            'question' => 'Whose opinion do you think matters most, when it comes to deciding whether elections have been run well?  Please pick up to three.',
            'q_type' => 'main',
            'input_type' => 'same',
            'a_view' => 'validated-table',
            'answers' => array('1' => 'The party I support', '2' => 'Independent election observers',
                '3' => 'Foreign governments', '4' => 'The Myanmar Government', '5'=> 'The Election Commission',
                '6'=>'My own opinion', '7' => 'Opinion of the average citizen' ,'-8' => 'Don\'t Know', '-9' => 'Refuse to answer'),

        ] );
        $question22 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 22,
            'parent_id' => $question21->id,
            'question_number' => '(a)',
            'question' => '1st Mention',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );
        $question23 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 23,
            'parent_id' => $question21->id,
            'question_number' => '(b)',
            'question' => '2nd Mention',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );
        $question24 = EmsFormQuestions::create( [
            'form_id' => $form->id,
            'list_id' => 24,
            'parent_id' => $question21->id,
            'question_number' => '(c)',
            'question' => '3rd Mention',
            'q_type' => 'same',
            'input_type' => 'radio',
            'a_view' => '',
            'answers' => array(),

        ] );

    }
}