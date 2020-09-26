<?php 

class Model_login extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getLoginData($data = null)
	{
		if($data) {
			$sql = "SELECT * FROM users where email = ? and password = ?";
			$query = $this->db->query($sql, $data);
			return $query->row_array();
		}

		else{
			print("email and password not provided");
			return null;
		}
	}

}
