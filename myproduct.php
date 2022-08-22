<?php

class ControllerExtensionModuleMyproduct extends Controller
{

    public function index()
    {
        $this->load->language('catalog/product');

        $this->load->model('catalog/product');

        $this->load->model('catalog/category');


        $daata = array();



        // $data['products'] = $this->model_catalog_product->getProducts();
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        // $data['add'] = $this->url->link('extension/module/myproduct/addProduct', 'user_token=' . $this->session->data['user_token'], true);
        $data['add'] = $this->url->link('extension/module/myproduct/addProduct', 'user_token=' . $this->session->data['user_token'], true);
        $data['get'] = $this->url->link('extension/module/myproduct/getXMLProducts', 'user_token=' . $this->session->data['user_token'], true);
        $data['addXML'] = $this->url->link('extension/module/myproduct/addXMLProductDOM', 'user_token=' . $this->session->data['user_token'], true);
        $data['productsXML'] = $this->getXMLProducts();
        $data['test'] = "test";
        // $this->response->setOutput($this->load->view('product/product', $data));
        $this->response->setOutput($this->load->view('extension/module/myview', $data));
    }

    public function addXMLProduct()
    {

        $this->load->model('catalog/product');

        $inputFile = $this->request->post['xmlData'];

        $xmlDoc = new DOMDocument();
        $xmlDoc->load($inputFile);
        $xml = $xmlDoc->documentElement;
        $data = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            foreach ($xml->childNodes as $rows) {
                foreach ($rows->childNodes as $properties)
                    $data[$properties->nodeName] = $properties->nodeValue;
                // $data['product_id'] = $rows->nodeValue;
                // $data['model'] = $rows->nodeValue;
                // $data['product_id'] = $rows->nodeValue;
            }
        }

        print_r($data);

        $this->model_catalog_product->addProduct($data);

        $this->response->redirect($this->url->link('extension/module/myproduct', 'user_token=' . $this->session->data['user_token'], true));

        // $xmlFile = file_get_contents('inputdata2.xml');
        // $this->load->model('catalog/product');


        // // $postData = $this->request->post['product'];

        // if ($this->request->server['REQUEST_METHOD'] == 'POST') {

        //     // $postData = trim(file_get_contents('php://input'));

        //     $xml = simplexml_load_string($xmlFile);
        //     $data = array();

        //     foreach ($xml->children() as $rows) {
        //         $data['product_id'] = $rows['product_id'];
        //         $data['name'] = $rows['name'];
        //         $data['description'] = $rows['description'];

        //         $this->model_catalog_product->addProduct($data);
        //     }


        //     // if (isset($postData)) {


        //     // $xmlDoc = new DOMDocument();
        //     // $xmlDoc->load($postData);

        //     // foreach ($xmlDoc->childNodes as $item) {
        //     //     echo $item->nodeName . ' = ' . $item->nodeValue . '<br>';
        //     // }

        //     // $xml = simplexml_load_string($postData);

        //     // $array = array();
        //     // $array = $this->convertXMLtoArray($xml);
        //     // $data = array();

        //     // }

        //     $this->response->redirect($this->url->link('extension/module/myproduct', 'user_token=' . $this->session->data['user_token'], true));
        // }
    }


    public function addXMLProductSimpleXML()
    {
        // $postData = $this->request->post['xmlData'];
        $this->load->model('catalog/product');


        $xmldata = <<<XML
        <product>
        <product_id>1001</product_id>
        <name>Fender telecaster</name>
        <description>Electric guitar</description>
        <meta_title>sdf</meta_title>
        <meta_description> </meta_description>
        <meta_keyword> </meta_keyword>
        <tag></tag>
        <model>Product 3</model>
        <stock_status />
        <stock_status_id />
        <shipping />
        <product_description />
        <sku />
        <upc />
        <ean />
        <jan />
        <isbn />
        <mpn />
        <location />
        <quantity>7</quantity>
        <stock_status>2-3 Days</stock_status>
        <image>catalog/demo/canon_eos_5d_1.jpg</image>
        <manufacturer_id>9</manufacturer_id>
        <manufacturer>Canon</manufacturer>
        <price>500.0000</price>
        <special>80.0000</special>
        <reward>200</reward>
        <points>0</points>
        <tax_class_id>9</tax_class_id>
        <date_available>2009-02-03</date_available>
        <weight>0.00000000</weight>
        <weight_class_id>1</weight_class_id>
        <length>0.00000000</length>
        <width>0.00000000</width>
        <height>0.00000000</height>
        <length_class_id>1</length_class_id>
        <subtract>1</subtract>
        <rating>0</rating>
        <reviews>0</reviews>
        <minimum>1</minimum>
        <sort_order>0</sort_order>
        <status>1</status>
        <date_added>2009-02-03 16:59:00</date_added>
        <date_modified>2011-09-30 01:05:23</date_modified>
        <viewed>0</viewed>
        </product>
        
        XML;

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {


            $xml = simplexml_load_file('controller/extension/module/inputdata3.xml');
            // $xml = simplexml_load_string($xmldata) or die("Error: Cant create object");
            $data = array();

            // print_r($xml->children());

            // foreach ($xml->children() as $row) {
            foreach ($xml->children() as $item) {
                $data[$item->getName()] = $item->va;
                // $data['name'] = $item->name;
                // $data['model'] = $item->model;

                
            }

            print_r($data);

            $this->model_catalog_product->addProduct($data);
            // }
        }
    }

    public function addXMLProductDOM() {
        $this->load->model('catalog/product');


        $xmldata = <<<XML
        <product>
        <product_id>1001</product_id>
        <name>Fender telecaster</name>
        <description>Electric guitar</description>
        <meta_title>sdf</meta_title>
        <meta_description></meta_description>
        <meta_keyword></meta_keyword>
        <tag></tag>
        <model>Product 3</model>
        <stock_status></stock_status>
        <stock_status_id></stock_status_id>
        <shipping></shipping>
        <product_description></product_description>
        <sku></sku>
        <upc></upc>
        <ean></ean>
        <jan></jan>
        <isbn></isbn>
        <mpn></mpn>
        <location></location>
        <quantity>7</quantity>
        <stock_status>2-3 Days</stock_status>
        <image>catalog/demo/canon_eos_5d_1.jpg</image>
        <manufacturer_id>9</manufacturer_id>
        <manufacturer>Canon</manufacturer>
        <price>500.0000</price>
        <special>80.0000</special>
        <reward>200</reward>
        <points>0</points>
        <tax_class_id>9</tax_class_id>
        <date_available>2009-02-03</date_available>
        <weight>0.00000000</weight>
        <weight_class_id>1</weight_class_id>
        <length>0.00000000</length>
        <width>0.00000000</width>
        <height>0.00000000</height>
        <length_class_id>1</length_class_id>
        <subtract>1</subtract>
        <rating>0</rating>
        <reviews>0</reviews>
        <minimum>1</minimum>
        <sort_order>0</sort_order>
        <status>1</status>
        <date_added>2009-02-03 16:59:00</date_added>
        <date_modified>2011-09-30 01:05:23</date_modified>
        <viewed>0</viewed>
        </product>
        
        XML;

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $xmlDoc = new DOMDocument();
            $xmlDoc->load('controller/extension/module/inputdata3.xml');
            $x = $xmlDoc->documentElement;

            $data = array();

            foreach ($x->childNodes as $item) {
                $data[$item->nodeName] = $data[$item->nodeValue];
            }

            print_r($data);
            $this->model_catalog_product->addProduct($data);
        }
    }

    public function addProduct()
    {
        $this->load->model('catalog/product');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $data = array();
            $data['model'] = $this->request->post['model'];
            $data['model'] = $this->request->post['model'];
            $data['model'] = $this->request->post['model'];
            $this->model_catalog_product->addProduct($data);
            // $this->response->setOutput($this->load->view('extension/module/myview', $data));
            $this->response->redirect($this->url->link('extension/module/myproduct', 'user_token=' . $this->session->data['user_token'], true));
        }
        // $this->model_catalog_product->addProduct($data);
    }

    public function getXMLProducts()
    {
        $this->load->language('product/product');

        $this->load->model('catalog/product');

        $rowsData = $this->model_catalog_product->getProducts();

        return $this->makeXML($rowsData, 'products', 'product');

        // $data['prodXML'] = $this->makeXML($rowsData, 'products', 'product');
        // $data['index'] = $this->url->link('extension/module/myproduct', 'user_token=' . $this->session->data['user_token'], true);

        // $this->response->setOutput($this->load->view('extension/module/getProductsXML', $data));




    }

    public function getXMLCategories()
    {
        $this->load->model('catalog/category');

        $rowsData = $this->model_catalog_category->getCategories();

        echo $this->createXML($rowsData, 'categories', 'category');
    }

    public function getCategories()
    {

        $this->load->model('catalog/category');

        $rowsData = $this->model_catalog_category->getCategories();

        $data = array();
        $data['example'] = 'Hello';
        $data['example2'] = "Hey";
        $data['example3'] = $rowsData[0]['category_id'];
        $data['example4'] = "Good morning";
        $data['categories'][] = $rowsData;

        $this->response->setOutput($this->load->view('product/testview', $data));
    }

    public function convertXMLtoArray($xml)
    {

        $json = json_encode($xml);
        $array = json_decode($json, true);
        return $array;
    }

    public function createXML($rows, $xmlParent, $xmlChild)
    {

        // $this->load->language('product/product');

        // $this->load->model('catalog/category');

        $xml = new DOMDocument('1.0');
        $xml->formatOutput = true;
        $parentName = $xml->createElement("$xmlParent");
        $xml->appendChild($parentName);

        $row_num = 0;


        while (isset($rows[$row_num])) {

            $childName = $xml->createElement("$xmlChild");
            $parentName->appendChild($childName);

            foreach ($rows[$row_num] as $key => $value) {

                $colName = $xml->createElement("$key", $value);
                $childName->appendChild($colName);
            }
            $row_num = $row_num + 1;
        }

        return "" . $xml->saveXML() . "";
        $xml->save("products.xml");
    }

    public function makeXML($rows, $xmlParent, $xmlChild)
    {
        $xml = new DOMDocument('1.0');
        $xml->formatOutput = true;
        $parentName = $xml->createElement("$xmlParent");
        $xml->appendChild($parentName);

        $row_num = 0;


        foreach ($rows as $product_key => $row) {

            $childName = $xml->createElement("$xmlChild");
            $parentName->appendChild($childName);

            foreach ($row as $key => $value) {

                $colName = $xml->createElement("$key", $value);
                $childName->appendChild($colName);
            }
            $row_num = $row_num + 1;
        }

        $xml->save("exportProducts.xml");
        return "" . $xml->saveXML() . "";
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/account')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    // public function readXML($xml) {

    //     $rowProperties = array();
    //     $tableRows = array();
    //     $xmlDoc = new DOMDocument();
    //     $xmlDoc->load("inputdata.xml");
    //     $xml = $xmlDoc->documentElement;

    //     foreach ($xml->childNodes as $rows) {
    //         foreach ($rows as $key => $value) {
    //             $$rowProperties[$key] = $value;
    //         }
    //         $tableRows = 
    //     }

    // }
}
