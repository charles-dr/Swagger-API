# Swagger API

# Traineerecords 

Traineerecords is a API allowing customers to add employees and manage their courses.


# Authentication [/get-token]

## Get New Token [GET]

Generate new token using basic Auth header which needs the API_KEY and API_SECRET

+ Request

    + Headers

            Authorization: Basic {API_KEY}:{API_SECRET}

+ Response 200 (application/json)

        {
            "status": true,
            "expiration": 3600,
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC90cmFpbmVlcmVjb3Jkcy5jb21cL29tcyIsImF1ZCI6ImFsZXJrLnN0YXJAZ21haWwuY29tIiwiaWF0IjoxNTY4NzY5Nzg4LCJleHAiOjE1Njg3NzMzODh9.WqL9VgwOCYzVjGuM85BInfIjRHWe2T7Dp2JRof0fwfQ"
        }

+ Response 401 (application/json)

        {
            "status": false,
            "message": "Invalid API Secret Format!"
        }

+ Response 401 (application/json)

        {
            "status": false,
            "message": "Invalid API Key Format!"
        }

# Group Employee 

## /employee

### Create a New Employee [PUT]

    You may create a new employee.

    - Request Body
    
        first_name(string, required) - First name of the employee
        
        last_name(string, required) - Last name of the employee
        
        employee_id(string, reuired, unique) - 6 digists string unique for each employee
        
        location_id(number, required) - location id
        
        email(string, required, unique) - email of the employee
        
        password(string, required) - password of the employee
        
        active(string, optional) - active status of the employee. one of two values - 'Chekced', 'Unchecked'
        
        role(mixed, optional) - role data of the employee which will be saved in forms of JSON string
        
        train_manager(string, required) - email of the train manager
        
        escalation_manager(string, required) - email of the escalation manager
        

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}
    
    + Body
    
            {
                "first_name": "Hello",
                "last_name": "Again",
                "employee_id": "232565",
                "location_id": "27",
                "email": "hasdello.agai@gmail.com",
                "password": "234234",
                "active": "Checked",
                "role": [
                    {"id": 12},
                    {"id": 15}
                ],
                "train_manager": "blackrock@example.com",
               "escalation_manager": "tom.dillon@example.com"
            }

+ Response 201 (application/json)

    + Body

            {
                "status": true,
                "message": "Data has been inserted successfully",
                "data": {
                    "pkemployee": "6",
                    "first_name": "Hello",
                    "last_name": "Again",
                    "employee_id": "232565",
                    "location_id": "27",
                    "email": "hasdello.agai@gmail.com",
                    "password": "0e9212587d373ca58e9bada0c15e6fe4",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "[{\"id\":12},{\"id\":15}]",
                    "created_at": "2019-09-17 23:08:29",
                    "updated_at": "2019-09-17 23:08:29"
                }
            }

+ Response 400 (application/json)

        {
            "status": false,
            "message": "Employee already exists"
        }

+ Response 400 (application/json)

        {
            "status": false,
            "message": "Expired token"
        }

### List All Employees [GET]
    You may get all employees.

+ Request

    + Headers

            Authorization: Bearer {TOKEN}

+ Response 200 (application/json)

        {
            "status": false,
            "message": "Data fetched successfully",
            "data": [
                {
                    "pkemployee": "1",
                    "first_name": "Patrick",
                    "last_name": "Jones",
                    "employee_id": "202010",
                    "location_id": "27",
                    "email": "al.erk.star@gmail.com",
                    "password": "123456",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "",
                    "created_at": "2019-09-02 19:41:19",
                    "updated_at": "2019-09-02 19:41:19",
                    "courses": [
                        {
                            "course_id": "1",
                            "date_activity": "2018-02-21 00:00:00",
                            "employee_id": "202010",
                            "due_date": "2019-12-31 00:00:00",
                            "course_name": "Course #1",
                            "created_at": "2019-09-17 12:29:01",
                            "updated_at": "2019-09-17 20:31:37"
                        }
                    ]
                },
                {
                    "pkemployee": "2",
                    "first_name": "Tai",
                    "last_name": "Jin",
                    "employee_id": "202015",
                    "location_id": "27",
                    "email": "alerk.star@gmail.com",
                    "password": "234234",
                    "active": "Unchecked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "",
                    "created_at": "2019-09-03 14:40:56",
                    "updated_at": "2019-09-03 14:40:56",
                    "courses": []
                }
            ]
        }
        
+ Response 400 (application/json)

        {
            "status": false,
            "message": "Expired token"
        }
        
## /employee/{id}

+ Parameters

    + id (required, number, `1`) ... pkemployee of the Empoyee in form of an integer

### Get an Employee [GET]

You may get the details of employee for given pkemployee field.

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}

+ Response 200 (application/json)

    + Body

            {
                "status": true,
                "message": "Data fetched successfully",
                "data": {
                    "pkemployee": "1",
                    "first_name": "Patrick",
                    "last_name": "Jones",
                    "employee_id": "202010",
                    "location_id": "27",
                    "email": "al.erk.star@gmail.com",
                    "password": "123456",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "",
                    "created_at": "2019-09-02 19:41:19",
                    "updated_at": "2019-09-02 19:41:19",
                    "courses": [
                        {
                            "course_id": "1",
                            "date_activity": "2018-02-21 00:00:00",
                            "employee_id": "202010",
                            "due_date": "2019-12-31 00:00:00",
                            "course_name": "Course #1",
                            "created_at": "2019-09-17 12:29:01",
                            "updated_at": "2019-09-17 20:31:37"
                        }
                    ]
                }
            }

+ Response 400 (application/json)

    + Body
    
            {
                "status": false,
                "message": "No employee found!",
                "data": false
            }

### Update an Employee [PATCH]

You may update the details of an employee for given pkemployee field.

In order to update the employee data, you need to specify the employee_id in the request body to
confirm you have the authority to update data.

Employee id won't be changed and will be used only to confirm the authority.


    - Request Body
    
        first_name(string, optional) - First name of the employee
        
        last_name(string, optional) - Last name of the employee
        
        employee_id(string, reuired, unique) - 6 digists string unique for each employee
        
        location_id(number, optional) - location id
        
        email(string, optional, unique) - email of the employee
        
        password(string, optional) - password of the employee
        
        active(string, optional) - active status of the employee. one of two values - 'Chekced', 'Unchecked'
        
        role(mixed, optional) - role data of the employee which will be saved in forms of JSON string
        
        train_manager(string, optional) - email of the train manager
        
        escalation_manager(string, optional) - email of the escalation manager

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}

    + Body
        
            {
                "employee_id": "1239498",
                "first_name": "Test",
                "last_name": "Update",
                "location_id": "27",
                "active": "Checked",
                "train_manager": "blackrock.delete@example.com",
                "escalation_manager": "tom.dillon.delete@example.com",
                "role": {
                    "id": 12,
                    "name": "Sponsor"
                }
            }

+ Response 200 (application/json)

    + Body

            {
                "status": true,
                "message": "Employee updated successfully",
                "data": {
                    "pkemployee": "5",
                    "first_name": "Test",
                    "last_name": "Update",
                    "employee_id": "1239498",
                    "location_id": "27",
                    "email": "hello.again@gmail.com",
                    "password": "0e9212587d373ca58e9bada0c15e6fe4",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock.delete@example.com",
                    "escalation_manager": "tom.dillon.delete@example.com",
                    "role": "{\"id\":12,\"name\":\"Sponsor\"}",
                    "created_at": "2019-09-17 23:00:58",
                    "updated_at": "2019-09-18 00:13:30",
                    "courses": []
                }
            }

+ Response 400 (application/json)

    + Body
    
            {
                "status": false,
                "message": "Employee Id does not match!"
            }

+ Response 404 (application/json)

    + Body
    
            {
                "status": false,
                "message": "Employee does not exist!"
            }

### Delete an Employee [DELETE]

You may delete an employee for a given id.

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}

+ Response 200 (application/json)

    + Body

            {
                "status": true,
                "message": "Employee has been deleted."
            }

+ Response 400 (application/json)

    + Body
    
            {
                "status": false,
                "message": "Unable to delete employee as the employee id does not match!"
            }

+ Response 404 (application/json)

    + Body
    
            {
                "status": false,
                "message": "Employee does not exist"
            }
            
            
# Group Course

## /employee/{id}/course

+ Parameters

    + id (required, number, `1`) ... pkemployee of the Empoyee in form of an integer

### Add New Course [PUT]

You may add new course to employee.


    - Request Body
    
        course_name(string, required) - Course name
        
        date_acitivty(string, required) - Activity date in forms of 'YYYY-mm-dd[ HH:ii::ss]'
        
        due_date(string, required) - Expiration date in forms of 'YYYY-mm-dd[ HH:ii:ss]'
        
+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}
    
    + Body
    
            {
                "course_name": "Course #1 to 5",
                "date_activity": "2018-06-21",
                "due_date": "2019-11-30"
            }

+ Response 201 (application/json)

    + Body

            {
                "status": true,
                "message": "Course added successfully",
                "data": {
                    "course_id": "3",
                    "date_activity": "2018-06-21 00:00:00",
                    "employee_id": "1239498",
                    "due_date": "2019-11-30 00:00:00",
                    "course_name": "Course #1 to 5",
                    "created_at": "2019-09-18 00:35:16",
                    "updated_at": "2019-09-18 00:35:16"
                }
            }

+ Response 400 (application/json)

            {
                "status": false,
                "message": "Employee does not exist."
            }

### Get List of Courses [GET]

You may get all courses of an employee

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}

+ Response 200 (application/json)

            {
                "status": true,
                "message": "Data fetched successfully",
                "data": [
                    {
                        "course_id": "3",
                        "date_activity": "2018-06-21 00:00:00",
                        "employee_id": "1239498",
                        "due_date": "2019-11-30 00:00:00",
                        "course_name": "Course #1 to 5 - updated",
                        "created_at": "2019-09-18 00:35:16",
                        "updated_at": "2019-09-18 01:38:21"
                    }
                ]
            }

+ Response 400 (application/json)

            {
                "status": false,
                "message": "Employee does not exist."
            }

## /employee/{id}/course/{courseId}

+ Parameters

    + id (required, number, `1`) ... pkemployee of the Empoyee in form of an integer
    
    + courseId (required, number, `1`) ... course_id of the Course in form of integer

### GEt a Course [GET]

You may get the details of a course of employee.

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}

+ Response 200 (application/json)

            {
                "status": true,
                "message": "Course updated successfully",
                "data": {
                    "course_id": "3",
                    "date_activity": "2018-06-21 00:00:00",
                    "employee_id": "1239498",
                    "due_date": "2019-11-30 00:00:00",
                    "course_name": "Course #1 to 5 - updated",
                    "created_at": "2019-09-18 00:35:16",
                    "updated_at": "2019-09-18 01:38:21"
                }
            }

+ Response 400 (application/json)


            {
                "status": false,
                "message": "Employee does not exist."
            }

### Update a Course [PATCH]

You may update a course of the employee.

You need to provide at least one of optional parameters.

    - Request Body
    
        course_name(string, optional) - Course name
        
        date_acitivty(string, optional) - Activity date in forms of 'YYYY-mm-dd [HH:ii::ss]'
        
        due_date(string, optional) - Expiration date in forms of 'YYYY-mm-dd [HH:ii:ss]'
        

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}
    
    + Body
    
            {
                "course_name": "Course #1 to 5",
                "date_activity": "2018-06-21",
                "due_date": "2019-11-30"
            }

+ Response 201 (application/json)

    + Body

            {
                "status": true,
                "message": "Course updated successfully",
                "data": {
                    "course_id": "3",
                    "date_activity": "2018-06-21 00:00:00",
                    "employee_id": "1239498",
                    "due_date": "2019-11-30 00:00:00",
                    "course_name": "Course #1 to 5 - updated",
                    "created_at": "2019-09-18 00:35:16",
                    "updated_at": "2019-09-18 01:29:54"
                }
            }

+ Response 400 (application/json)

            {
                "status": false,
                "message": "No employee found ."
            }

+ Response 400 (application/json)

            {
                "status": false,
                "message": "Not found course for this employee. Please check the course id again."
            }

### Delete a Course [DELETE]

You may delete a course from employee.

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}

+ Response 200 (application/json)


            {
                "status": true,
                "message": "Course deleted successfully",
                "data": []
            }
            

+ Response 400 (application/json)


            {
                "status": false,
                "message": "Employee does not exist."
            }
