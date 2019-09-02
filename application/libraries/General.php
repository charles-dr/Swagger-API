<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/2/2019
 * Time: 9:58 PM
 */

class General
{
    private $CI;
    public function __construct()
    {
        $this->CI = & get_instance();
    }

    public function getAuthHeaderType() {
        $header_encoded = $this->CI->input->get_request_header('Authorization', FALSE);
        $header_arr = explode(' ', $header_encoded);
        return $header_arr[0];
    }

    /**
     * @name getBasicAuthHeader
     * @description returns the api credentials
     * @return Array
     * @field   0: api_key, 1: api_credentials
    */
    public function getBasicAuthHeader() {
        $header_encoded = $this->CI->input->get_request_header('Authorization', FALSE);
        $header_arr = explode(' ', $header_encoded);
        $header = base64_decode($header_arr[1]);
        $credential_arr = explode(':', $header);
        return $credential_arr;
    }

    public function generateKey($length = 30, $split_length = 6) {
        return implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, $length), $split_length));
    }

    public function checkApiKeyValid($apiKey) {
        return preg_match(PATTERN_API_KEY, $apiKey);
    }

    public function checkApiSecretValid($apiSecret) {
        return preg_match(PATTERN_API_SECRET, $apiSecret);
    }
}

