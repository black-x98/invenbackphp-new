<?php

require APPPATH . 'libraries/REST_Controller.php';

class Reject extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_reject');
    }

    public function index_post()
    {
    	$data = array(
    		'name' => $this->input->post('product_name')
    	);
    	
        $result = $this->model_reject->rejectRequest($data);

        $this->response($result, REST_Controller::HTTP_OK);
    }

    
}

class reject_response {

}
