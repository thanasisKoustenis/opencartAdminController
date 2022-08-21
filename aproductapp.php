<?php

class ControllerExtensionModuleAproductapp extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product');

        $this->getList();
    }

    public function getList() {

        $data = array();
        $url = "";
        
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
            $url .= '&filter_name=' . urlencode(urldecode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        } else {
            $filter_name = '';
        }

        if (isset($this->request->get['filter_model'])) {
            $filter_model = $this->request->get['filter_model'];
            $url .= '&filter_model=' . urlencode(urldecode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        } else {
            $filter_model = '';
        }

        if (isset($this->request->get['filter_price'])) {
            $filter_price = $this->request->get['filter_price'];
            $url .= '&filter_price=' . $this->request->get['filter_price'];
        } else {
            $filter_price = '';
        }

        if (isset($this->request->get['filter_quantity'])) {
            $filter_quantity = $this->request->get['filter_quantity'];
            $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
        } else {
            $filter_quantity = '';
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        } else {
            $filter_status = '';
        }

        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_model' => $filter_model,
            'filter_price' => $filter_price,
            'filter_quantity' => $filter_quantity,
            'filter_status' => $filter_status
        );

        $results = $this->model_catalog_product->getProducts($filter_data);

        $data['products'] = array();

        $row_count = 0;

        while (isset($results[$row_count])) {

            $data['products'][$row_count] = array(
                'product_id' => $results[$row_count]['product_id'],
                'name' => $results[$row_count]['name'],
                'model' => $results[$row_count]['model'],
                'price' => $results[$row_count]['price'],
                'quantity' => $results[$row_count]['quantity'],
                'status' => $results[$row_count]['status']
            );

            $row_count = $row_count + 1;
        }

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        $data['test'] = "test";


        $this->response->setOutput($this->load->view('extension/module/aproductapp'), $data); 
    }


}