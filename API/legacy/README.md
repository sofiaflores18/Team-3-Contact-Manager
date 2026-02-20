## Libraries
- **phpdotenv**: A PHP library for loading environment variables from a `.env` file into `getenv()`, `$_ENV`, and `$_SERVER`.
    - [https://github.com/vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)
- **php-jwt**: A simple library to encode and decode JSON Web Tokens (JWT) in PHP, adhering to RFC 7519.
    - [https://github.com/firebase/php-jwt](https://github.com/firebase/php-jwt)

### legacy/authenticate.php
- **Purpose**: This file handles user authentication, including user login and refreshing access tokens using JSON Web Tokens (JWT). It simulates user credentials and manages token generation and validation.

- `handleAuthRequest()`: This function serves as the main entry point for authentication requests, processing POST requests to either log in a user or refresh an existing access token. It decodes the incoming JSON payload and dispatches to the appropriate helper function based on the `action` field.
- `authenticateUser($username, $password)`: This function attempts to authenticate a user by checking the provided username and password against a set of predefined credentials. If the credentials are valid, it generates and returns a pair of access and refresh tokens.
- `generateTokens($username)`: This function creates both an access token and a refresh token for a given username using JWT. It incorporates environment variables for secrets and defines token properties like issuer, audience, and expiration times.
- `refreshAccessToken($refreshToken)`: This function validates a provided refresh token and, if valid, issues a new pair of access and refresh tokens for the associated user. It ensures that expired access tokens can be renewed without requiring a full re-login.
- `sendResponse($data, $statusCode = 200)`: This utility function sends a JSON response back to the client with the specified data and HTTP status code. It sets the `Content-Type` header to `application/json` for proper client interpretation.

### legacy/contacts.php
- **Purpose**: This file provides a simple RESTful API for managing contacts, supporting CRUD (Create, Read, Update, Delete) operations. It includes JWT-based authentication to secure access to the contact management functionalities.

- `initDatabase()`: This function initializes a session-based "database" for contacts, populating it with dummy data if no contact data is currently stored in the session. It acts as an in-memory storage for the duration of the user's session.
- `handleRequest()`: This function serves as the main router for API requests, validating the incoming JWT access token before processing any CRUD operations. Based on the HTTP request method (GET, POST, PUT, DELETE), it dispatches to the corresponding contact management function.
- `validateToken()`: This function extracts and decodes the JWT access token from the `Authorization` header to verify its authenticity and expiration. It uses a predefined secret key from environment variables to validate the token's signature.
- `getContacts($id = null)`: This function retrieves contact information; if an `$id` is provided, it returns a specific contact, otherwise it returns all contacts stored in the session. It acts as the read operation for the contacts API.
- `createContact($data)`: This function adds a new contact to the session-based database using the provided data. It assigns a unique ID to the new contact before storing and returning it.
- `updateContact($id, $data)`: This function updates an existing contact identified by `$id` with the new data. It allows modification of name, email, and phone fields, returning the updated contact or null if not found.
- `deleteContact($id)`: This function removes a contact from the session-based database based on its `$id`. It returns `true` upon successful deletion or `false` if the contact was not found.
- `sendResponse($data, $statusCode = 200)`: This utility function sends a JSON response back to the client with the specified data and HTTP status code. It sets the `Content-Type` header to `application/json` for proper client interpretation.