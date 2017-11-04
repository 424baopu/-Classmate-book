<?php
/**
* 
*/
class auth_model extends CI_model
{
	
	function __construct()
	{
		# code...
	}


	function search($data)
	{

		$query = $this->db->get_where('student',$data);
		//echo $query->num_rows();
		return $query;
		/*
		if($query->num_rows() > 0)
		{
			return 0;

		}
		else
		{
			return 1;
		}
		*/
	
	}

	function add($data)
	{
		$query = $this->db->insert('student',$data);
		return $query? $this->db->insert_id():false;
	}
}

?>