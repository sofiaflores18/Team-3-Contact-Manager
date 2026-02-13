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

## POST http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/login.php
{
    "username":" ",
    "password":" "
}

## POST http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/create_contact.php
{
    "user_id": int,
    "firstname":" ",
    "lastname":" ",
    "email":" ",
    "phone":" "
}
### Returns username and password [DEBUGGING ONLY]
example:

## GET http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/read_contacts.php
{
    "user_id": int,
    "limit": int OPTIONAL,
    "offset: int OPTIONAL
}
### Returns array of JSON objects, each object contains a contact
example:


## PATCH http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/update_contact.php

## DELETE http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/delete_contact.php

## GET http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/search_for_contacts.php

## GET http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/me.php
{
    "user_id": int
}
### Returns username and password [DEBUGGING ONLY]