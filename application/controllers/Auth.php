<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Auth extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'AUTH');
        $this->load->model('Employee_model', 'EMPLOYEE');
    }

    /**
     * @name index
     * @description default page or response
     * @param none
     * @returns
    */
    public function index() {
        $response = [
            'status'    => false,
            'message'   => 'Welcome to XXX service. Please check the url for more information',
            'url'       => 'url goes here.'
        ];
        $this->_returnJson($response, 200);
    }


    public function generateToken() {
        $header_type = $this->general->getAuthHeaderType();
        if ($header_type == 'Basic') {
            $key = "example_key";

            // claims:  iss (issuer), exp (expiration time), sub (subject), aud (audience), and others.
            $token = [
                'iss'   => 'http://exmaple.org',    // issuer
                'aud'   => 'http:/example.com',     // audience
                'iat'   => 1356999524,              // issued at time
                'nbf'   => 1357000000               // not before time
            ];
            $jwt = JWT::encode($token, $key);
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $response = [
                'status'    => true,
                'token'     => $jwt,
                'decoded'   => $decoded
            ];
            $this->_returnJson($response, 200);
        }
        else {
            $response = [
                'status'    => false,
                'message'   => "You can't get auth token with Bearer Authentication."
            ];
            $this->_returnJson($response, 403);
        }
    }

    // process the 404 error here...
    public function error_404() {
        $response = [
            'status'    => false,
            'message'   => 'sorry, but we cannot find url you requested...'
        ];
        $this->_returnJson($response, 404);
    }
}
