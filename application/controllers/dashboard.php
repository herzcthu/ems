<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		session_start();

		//check login
		$temp_value = $this->session->userdata(md5('ems_user_login'));

		print_r($this->session->all_userdata());

		if($temp_value == '' || $temp_value == false)
			redirect('/login','refresh');

		$data['page_title'] = lang('common_dashboard');
		

	}

	public function ajax()
	{
		session_start();

		//check login
		$temp_value = $this->session->userdata(md5('nld_member_login'));

		if($temp_value != '' && isset($_POST['request_type']))
		{
			if($_POST['request_type'] == 'location')
			{
				$function = $_POST['request_data'];
				$query = $this->Location_model->{$function}($_POST['support_value']);
			}
			$temp_array = $query->result_array();
			if(isset($_POST['request_header']))
				array_unshift($temp_array, array($_POST['request_header']."_id" => "", $_POST['request_header']."_name"=>lang('common_select_'.$_POST['request_header'])));
			echo json_encode($temp_array);
			die();
		} 
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */