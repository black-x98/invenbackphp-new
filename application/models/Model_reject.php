<?php 

class Model_reject extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* update request to mark as rejected */
	public function rejectRequest($data = null)
	{
		if($data) {
			$sql = "UPDATE products
SET status = 'rejected'
WHERE name = ?;";
			$query = $this->db->query($sql, $data);
			return $query;
		}

		else{
			print("rejecting item failed");
			return null;
		}
	}

}
