## Libraries
*   **curl**: A command-line tool and library for transferring data with URLs.
    *   [Official Documentation](https://curl.se/docs/)

---

### `references/database_reference.sql`

*   **Purpose**: Defines the database schema for the application, outlining the structure of tables and their relationships.
*   **Summary**: This file contains SQL `CREATE TABLE` statements. It defines a `Users` table for storing user authentication details and a `Contacts` table for managing user-specific contacts, including primary and foreign key constraints to ensure data integrity.

### `references/local_testing_endpoints.md`

*   **Purpose**: Provides a guide for locally testing API endpoints on a virtual machine using `curl` commands.
*   **Summary**: This Markdown document details how to test the `authenticate.php` (for signup) and `contacts.php` (for creating a contact) API endpoints. It includes specific `curl` command examples tailored for both PowerShell and Bash environments, demonstrating how to send POST requests with various parameters to the local server.

### `references/README.md`

*   **Purpose**: Provides an overview of libraries used and summarizes the purpose of other reference files in the directory.
*   **Summary**: This README outlines the external libraries (specifically `curl`) that are relevant to the documented processes. It also offers concise summaries for `database_reference.sql`, `local_testing_endpoints.md`, and `test_endpoint_curl.sh`, explaining their respective roles within the project's documentation and testing strategy.

### `references/test_endpoint_curl.sh`

*   **Purpose**: This file is a shell script likely intended for automating the testing of API endpoints using `curl`.
*   **Summary**: While the content of this specific file was not provided, typically such a script would contain a series of `curl` commands designed to interact with different backend API endpoints. It would allow for efficient and repeatable testing of various functionalities such as user authentication, data creation, or retrieval by sending pre-defined requests.