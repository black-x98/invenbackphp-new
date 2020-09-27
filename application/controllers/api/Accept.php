<?php

require APPPATH . 'libraries/REST_Controller.php';

class Accept extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_accept');
    }

    public function index_post()
    {
    	$data = array(
    		'name' => $this->input->post('product_name')
    	);
    	
        $result = $this->model_accept->acceptRequest($data);

        $this->response($result, REST_Controller::HTTP_OK);
    }

    
}

class accept_response {

}
