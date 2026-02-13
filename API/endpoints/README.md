# Team-3-Contact-Manager Endpoint Guide

## POST http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/signup.php
{
    "firstname":" ",
    "lastname":" ",
    "email":" ",
    "phone":" ",
    "username":" ",
    "password":" "
}
### Returns JSON object with user_id
example:
{"status":"success","message":"Login successful!","user_id":1}
____

## POST http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/login.php
{
    "username":" ",
    "password":" "
}
### Returns JSON object with user_id
example:
{"status":"success","message":"Login successful!","user_id":1}
____


## POST http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/create_contact.php
{
    "user_id":int,
    "firstname":" ",
    "lastname":" ",
    "email":" ",
    "phone":" "
}
### Returns JSON object with contact_id
example:
{"status":"success","contact_id":1}
____


## GET http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/read_contacts.php
{
    "user_id":int,
    "limit":int, OPTIONAL
    "offset:int OPTIONAL
}
### Returns array of JSON objects, each object contains a contact
example:
[{"id": 1, "email": "contact1@gmail.com", "phone": "111-111-1111", "created": "2026-02-13 07:53:38.000000", "user_id": 1, "lastname": "contact1lastname", "firstname": "contact1"}]
____


## PATCH http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/update_contact.php
{
    "user_id":1,
    "contact_id":3,
    "firstname":" ", OPTIONAL
    "lastname":" ", OPTIONAL
    "email":" ", OPTIONAL
    "phone":" "
}
### Returns success message
example:
{
  "status": "success"
}
____


## DELETE http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/delete_contact.php
{
    "user_id":1,
    "contact_id":7
}
### Returns success message
example:
{
  "status": "success"
}
____


## GET http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/search_for_contacts.php
{
    "user_id":int,
    "firstname":" "
}
### Returns array of JSON objects, each object contains a contact
example:
[
  {
    "id": 3,
    "email": "contact3@gmail.com",
    "phone": "333-333-3333",
    "created": "2026-02-13 07:53:58.000000",
    "user_id": 1,
    "lastname": "contact3lastname",
    "firstname": "contact3"
  }
]

____


## GET http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/me.php
{
    "user_id":int
}
### Returns JSON object with username and password [DEBUGGING ONLY]
example:
{"username":"testuser","password_hash":"$2y$12$reuMdiXfcWWMX4Uru2nSoexrtP1Q2UkuYsQ7cc9Oym7DqUhcEbQUO"}