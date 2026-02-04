# API and Database

# Back-End for Contact Manager Project

### db.php
This script creates the connection to the mysql database using sqli, it logs in as the root user and then queries can be made here. This is like a rudimentary object relational mapper (ORM).

### login.php
Endpoint that handles sign up and login authentication.

### contacts.php
Endpoint that handles CRUD operations (Create, read, update, delete). Should be able to get contacts, add, edit, delete, etc. Also has a search feature