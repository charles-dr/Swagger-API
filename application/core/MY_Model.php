<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 3/10/2019
 * Time: 11:10 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class MY_Model extends CI_Model {
    public $db_main;
    public function __construct() {
        parent::__construct();
    }

    /**
     * @function: getRowData
     * @params: tbl_name, where, default_db
     * @return: object
    */
    public function getRowData($tbl_name, $where, $default_db = true){
        //return $current_db = $default_db ? 'club' : 'ci_db';
        $current_db = $default_db ? $this->db : $this->db_main;
        return $current_db->where($where)->get($tbl_name)->row();
    }

    /**
     * @function: getResultData
     * @params: tbl_name, where, default_db
     * @return: object Array
    */
    public function getResultData($tbl_name, $where, $default_db = true){
        $current_db = $default_db ? $this->db : $this->db_main;
        return $current_db->from($tbl_name)->where($where)->get()->result();
    }

    /**
     * @function: insertData
     * @params: tbl_name, data, default_db
     * @return: inserted id(int)
    */
    public function insertData($tbl_name, $data, $default_db = true){
        $current_db = $default_db ? $this->db : $this->db_main;
        $current_db->insert($tbl_name, $data);
        return $current_db->insert_id();
    }

    /**
     * @function: deleteData
     * @params: tbl_name, where, default_db
     * @return: affected_rows(int)
    */
    public function deleteData($tbl_name, $where , $default_db = true){
        $current_db = $default_db ? $this->db : $this->db_main;
        $current_db->where($where)->delete($tbl_name);
        return $current_db->affected_rows();
    }

    /**
     * @function: updateData
     * @params: tbl_name,where , data, default_db
     * @return: affected_rows(int)
    */
    public function updateData($tbl_name, $where, $data, $default_db = true){
        $current_db = $default_db ? $this->db : $this->db_main;
        $current_db->where($where)->update($tbl_name, $data);
        return $current_db->affected_rows();
    }
}