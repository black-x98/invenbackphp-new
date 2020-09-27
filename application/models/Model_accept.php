<?php 

class Model_accept extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* update request to mark as accepted */
	public function acceptRequest($data = null)
	{
		if($data) {
			$sql = "UPDATE products
SET status = 'accepted'
WHERE name = ?;";
			$query = $this->db->query($sql, $data);
			return $query;
		}

		else{
			print("accepting item failed");
			return null;
		}
	}

}
