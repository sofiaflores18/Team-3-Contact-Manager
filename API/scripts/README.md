## Libraries

*   **MySQLi**: A PHP extension that provides an interface for interacting with MySQL databases.
    *   [https://www.php.net/manual/en/book.mysqli.php](https://www.php.net/manual/en/book.mysqli.php)

---

### `scripts/auxiliary.php`

**Purpose:** This file contains a collection of helper functions designed to perform various common utility tasks across the application, such as input sanitization, redirection, and message display. These functions are typically generic and reusable.

#### Functions:

*   `sanitizeInput($data)`
    This function processes input data, stripping whitespace, slashes, and converting special characters to HTML entities, to prevent common web vulnerabilities like XSS attacks.
*   `redirect($url)`
    This function redirects the user's browser to a specified URL, typically used after form submissions or login/logout actions.
*   `displayMessage($message, $type = 'info')`
    This function formats and displays a user-friendly message, which can be styled based on its type (e.g., 'success', 'error', 'warning').

---

### `scripts/db.php`

**Purpose:** This file is responsible for establishing and managing the database connection, as well as providing functions to execute SQL queries and fetch results. It centralizes all database interaction logic.

#### Functions:

*   `connectDB()`
    This function establishes a connection to the MySQL database using predefined credentials and returns the connection object. It handles connection errors and sets character encoding.
*   `queryDB($sql, $params = [])`
    This function prepares and executes a parameterized SQL query against the connected database. It binds parameters to prevent SQL injection and returns the result object for `SELECT` queries or a boolean for `INSERT`/`UPDATE`/`DELETE`.
*   `fetchAssoc($result)`
    Given a query result object, this function fetches the next row as an associative array. It is typically used in a loop to retrieve all rows from a `SELECT` statement.
*   `fetchOne($sql, $params = [])`
    This function executes an SQL query and retrieves a single row from the database as an associative array. It is useful for queries expected to return only one record, such as user profiles.
*   `getLastInsertId()`
    This function returns the ID of the last row inserted into the database by an `INSERT` query. It is commonly used after creating new records to get their unique identifier.
*   `closeDB($conn)`
    This function closes the active database connection, releasing resources. It should be called when all database operations for a request are complete.