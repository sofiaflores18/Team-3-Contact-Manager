# API and Database

# Back-End for Contact Manager Project

### authenticate.php
Endpoint that handles signup and login authentication. Returns a user_id which must be passed around for authentication

### contacts.php
Endpoint that handles CRUD operations (Create, read, update, delete). Should be able to get contacts, add, edit, delete, etc. Also has a search feature, requires user_id for authentication

### db.php
This script creates the connection to the mysql database using sqli, it logs in as the root user and then queries can be made here. This is like a rudimentary object relational mapper (ORM)

### auxiliary.php
Script that contains auxiliary functions, such as getRequestInfo() for processing HTTP POST requests