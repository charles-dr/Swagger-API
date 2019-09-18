# Swagger API
FORMAT: 1A
HOST:  https://traineerecords.com/api/

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
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC90cmFpbmVlcmVjb3Jkcy5jb21cL29tcyIsImF1ZCI6ImFsZXJrLnN0YXJAZ21haWwuY29tIiwiaWF0IjoxNTY4Njg2ODA0LCJleHAiOjE1Njg2OTA0MDR9._h3ghav3O94j4jkefwOIuRZjOWuYYCOCk7LG2q9k08c"
        }

# Group Employee

## Create a New Employee [/employee]

### Retrieve a Message [GET]

You may create your own question using this action. It takes a JSON
object containing a question and a collection of answers in the
form of choices.

+ Request (application/json)

    + Headers
    
            Authorization: Bearer {TOKEN}
    
    + Body
    
            {
                "first_name": "For",
                "last_name": "Delete",
                "employee_id": "1239445",
                "location_id": "27",
                "email": "for.delete@gmail.com",
                "password": "234234",
                "active": "Checked",
                "train_manager": "blackrock@example.com",
                "escalation_manager": "tom.dillon@example.com"
            }

+ Response 201 (application/json)

    + Body

            {
                "status": true,
                "message": "Data has been inserted successfully",
                "data": {
                    "pkemployee": "4",
                    "first_name": "For",
                    "last_name": "Delete",
                    "employee_id": "1239445",
                    "location_id": "27",
                    "email": "for.delete@gmail.com",
                    "password": "234234",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "",
                    "created_at": "2019-09-17 03:22:37",
                    "updated_at": "2019-09-17 03:22:37"
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

## List All Employees [GET]

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
                    "email": "test@gmail.com",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "",
                    "created_at": "2019-09-02 19:41:19",
                    "updated_at": "2019-09-02 19:41:19"
                }
            ]
        }
        
+ Response 400 (application/json)

        {
            "status": false,
            "message": "Expired token"
        }

## List All Employees <DELETE> [/employee/id]

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
                    "email": "test@gmail.com",
                    "active": "Checked",
                    "activated_at": null,
                    "train_manager": "blackrock@example.com",
                    "escalation_manager": "tom.dillon@example.com",
                    "role": "",
                    "created_at": "2019-09-02 19:41:19",
                    "updated_at": "2019-09-02 19:41:19"
                }
            ]
        }
        
+ Response 400 (application/json)

        {
            "status": false,
            "message": "Expired token"
        }
