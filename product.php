<?php

class ControllerExtensionModuleMyproduct extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/product');

        $this->load->model('catalog/product');

        $this->load->getList();
    }

    public function getList() {

        $data = array();
        
        if (isset($this->request->get['filter_model'])) {
            $data['filter_model'] = $this->request->get['filter_model'];
        } else {
            $data['filter_model'] = 0;
        }
    }


}