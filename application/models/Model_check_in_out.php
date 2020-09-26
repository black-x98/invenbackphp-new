<?php

class Model_check_in_out extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* get the brand data */
    public function getCheckInOutData($id = null)
    {
        if($id) {
            $sql = "SELECT * FROM check_in_out where id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM check_in_out ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data)
    {
        if($data) {
            $insert = $this->db->insert('check_in_out', $data);
            return ($insert == true) ? true : false;
        }
    }

    public function update($data, $id)
    {
        if($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('check_in_out', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('check_in_out');
            return ($delete == true) ? true : false;
        }
    }

}