<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model', 'EMPLOYEE');
        $this->load->model('Course_model', 'COURSE');
    }


    /**
     * @function addCourse
     * @params pkemployee employee unique id
     *
     * @request course_name: string
     * @request date_activity: string
     * @request due_date: string
     *
     * @returns mixed
    */
    public function addCourse($pkemployee) {
        $request = $this->_getJsonRequest(false);
        $response = [];
        $http_code = 200;

        if (
            !empty($request->course_name) &&
            !empty($request->date_activity) &&
            !empty($request->due_date)
        ) {
            $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);
            if ($employee) {
                $insertData = [
                    'date_activity' => $request->date_activity,
                    'employee_id'   => $employee->employee_id,
                    'due_date'       => $request->due_date,
                    'course_name'   => $request->course_name,
                    'created_at'    => gmdate('Y-m-d H:i:s'),
                    'updated_at'    => gmdate('Y-m-d H:i:s')
                ];
                $insert_id = $this->COURSE->insertData('course', $insertData);
                $course = $this->COURSE->getRowData('course', ['course_id'  => $insert_id]);
                if ($insert_id && $course) {
                    $http_code = 201;
                    $response = [
                        'status'    => true,
                        'message'   => 'Course added successfully',
                        'data'      => $course
                    ];
                }
                else {
                    $http_code = 500;
                    $response = [
                        'status'    => false,
                        'message'   => 'Server error! Failed to insert data.'
                    ];
                }
            }
            else {
                $http_code = 400;
                $response = [
                    'status'    => false,
                    'message'   => 'Employee does not exist.'
                ];
            }
        }
        else {
            $http_code = 400;
            $response = [
                'status'    => false,
                'message'   => 'Insufficient parameters. Please check the document.'
            ];
        }
        $this->_returnJson($response, $http_code);
    }

    /**
     * @function getCourseList
     * @param pkemployee: int
     * @return mixed
     *
    */
    public function getCourseList($pkemployee) {
        $response = [];
        $http_code = 200;

        $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);
        if ($employee) {
            $courses = $this->COURSE->getResultData('course', ['employee_id' => $employee->employee_id]);
            $http_code = 200;
            $response = [
                'status'    => true,
                'message'   => 'Data fetched successfully',
                'data'      => $courses
            ];
        }
        else {
            $http_code = 400;
            $response = [
                'status'    => false,
                'message'   => 'Invalid employee Id!. No employee found with the given pkemployee.'
            ];
        }

        $this->_returnJson($response, $http_code);
    }

    /**
     * @function getCourse
     * @param pkemployee - employee unique id
     * @param courseId - course Id
     *
     * @request course_name: string
     * @request date_activity: string
     * @request due_date: string
     *
     * @return mixed
    */
    public function getCourse($pkemployee, $courseId) {
        $response = [];
        $http_code = 200;
        if (!empty($pkemployee) && !empty($courseId)) {
            $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);
            if ($employee) {
                $course = $this->COURSE->getRowData('course', ['course_id' => $courseId]);

                if ($course) {
                    $http_code = 200;
                    $response = [
                        'status'    => true,
                        'message'   => 'Data fetched successfully',
                        'data'      => $course
                    ];
                }
                else {
                    $http_code = 400;
                    $response = [
                        'status'    => false,
                        'message'   => 'No course exists with course id for this employee'
                    ];
                }
            }
            else {
                $http_code = 400;
                $response = [
                    'status'    => false,
                    'message'   => 'No employee found'
                ];
            }
        }
        else {
            $http_code = 400;
            $response = [
                'status'    => false,
                'message'   => 'Invalid Parameters!'
            ];
        }

        $this->_returnJson($response,  $http_code);
    }

    /**
     * @function updateCourse
     * @param pkemployee: employee unique id
     * @param courseId: course id
     *
     * @request course_name: string
     * @request due_date: string
     * @request date_activity: string
     *
     * @returns mixed
    */
    public function updateCourse($pkemployee, $courseId) {
        $response = []; $http_code = 200;

        $request = $this->_getJsonRequest(false);
        if (
            !empty($pkemployee) &&
            !empty($courseId)
        ) {
            $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);
            if ($employee) {
                $course = $this->COURSE->getRowData('course', ['course_id' => $courseId, 'employee_id' => $employee->employee_id]);
                if ($course) {

                    if (empty($request->course_name) && empty($request->date_activity) && empty($request->due_date)) {
                        $http_code = 400;
                        $response = [
                            'status'    => false,
                            'message'   => 'Please input valid parameters'
                        ];
                    }
                    else {

                        $updateData = [
                            'updated_at'    => gmdate('Y-m-d H:i:s')
                        ];

                        if (!empty($request->course_name)) $updateData['course_name'] = $request->course_name;
                        if (!empty($request->due_date)) $updateData['due_date'] = $request->due_date;
                        if (!empty($request->date_activity)) $updateData['date_activity'] = $request->date_activity;

                        $updated = $this->COURSE->updateData('course', ['course_id' => $courseId], $updateData);
                        if ($updated) {
                            $course = $this->COURSE->getRowData('course', ['course_id' => $courseId]);
                            $http_code = 200;
                            $response = [
                                'status'    => true,
                                'message'   => 'Course updated successfully',
                                'data'      => $course
                            ];
                        }
                        else {
                            $http_code = 500;
                            $response = [
                                'status'    => false,
                                'message'   => 'Server error while updating on database'
                            ];
                        }
                    }
                }
                else {
                    $http_code = 400;
                    $response = [
                        'status'    => false,
                        'message'   => 'Not found course for this employee. Please check the course id again.'
                    ];
                }
            }
            else {
                $http_code = 400;
                $response = [
                    'status'    => false,
                    'message'   => 'No employee found .'
                ];
            }
        }
        else {
            $http_code = 400;
            $response = [
                'status'    => false,
                'message'   => 'Insufficient parameters !'
            ];
        }

        $this->_returnJson($response, $http_code);
    }

    /**
     * @function deleteCourse
     *
     * @param pkemployee: int
     * @param courseId: int
     *
     * @return mixed
    */
    public function deleteCourse($pkemployee, $courseId) {
        $http_code = 200;
        $response = [];

        if (!empty($pkemployee) && !empty($courseId)) {
            $employee = $this->EMPLOYEE->getRowData('employee', ['pkemployee' => $pkemployee]);

            if ($employee) {
                $course = $this->COURSE->getRowData('course', ['employee_id' => $employee->employee_id, 'course_id' => $courseId]);

                if ($course) {
                    $deleted = $this->COURSE->deleteData('course', ['course_id' => $courseId]);
                    if ($deleted) {
                        $courses = $this->COURSE->getResultData('course', ['employee_id' => $employee->employee_id]);
                        $http_code = 200;
                        $response = [
                            'status'    => true,
                            'message'   => 'Course deleted successfully',
                            'data'      => $courses
                        ];
                    }
                    else {
                       $http_code = 500;
                       $response = [
                           'status'     => false,
                           'message'    => 'Server error while deleting on database'
                       ];
                    }
                }
                else {
                    $http_code = 400;
                    $response = [
                        'status'    => false,
                        'message'   => 'Employee does not have the course with given id.'
                    ];
                }
            }
            else {
                $http_code = 400;
                $response = [
                    'status'    => false,
                    'message'   => 'Employee not found !'
                ];
            }
        }
        else {
            $http_code = 400;
            $response = [
                'status'    => false,
                'message'   => 'Insufficient parameters'
            ];
        }

        $this->_returnJson($response);
    }

}
