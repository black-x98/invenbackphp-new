<?php

require APPPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_login');
    }

    public function index_post()
    {
    	$data = array(
    		'email' => $this->input->post('email'),
    		'password' => $this->input->post('password')
    	);
    	
        $result = $this->model_login->getLoginData($data);

        $this->response($result, REST_Controller::HTTP_OK);
    }

    
}

class user_response {

}
