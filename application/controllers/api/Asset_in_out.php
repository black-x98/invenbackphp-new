<?php

require APPPATH . 'libraries/REST_Controller.php';

class Asset_in_out extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_check_in_out');
    }

    public function index_get($id = null)
    {
        $result = array('data' => array());

        $data = $this->model_check_in_out->getCheckInOutData($id);
        if($id)
            $data = array($data);
        $result = array();

        foreach ($data as $key => $value) {
            $tmp = new check_in_out_response();
            $tmp->sku = $value['sku'];
            $tmp->type = $value['request_type'];
            $tmp->id = $value['id'];
            $tmp->status = $value['status'];

            array_push($result, $tmp);
        }

        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $input = $this->post();

        $data = array(
            'sku' => $this->post('sku'),
            'request_type' => $this->post('request_type'),
            'status' => 'pending'
        );

        $create = $this->model_check_in_out->create($data);
        if($create == true) {
            $msg = "Check In/Out request submitted successfully.";
            $this->response($msg, REST_Controller::HTTP_OK);
        }
        else {
            $msg = "Unable to insert the request";
            $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index_delete($id)
    {
        $delete = $this->model_check_in_out->remove($id);
        if ($delete) {
            $msg = "Check in/out request deleted successfully.";
            $this->response($msg, REST_Controller::HTTP_OK);
        } else {
            $msg = "Error. Try Again later";
            $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

class check_in_out_response {

}