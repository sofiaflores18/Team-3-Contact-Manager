# Contact Manager Web Application

## Description

This Contact Manager is a full-stack web application built using a LAMP stack (Linux, Apache, MySQL, PHP) hosted on DigitalOcean.

The application allows users to:

- Sign up, creating an account with their personal info
- Log in using their username and password
- View their existing contacts
- Create new contacts
- Edit and delete existing contacts
- Search for contacts with fuzzy finding

Each user’s data is associated with a unique user ID stored in a MySQL database. The backend API processes JSON-based POST requests to authenticate users, insert new colors, and search existing colors. The frontend communicates with the API and dynamically displays results to the user.

This project demonstrates full-stack development, remote server deployment, database design, and API integration.

---

## Tech Stack

### Infrastructure
- DigitalOcean Droplet (Ubuntu Linux)
- LAMP Stack:
  - Linux
  - Apache
  - MySQL
  - PHP

### Backend
- PHP (API endpoints)
- MySQL (Relational Database)
- JSON for request and response handling

### Frontend
- HTML
- CSS
- JavaScript

### Tools
- SSH
- Swaggerhub / CURL for API testing
- Domain registration via GoDaddy

---

## User Instructions

1. Navigate to 
    - `http://165.245.135.60/Team-3-Contact-Manager/Front-End/src/pages/login.html`
    - Create an account using Signup
    - Login using the credientials you just created
    - Add contact button to create new contacts
    - Search to view all contacts, add some criteria to filter for specifics
    - Edit contacts with the edit button
        - Delete or save changed information with their respective buttons

---

## Developer Instructions

1. ssh into 
    - ```root@165.245.135.60``` authenticate with the password
2. Navigate to
    - ```cd \var\www\html\Team-3-Contact-Manager```
3. Begin developing from the git repo
