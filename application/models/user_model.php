<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	function create($user)
	{
		$user['user_password'] = hash("sha256", $user['user_password'].$this->config->item('encryption_key'));
		$sql = $this->db->insert_string('ems_user',$user);
		$this->db->query($sql);
		return ($this->db->affected_rows() > 0 ? true : false);
	}

	function modify($user)
	{
		$where = "user_id='".$user['user_id']."'";
		$sql = $this->db->update_string('ems_user',$user,$where);
		$this->db->query($sql);
		return ($this->db->affected_rows() > 0 ? true : false);
	}

	function delete($user_id)
	{
		$sql = "DELETE FROM ems_user WHERE user_id='".$user_id."'";
		$this->db->query($sql);
		return ($this->db->affected_rows() > 0 ? true : false);
	}

	function check_id($user_id)
	{
		$sql = "SELECT * FROM ems_user WHERE user_id='".$user_id."' LIMIT 1";
		$query = $this->db->query($sql);
		return ($query->num_rows > 0 ? true : false);
	}

	function get_data_by_id($user_id)
	{
		$sql = "SELECT * FROM ems_user, ems_user_group WHERE ems_user.user_group=ems_user_group.user_group_id AND user_id='".$user_id."'";
		return $this->db->query($sql);
	}

	function get_data_by_email_address($user_email_address)
	{
		$sql = "SELECT * FROM ems_user, ems_user_group WHERE ems_user.user_group=ems_user_group.user_group_id AND user_email_address='".$user_email_address."'";
		return $this->db->query($sql);
	}

	function get_data($keyword, $permission, $start=null,$offset=null)
	{
		$table = "ems_user,ems_user_group";
		$where = " WHERE ems_user.user_group=ems_user_group.user_group_id ";

		if(isset($keyword) && $keyword != "")
		{
			$where .= "AND (ems_user.user_id LIKE '".$keyword."%' OR ems_user.user_id LIKE '%".$keyword."%' OR ems_user.user_id LIKE '%".$keyword."' OR user_name LIKE '".$keyword."%' OR user_name LIKE '%".$keyword."%' OR user_name LIKE '%".$keyword."' OR user_group_name LIKE '".$keyword."%' OR user_group_name LIKE '%".$keyword."%' OR user_group_name LIKE '%".$keyword."') ";
		}

		$where .= "ORDER BY ems_user.user_name ";
		if(isset($start))
			$where .= "LIMIT ".$start.", ".$offset;
		$sql = "SELECT * FROM ".$table.$where;
		return $this->db->query($sql);
	}

	function verify_login($user_email_address, $user_password)
	{
		$user_password = hash("sha256", $user_password.$this->config->item('encryption_key'));
		$sql = "SELECT * FROM ems_user WHERE user_email_address='".$user_email_address."' AND user_password='".$user_password."' LIMIT 1";
		$query = $this->db->query($sql);
		return ($query->num_rows > 0 ? true : false);
	}

}