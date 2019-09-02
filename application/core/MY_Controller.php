<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Europe/London');
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class MY_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('Auth_model', 'AUTH');
        $this->checkAuthentication();
	}

	private function checkAuthentication() {
        $auth_header_type = $this->general->getAuthHeaderType();
        if ($auth_header_type == 'Basic') {
            $credential_arr = $this->general->getBasicAuthHeader();

            // get API key and secret
            $api_key = $credential_arr[0];
            $api_secret = $credential_arr[1];

            // check validity of api key and secret
            $api_key_valid = $this->general->checkApiKeyValid($api_key);
            $api_secret_valid = $this->general->checkApiSecretValid($api_secret);
            $valid_credential = $this->AUTH->checkCredential($api_key, $api_secret);

            // api key is invalid
            if (!$api_key_valid) {
                $response = [
                    'status'   => false,
                    'message'   => 'Invalid API Key Format!'
                ];
                $this->_returnJson($response, 401);
            }
            // api secret is invalid
            else if (!$api_secret_valid) {
                $response = [
                    'status'    => false,
                    'message'   => 'Invalid API Secret Format!'
                ];
                $this->_returnJson($response, 401);
            }
            // api credentials not exist
            else if (!$valid_credential) {
                $response = [
                    'status'    => false,
                    'message'   => 'Invalid Credentials'
                ];
                $this->_returnJson($response, 401);
            }
            // api key exists but not activated
            else if ($valid_credential && $valid_credential->status == 'PENDING') {
                $response = [
                    'status'    => false,
                    'message'   => 'Credentials Not Activated'
                ];
                $this->_returnJson($response, 403);
            }
            // now api credentials are okay for next step
            else {

            }
        }
        else if ($auth_header_type == 'Bearer') {
            echo 'token';
        }
    }

    protected  function _returnJson($data, $http_code = 200,  $exit = true){
        header('Content-Type: application/json');
        http_response_code($http_code);
        echo json_encode($data);
        if ($exit) exit;
    }

    protected  function _getJsonRequest($returnArray = true){
        $data = json_decode(file_get_contents('php://input'), $returnArray);
        return $data;
    }

    protected function _debug($data, $exit = true){
        echo '<pre>';
        print_r($data);
        if ($exit) exit;
    }
}
