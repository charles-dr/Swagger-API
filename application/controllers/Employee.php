<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model', 'EMPLOYEE');
    }

    /**
     * @name index
     * @description default page or response
     * @param none
     * @returns
    */
    public function index() {
        echo 'default'; exit;
    }

    public function getEmployeeList() {
        $key = $this->general->generateKey(32, 8);
        echo $key;
    }

    public function getEmployee($idx) {
        $valid = $this->general->checkApiKeyValid('1752-0180-4dd1-9623-4c27-c887-44f8-3d7d');
        $valid = $this->general->checkApiSecretValid('ec6d7f9d-810f8899-16d112ea-ace78281');
        http_response_code(201);
        echo $valid;
    }

    public function insertEmployee() {
        echo 'insert';
    }

    public function updateEmployee() {
        echo 'update';
    }

    public function deleteEmployee() {
        echo 'delete';
    }
}
