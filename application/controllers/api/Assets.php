<?php

require APPPATH . 'libraries/REST_Controller.php';

class Assets extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_products');
        $this->load->model('model_brands');
        $this->load->model('model_category');
        $this->load->model('model_stores');
        $this->load->model('model_attributes');
    }

    public function index_get($id = null)
    {
        $result = array('data' => array());

        $data = $this->model_products->getProductData($id);
        if($id)
            $data = array($data);
        $result = array();
        
        foreach ($data as $key => $value) {
            $tmp = new asset_response();
            $store_data = "dummystore";//$this->model_stores->getStoresData($value['store_id']);
            $tmp->sku = $value['sku'];
            $tmp->name = $value['name'];
            $tmp->price = $value['price'];;
            $tmp->quantity = $value['qty'];
            $tmp->store_name = "dummystore";
            $tmp->availability = $value['availability'];
            $tmp->status = $value['status'];
            $tmp->request_type = $value['request_type'];
            //print_r($store_data['name']);
            //print("\n");
            array_push($result, $tmp);
        }

        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'name' => $this->input->post('product_name'),
                'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                'brand_id' => json_encode($this->input->post('brands')),
                'category_id' => json_encode($this->input->post('category')),
                'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
                'request_type' => $this->input->post('request_type'),
                'status' => $this->input->post('status'),
            );

            $create = $this->model_products->create($data);
            if($create == true) {
                $msg = "Asset inserted successfully.";
                $this->response($msg, REST_Controller::HTTP_OK);
            }
            else {
                $msg = "Unable to insert the asset";
                $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        else {
            $msg = "Invalid parameters";
            $this->response($msg, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put($asset_id)
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

        $update = $this->model_products->update($input, $asset_id);
        if ($update) {
            $msg = "Asset updated successfully.";
            $this->response($msg, REST_Controller::HTTP_OK);
        } else {
            $msg = "Invalid Input.";
            $this->response($msg, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete($asset_id)
    {
        $delete = $this->model_products->remove($asset_id);
        if ($delete) {
            $msg = "Asset deleted successfully.";
            $this->response($msg, REST_Controller::HTTP_OK);
        } else {
            $msg = "Error. Try Again later";
            $this->response($msg, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

class asset_response {

}
