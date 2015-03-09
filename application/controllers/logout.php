<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		session_start();
		$this->session->sess_destroy();
		redirect('/login','refresh');
	}

}