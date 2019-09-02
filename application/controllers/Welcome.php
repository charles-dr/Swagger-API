<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public  function time() {
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

        $headers = $this->input->request_headers();
        $header = $this->input->get_request_header('Authorization', FALSE);
        header('Content-Type: application/json');
        http_response_code(201);
        $header_arr = explode(' ', $header);
        echo json_encode([
            'token'   => $jwt,
            'source'    => $decoded,
            'headers'   => $headers['Authorization'],
            'header'   => $header,
            'decdoe'    => base64_decode($header_arr[1])
        ]);
        exit;
//	    echo date('Y-m-d H:i:s', strtotime('2019/09/02'));exit;
    }
}
