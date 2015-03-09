<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_group_model extends CI_Model
{

	function create($user_group)
	{
		$sql = $this->db->insert_string('ems_user_group',$user_group);
		$this->db->query($sql);
		return ($this->db->affected_rows() > 0 ? true : false);
	}

	function modify($user_group)
	{
		$where = "user_group_id=".$user_group['user_group_id'];
		$sql = $this->db->update_string('ems_user_group',$user_group,$where);
		$this->db->query($sql);
		return ($this->db->affected_rows() > 0 ? true : false);
	}

	function delete($user_group_id)
	{
		$sql = "DELETE FROM ems_user_group WHERE user_group_id=".$user_group_id;
		$this->db->query($sql);
		return ($this->db->affected_rows() > 0 ? true : false);
	}

	function check_id($user_group_id)
	{
		$sql = "SELECT * FROM ems_user_group WHERE user_group_id=".$user_group_id." LIMIT 1";
		return ($this->db->query($sql)->num_rows > 0 ? true : false);
	}

	function check_name($user_group_name)
	{
		$sql = "SELECT * FROM ems_user_group WHERE user_group_name='".$user_group_name."' LIMIT 1";
		return ($this->db->query($sql)->num_rows > 0 ? true : false);
	}

	function check_user_group_link_user($user_group_id)
	{
		$sql = "SELECT * FROM ems_user WHERE user_group=".$user_group_id;
		return ($this->db->query($sql)->num_rows > 0 ? true : false);
	}

	function get_data_by_id($user_group_id)
	{
		$sql = "SELECT * FROM ems_user_group WHERE user_group_id=".$user_group_id." LIMIT 1";
		return $this->db->query($sql);
	}

	function get_data($keyword = null, $start = null, $offset = null)
	{
		$sql = "SELECT DISTINCT * FROM ems_user_group ";
		if(isset($keyword) && $keyword != "")
			$sql .= " WHERE user_group_name LIKE '".$keyword."%' OR user_group_name LIKE '%".$keyword."%' OR user_group_name LIKE '%".$keyword."') ";
		if(isset($start))
			$sql .= "ORDER BY user_group_id LIMIT ".$start.", ".$offset;
		return $this->db->query($sql);
	}

	function get_permission_field()
	{
		$fields = $this->db->list_fields('ems_user_group');
		unset($fields[0]);
		unset($fields[1]);
		return $fields;
	}

}