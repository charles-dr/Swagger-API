<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends MY_Model {
    public function __construct(){
        parent::__construct();
    }

    /**
     * @name getEmployeeList
     * @description get all employee list
     * @params nothing for now
     * @return Array
    */
    function getEmployeeList() {
        $rows =  $this->db->from('employee')->get()->result();

        // get courses
        foreach ($rows as $employee) {
            $coures = $this->db->from('course')->where('employee_id' , $employee->employee_id)->get()->result();
            $employee->courses = $coures;
        }
        return $rows;
    }

    function getEmployee($where) {
        $row = $this->db->from('employee')
            ->where($where)->get()->row();

        if ($row) {
            $courses = $this->db->from('course')->where('employee_id', $row->employee_id)->get()->result();
            $row->courses = $courses;
        }

        return $row;
    }

    /**
     * @name checkEmployeeDuplicated
     * @description check if employee already exists or not
     * @param where: mixed
     * @return boolean
    */
    function checkEmployeeDuplicated($where) {
        $rows = $this->db->from('employee')
            ->where($where)
            ->get()->result();
        return count($rows) ? true : false;
    }
}
