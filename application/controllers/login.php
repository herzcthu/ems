<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{

	public function index()
	{
		session_start();

		//variable declaration
		$data['page_title'] = lang('common_login').' | '.lang('common_website_name');

		//check login
		$temp_value = $this->session->userdata(md5('ems_user_login'));
		if($temp_value != '' && $temp_value == true)
			redirect('/dashboard','refresh');

		//check form post
		if(isset($_POST['user_email_address']))
		{
			$this->form_validation->set_rules('user_email_address',lang('common_email_address'),'trim|required|xss_clean');
			$this->form_validation->set_rules('user_password',lang('common_password'),'trim|required|xss_clean');
			$this->form_validation->set_rules('verify_login','verify_login','callback__verify_login');

			if($this->form_validation->run() == true)
			{
				$user_data = $this->User_model->get_data_by_email_address($_POST['user_email_address'])->row_array();
				$image_extension = array(".png",".jpg",".jpeg",".PNG",".JPG",".JPEG");
				foreach ($image_extension as $extension) 
				{
					if (strpos($user_data['user_image'], $extension) !== false)
					{
						$user_data['user_image'] = str_replace($extension, "_50_thumb", $user_data['user_image']);
						$user_data['user_image'] .= $extension;
					}
				}
				$this->session->set_userdata(md5('ems_user_id'),$user_data['user_id']);
				$this->session->set_userdata(md5('ems_user_email_address'),$user_data['user_email_address']);
				$this->session->set_userdata(md5('ems_user_name'),$user_data['user_name']);
				$this->session->set_userdata(md5('ems_user_image'),$user_data['user_image']);
				$this->session->set_userdata(md5('ems_user_group'),$user_data['user_group']);
				$this->session->set_userdata(md5('ems_user_login'),true);
				redirect('/dashboard','refresh');
			}
		}

		//loading view
		$this->load->view('login_index_view',$data);
	}

	public function _verify_login($data_string)
	{
		if($this->User_model->verify_login($_POST['user_email_address'], $_POST['user_password']))
			return true;
		$this->form_validation->set_message('_verify_login',lang('common_login_error_invalid_credential'));
		return false;
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */