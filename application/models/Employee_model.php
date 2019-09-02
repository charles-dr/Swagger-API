<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }

    function getSectionWithRoles() {
        $roles = getResultData('section', ['id >' => 0]);
    }

}
