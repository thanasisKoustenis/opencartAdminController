<?php
class ControllerExtensionModuleProductapp extends Controller {

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

        $data['results_amount'] = sizeof($results);

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

            $row_count ++;
        }

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'=> $this->language->get('text_home'),
            'href'=> $this->url->link('common/dashboard' . '&user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text'=> $this->language->get('heading_title'),
            'href'=> $this->url->link('extension/module/productapp' . '&user_token=' . $this->session->data['user_token'], true)
        );

        $data['add'] = $this->url->link('extension/module/productapp/add' . '&user_token=' . $this->session->data['user_token'], true);

        $this->response->setOutput($this->load->view('extension/module/productapp', $data)); 
    }

    public function add() {
        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('text_add'));

        $this->load->model('catalog/product');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $this->model_catalog_product->addProduct($this->request->post);

            $this->response->redirect($this->url->link('extension/module/productapp', 'user_token=' . $this->session->data['user_token'], true));
        }

        $this->getForm();
    }

    public function getForm() {

        $data= array();

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $data['title'] = $this->language->get('text_add');

        $data['breadcrumbs'][] = array(
            'text'=> $this->language->get('text_home'),
            'href'=> $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text'=> $this->language->get('heading_title'),
            'href'=> $this->url->link('extension/module/productapp', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text'=> $this->language->get('text_add'),
            'href'=> $this->url->link('extension/module/productapp/add', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (!isset($this->request->get['product_id'])) {
            $data['action'] = $this->url->link('extension/module/productapp/add', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/productapp/edit', 'user_token=' . $this->session->data['user_token'], true);
        }

        if(isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } else {
            $data['name'] = '';
        }

        if(isset($this->request->post['tag'])) {
            $data['tag'] = $this->request->post['tag'];
        } else {
            $data['tag'] = '';
        }

        if(isset($this->request->post['meta_title'])) {
            $data['meta_title'] = $this->request->post['meta_title'];
        } else {
            $data['meta_title'] = '';
        }

        if(isset($this->request->post['model'])) {
            $data['model'] = $this->request->post['model'];
        } else {
            $data['model'] = '';
        }

        if(isset($this->request->post['price'])) {
            $data['price'] = $this->request->post['price'];
        } else {
            $data['price'] = '';
        }

        if(isset($this->request->post['quantity'])) {
            $data['quantity'] = $this->request->post['quantity'];
        } else {
            $data['quantity'] = '';
        }

        if(isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } else {
            $data['status'] = '';
        }
        

        $this->response->setOutput($this->load->view('extension/module/productappAdd', $data)); 
    }


}