<?php

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_users');
        $this->load->model('model_groups');
    }

    public function index_get($id = null)
    {
        $result = array('data' => array());

        $data = $this->model_users->getUserData($id);
        if($id)
            $data = array($data);
        $result = array();
        
        foreach ($data as $key => $value) {
            $tmp = new user_response();
            $group_data = $this->model_groups->getGroupData($value['id']);
            $tmp->username = $value['username'];
            $tmp->email = $value['email'];
            $tmp->password = $value['password'];
            $tmp->firstname = $value['firstname'];
            $tmp->lastname = $value['lastname'];
            $tmp->user_group = $value['user_group'];
            $tmp->phone = $value['phone'];
            $tmp->gender = $value['gender'];
            //print_r($group_data);
            //$tmp->group_name = $group_data['group_name'];
            array_push($result, $tmp);
            $this->response($group_data, REST_Controller::HTTP_OK);
        }

        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'lastname', 'trim|required');
        $this->form_validation->set_rules('user_group', 'User Group', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'user_group' => $this->input->post('user_group'),
                'phone' => $this->input->post('phone'),
                'supervisor' => $this->input->post('supervisor'),
                
            );

            $create = $this->model_users->create($data);
            if($create == true) {
                $msg = "User inserted successfully.";
                $this->response($msg, REST_Controller::HTTP_OK);
            }
            else {
                $msg = "Unable to insert the user";
                $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        else {
            $msg = "Invalid parameters";
            $this->response($msg, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put($user_id)
    {
        $input = $this->put();
        $data = array();
        if (isset($input['product_name'])) {
            $input['name'] = $input['product_name'];
            unset($input['product_name']);
        }
        if (isset($input['brands'])) {
            $input['brand_id'] = $input['brands'];
            unset($input['brands']);
        }
        if (isset($input['category'])) {
            $input['category_id'] = $input['category'];
            unset($input['category']);
        }
        if (isset($input['store'])) {
            $input['store_id'] = $input['store'];
            unset($input['store']);
        }

        $update = $this->model_products->update($input, $user_id);
        if ($update) {
            $msg = "User updated successfully.";
            $this->response($msg, REST_Controller::HTTP_OK);
        } else {
            $msg = "Invalid Input.";
            $this->response($msg, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete($user_id)
    {
        $delete = $this->model_products->remove($user_id);
        if ($delete) {
            $msg = "User deleted successfully.";
            $this->response($msg, REST_Controller::HTTP_OK);
        } else {
            $msg = "Error. Try Again later";
            $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

class user_response {

}
