# Back-End for Contact Manager Project

### endpoints
Main folder for the API. Contains all endpoints, refer to /endpoints/README.md for a guide on how to use all endpoints.
___

### scripts
Folder that contains all db.php for using a sqli object to connect to mysql and auxiliary.php which contains useful helper functions, such as reading input.
___

### references
Contains the database code and other endpoint testing examples.
___

### legacy
Folder that contains all legacy code from our first implementation of the API with 2 endpoints and a switch statement on an action parameter which represents what the user wants to do.
___

### default_endpoint.php
Script that contains boilerplate code that every endpoint needs. Involving calling the sqli connection script, db.php, reading input from the request body or url, and importing the scripts from /scripts.
