<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }

    public function checkCredential($api_key, $api_secret) {
        return $this->db->from('client')
            ->where('api_key', $api_key)
            ->where('api_secret', $api_secret)
            ->limit(1)
            ->get()->row();
    }

}
