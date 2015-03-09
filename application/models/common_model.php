<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
	function generate_random_string($length)
	{
		$dictionary = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$random_string = '';
		$default_length = 6 ;
		if(!is_numeric($length))
		{
			$length = $default_length;
		}
		for ($i = 0; $i < $length ; $i++) {
			$random_string .= $dictionary[rand(0, strlen($dictionary) - 1)];
		}
		return $random_string;
	}
}