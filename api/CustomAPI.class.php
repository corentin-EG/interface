<?php 

require_once 'RestAPI.class.php';

class CustomAPI extends RestAPI
{
    protected $User;


    public function __construct($request, $origin, PDO $db) {
        parent::__construct($request, $db);
        // var_dump($this->method, $this->endpoint, $this->args, $this->verb, $this->file);

        // if (!array_key_exists('apiKey', $this->request)) 
        // {
        //     throw new Exception('No API Key provided');
        // } 
        // else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) 
        // {
        //     throw new Exception('Invalid API Key');
        // } 
        // else if (array_key_exists('token', $this->request) &&
        //      !$User->get('token', $this->request['token'])) 
        // {
        //     throw new Exception('Invalid User Token');
        // }
    }

    protected function projects() {
        if ($this->method == 'GET') {
            $projectManager = new ProjectManager($this->db);
            if (isset($this->args[1])) {
                $output = $projectManager->get($this->args[1]);
            } else {
                $output = $projectManager->getAll();
            }
            return $output;
            // throw new Exception("GET method on $this->endpoint still not implemented");
        } else if ($this->method == 'POST') {
            if (array_key_exists(PROJECTS, $this->request)) {
                $data = json_decode($this->request[PROJECTS], true);
                $projectManager = new ProjectManager($this->db);
                return $projectManager->add($data);
            }
            throw new Exception("Invalid key parameters.");
        } else {
            throw new Exception("No endpoint for this method.");
        }
    }

    protected function objects() {
        if ($this->method == 'GET') {
            $objectManager = new ObjectManager($this->db);
            if (isset($this->args[1]) && is_numeric($this->args[1])) {
                $output = $objectManager->getAllFromProject($this->args[1]);
            } else if (isset($this->arg[0])) {
                $output = $objectManager->get($this->arg[0]);
            } else {
                throw new Exception("No endpoint for this method.");
            }
            return $output;
        } else if ($this->method == 'POST') {
            if (array_key_exists(OBJECTS, $this->request)) {
                $data = json_decode($this->request[OBJECTS], true);
                $objectManager = new ObjectManager($this->db);
                $list = array();
                foreach ($data as $obj) {
                    $obj['project_id'] = $this->args[1];
                    $list[] = $objectManager->add($obj);
                }
                return $list;
            }
            throw new Exception("Invalid key parameters.");
        } else {
            throw new Exception("No endpoint for this method.");
        }
    }

    protected function assets() {
        if ($this->method == 'GET') {
            $assetManager = new AssetManager($this->db);
            if (isset($this->args[1]) && is_numeric($this->args[1])) {
                $output = $assetManager->getAllFromObjects($this->args[1]);
            } else if (isset($this->args[0])) {
                $output = $assetManager->get($this->args[0]);
                // foreach ($output)
            } else {
                throw new Exception("No endpoint for this method.");
            }
            return $output;
        } else if ($this->method == 'POST') {
            $data = $this->request;
            $assetManager = new AssetManager($this->db);
            $file = new File($this->file);
            $data['url'] = $file->moveOnServer($data['version']);
            return $assetManager->add($data);
        } else {
            throw new Exception("No endpoint for this method.");
        }
    }
 }