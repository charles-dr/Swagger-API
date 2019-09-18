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
            $credentials = $this->general->getBasicAuthHeader();
            $client = $this->AUTH->checkCredential($credentials[0], $credentials[1]);

            $key = JWT_PRIVATE_KEY;


            // claims:  iss (issuer), exp (expiration time), sub (subject), aud (audience), and others.
            $token = [
                'iss'   => JWT_ISSUER,              // issuer
                'aud'   => $client->email,          // audience
                'iat'   => time(),                  // issued at time
                'exp'   => time() + JWT_EXPIRATION * 60  // not before time
            ];
            $jwt = JWT::encode($token, $key);

            $response = [
                'status'        => true,
                'expiration'    => JWT_EXPIRATION * 60,
                'token'         => $jwt
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
