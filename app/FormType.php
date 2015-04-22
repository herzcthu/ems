<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model {

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'form_type';


    protected $fillable = ['form_id', 'question_id'];

}
