<?php

class ControllerExtensionModuleApp2 extends Controller {
    public function index() {

        $this->load->language('catalog/product');

        $this->load->model('catalog/product');

        $this->load->model('catalog/category');

        $data = array();
        $data['test'] = 'test';
        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/view2'), $data);
    }
}