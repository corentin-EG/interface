<?php

abstract class RestAPI
{

    protected $method = '';

    protected $endpoint = '';

    protected $verb = '';

    protected $args = Array();

    protected $file = Null;

    protected $db = '';

    

    public function __construct($request, PDO $db) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        define('PROJECTS', 'jsonProject');
        define('OBJECTS', 'jsonObject');
        define('ASSETS', 'jsonAsset');
        define('USERS', 'jsonUser');
        define('PLUGINS', 'jsonPlugin');

        $this->db = $db;
        $this->args = explode('/', rtrim($request, '/'));
        if (array_key_exists(1, $this->args) && !is_numeric($this->args[1]))
            throw new Exception("Invalid ID provided for ".$this->args[0]." endpoint.");

        $this->endpoint = count($this->args) != 3 ? array_shift($this->args) : end($this->args);


        // $asset = json_decode($_POST[ASSETS], true);
        // $content = file_get_contents('../model/deliveroo.png');
        // $test = bin2hex($content);
        // $yo = str_split($test, 4);
        // var_dump($yo);
        // $toto = implode('', $yo);
        // $tata = pack('H*', $toto);
        // $handle = fopen('../test_binary_file.png', "r+");
        // fwrite($handle, $tata);

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
        case 'DELETE':
        case 'POST':
            $this->request = $this->_cleanInputs($_POST);
            $this->file = isset($_FILES['data']) ? $_FILES['data'] : null;
            break;
        case 'GET':
            $this->request = $this->_cleanInputs($_GET);
            break;
        case 'PUT':
            $this->request = $this->_cleanInputs($_POST);
            $this->file = isset($_FILES['data']) ? $_FILES['data'] : null;
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
        // var_dump($this->method, $this->endpoint, $this->args, $this->request);
    }

    public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}());
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }

    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return $data;
    }

    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }
}