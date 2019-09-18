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
        $response = [
            'status'    => false,
            'message'   => 'Welcome to XXX service. Please check the url for more information',
            'url'       => 'url goes here.'
        ];
        $this->_returnJson($response, 200);
    }

    /**
     * @name getEmployeeList
     * @description get the employee list
     * @param null
     * @return mixed
    */
    public function getEmployeeList() {
        $employees = $this->EMPLOYEE->getEmployeeList();

        $response = [
            'status'    => false,
            'message'   => 'Data fetched successfully',
            'data'      => $employees
        ];
        $this->_returnJson($response);
    }

    /**
     * @name getEmployee
     * @description get an employee
     * @param idx - int
     * @return mixed
    */
    public function getEmployee($idx) {
        $where = ['pkemployee'  => $idx];
        $employee = $this->EMPLOYEE->getEmployee($where);
        if ($employee) {

            $response = [
                'status'    => true,
                'message'   => 'Data fetched successfully',
                'data'      => $employee
            ];
            $this->_returnJson($response, 200);
        }
        else {
            $response = [
                'status'    => false,
                'message'   => 'No employee found!',
                'data'      => false,
            ];
            $this->_returnJson($response, 400);
        }

    }

    /**
     * @name insertEmployee
     * @description insert an employee
     * @http_method PUT
     *
     * @param first_name: string
     * @param last_name: string
     * @param employee_id: string(formatted)
     * @param location_id: number
     * @param email string
     * @param password string
     * @param active string
     * @param train_manager string
     * @param escalation_manager string
     *
     * @return mixed
    */
    public function insertEmployee() {
        $request = $this->_getJsonRequest(false);

        $where = [
            'email' =>  $request->email
        ];
        $duplicated_email = $this->EMPLOYEE->checkEmployeeDuplicated($where);

        $where = [
            'employee_id'   => $request->employee_id
        ];
        $duplicated_employeeId = $this->EMPLOYEE->checkEmployeeDuplicated($where);

        if (
            !empty($request->employee_id) &&
            !empty($request->email) &&
            !$duplicated_email && !$duplicated_employeeId) {
            $insertData = [
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'employee_id'   => $request->employee_id,
                'location_id'   => $request->location_id,
                'email'         => $request->email,
                'password'      => $this->general->encryptPassword($request->password),
                'active'        => $request->active,
                'role'          => !empty($request->role) ? json_encode($request->role) : '',
                'train_manager'         => $request->train_manager,
                'escalation_manager'    => $request->escalation_manager,
                'created_at'            => gmdate('Y-m-d H:i:s'),
                'updated_at'            => gmdate('Y-m-d H:i:s')
            ];
            $inserted = $this->EMPLOYEE->insertData('employee', $insertData);

            if ($inserted) {
                $employeeData = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $inserted]);
                $response = [
                    'status'    => true,
                    'message'   => 'Data has been inserted successfully',
                    'data'      => $employeeData
                ];
                $this->_returnJson($response, 201);
            }
            else {
                $response = [
                    'status'    => false,
                    'message'   => 'Failed to insert data... Something went wrong'
                ];
                $this->_returnJson($response, 400);
            }
        }
        else {
            $response = [
                'status'    => false,
                'message'   => 'Employee already exists'
            ];
            $this->_returnJson($response, 400);
        }
    }

    /**
     *
    */
    public function updateEmployee($pkemployee) {
        $response = [];
        $http_code = 200;
        $request = $this->_getJsonRequest(false);
        // check employee exists
        $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);

        if ($employee) {
            // check employee id is right
            if (!empty($request->employee_id) && $employee->employee_id == $request->employee_id) {

                // check email duplication
                if (!empty($request->email)) {
                    $where = [
                        'email' => $request->email,
                        'pkemployee' => $pkemployee
                    ];
                    $dup_email = $this->EMPLOYEE->getResultData('employee', $where);

                    if ($dup_email) {
                        $http_code = 400;
                        $response = [
                            'status'    => false,
                            'message'   => 'Another empoyee already exists with email'
                        ];
                    }
                }
                else {
                    $updateData = $this->composeUpdateData($request);
                    if ($employee->active == 'Unchecked' && $request->active == 'Checked') {
                        $updateData['activated_at'] = gmdate('Y-m-d H:i:s');
                    }
                    $updateData['updated_at'] = gmdate('Y-m-d H:i:s');
                    $where = ['pkemployee' => $pkemployee];
                    $updated = $this->EMPLOYEE->updateData('employee', $where, $updateData);
                    if ($updated) {
                        $new_employee = $this->EMPLOYEE->getEmployee(['pkemployee' => $pkemployee]);
                        $response = [
                            'status'    => true,
                            'message'   => 'Employee updated successfully',
                            'data'      => $new_employee
                        ];
                        $http_code = 200;
                    }
                    else {
                        $response = [
                            'status'    => false,
                            'message'   => 'Something went wrong while updating employee'
                        ];
                        $http_code = 500;
                    }
                }

            }
            else {
                $response = [
                    'status'    => false,
                    'message'   => 'Employee Id does not match!'
                ];
                $http_code = 400;
            }
        }
        else {
            $response = [
                'status'    => false,
                'message'   => 'Employee does not exist!'
            ];
            $http_code = 404;
        }
        $this->_returnJson($response, $http_code);
    }

    /**
     * @name deleteEmployee
     * @description delete employee by pkemployee and employee ID
     * @param pkemployee[GET] id
     * @param employee_id[POST] string
     * @return mixed
    */
    public function deleteEmployee($pkemployee) {
        $request = $this->_getJsonRequest(false);
        $response = [];
        $http_code = 200;

        // check if employee exists
        $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);
        if ($employee) {
            if (!empty($request->employee_id) && ($employee->employee_id == $request->employee_id)) {
                $deleted = $this->EMPLOYEE->deleteData('employee',
                        ['pkemployee' => $pkemployee, 'employee_id' => $request->employee_id]);
                if ($deleted) {
                    $response = [
                        'status'    => true,
                        'message'   => 'Employee has been deleted.'
                    ];
                    $http_code = 200;
                }
                else {
                    $response = [
                        'status'    => false,
                        'message'   => 'Server Error! Failed to delete employee.'
                    ];
                    $http_code = 500;
                }
            }
            else {
                $response = [
                    'status'    => false,
                    'message'   => 'Unable to delete employee as the employee id does not match!'
                ];
                $http_code = 403;
            }
        }
        else {
            $response = [
                'status'    => false,
                'message'   => 'Employee does not exist'
            ];
            $http_code = 404;
        }

        $this->_returnJson($response, $http_code);
    }

    private function composeUpdateData($request) {
        $return = [];
        if (!empty($request->first_name)) $return['first_name'] = $request->first_name;
        if (!empty($request->last_name)) $return['last_name'] = $request->last_name;
        if (!empty($request->location_id)) $return['location_id'] = $request->location_id;
        if (!empty($request->email)) $return['email'] = $request->email;
        if (!empty($request->password)) $return['password'] = $this->general->encryptPassword($request->password);
        if (!empty($request->active)) $return['active'] = $request->active;
        if (!empty($request->train_manager)) $return['train_manager'] = $request->train_manager;
        if (!empty($request->escalation_manager)) $return['escalation_manager'] = $request->escalation_manager;
        if (!empty($request->role)) $return['role'] = json_encode($request->role);
        return $return;
    }
}
