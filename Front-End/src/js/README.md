## Libraries

No external third-party JavaScript libraries or frameworks are directly used in these files. All functionalities rely on standard browser APIs.

*   **Fetch API**: For making network requests.
    *   [https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)

---

## js/api.js

This file defines a central API client and specific functions for interacting with the backend for user authentication and contact management operations. It abstracts the details of `fetch` requests and error handling.

### Functions

*   **`apiRequest(endpoint, method, data)`**
    A generic asynchronous function that sends HTTP requests to the specified API endpoint with a given method (defaulting to 'POST') and data. It handles JSON parsing of the response and basic error logging for network or JSON parsing issues.
*   **`signupAPI(userData)`**
    Registers a new user by making a POST request to the `signup.php` endpoint with the provided user data. It utilizes the generic `apiRequest` function for the actual network call.
*   **`loginAPI(loginData)`**
    Authenticates a user by sending a POST request to the `login.php` endpoint with login credentials. This function also wraps the `apiRequest` for standardized API interaction.
*   **`createContactAPI(contactData)`**
    Creates a new contact record in the database by sending a POST request to the `create_contact.php` endpoint. It leverages the `apiRequest` function to perform the operation.
*   **`getContactsAPI(userId, limit, offset)`**
    Retrieves a list of contacts associated with a specific user ID, with optional parameters for pagination. It constructs a GET request directly using `fetch` and parses the JSON response, returning an empty array on parse errors.
*   **`updateContactAPI(contactData)`**
    Updates an existing contact's details by sending a PATCH request to the `update_contact.php` endpoint with the updated contact information. This function uses the `apiRequest` for execution.
*   **`deleteContactAPI(contactId, userId)`**
    Deletes a contact by sending a DELETE request to the `delete_contact.php` endpoint, providing the contact ID and user ID. It relies on the `apiRequest` function for its network call.
*   **`searchContactsAPI(userId, searchTerm)`**
    Searches for contacts belonging to a specific user based on a provided search term (currently mapped to 'firstname'). It sends a GET request to `search_for_contacts.php`, handles the response, and returns an array of matching contacts.

---

## js/app.js

This file contains the main client-side JavaScript logic for the contact manager application, handling user authentication flows (login and signup), and comprehensive CRUD operations for contacts, including UI manipulation.

### Functions

*   **`goToSignup()`**
    Redirects the browser to the `signup.html` page to allow users to create a new account.
*   **`goToLogin()`**
    Navigates the user to the `login.html` page, first setting a session storage flag to indicate if an account was recently created for potential notification display.
*   **`handleReturnFromSignup()`**
    Checks for an `accountCreated` flag in session storage when on the login page, displaying a success notification if an account was just created and then clearing the flag.
*   **`handleLogin()`**
    Processes user login by validating provided email and password, making a direct `fetch` POST request to the backend `login.php` endpoint, and on success, stores the user ID in local storage before redirecting to `contact.html`.
*   **`handleSignup()`**
    Manages user registration by validating all input fields including email and phone number formats, then calls the `signupAPI` to create the account. If successful, it sets a flag and redirects to the login page; otherwise, it displays an error.
*   **`openAddForm()`**
    Makes the "add contact" form visible by removing its "hidden" CSS class.
*   **`closeAddForm()`**
    Hides the "add contact" form by adding the "hidden" CSS class and clears its input fields.
*   **`clearAddForm()`**
    Resets all input fields within the "add contact" form and clears any associated error messages.
*   **`submitAddContact()`**
    Validates inputs for adding a new contact, then sends a direct `fetch` POST request to `create_contact.php` with the contact data. On success, it closes the form; otherwise, it displays an error.
*   **`renderContactItem(contact, index)`**
    Generates a DOM `div` element for a single contact, displaying either the contact's details with an "Edit" button or an editable form if the contact is currently selected for editing.
*   **`renderContacts()`**
    Clears the existing contact list display and then iterates through the `contacts` array to render each contact item, showing an empty message if no contacts are available.
*   **`cancelEditContact()`**
    Exits the contact edit mode by resetting the `editIndex` and then re-renders the contact list to show contacts in their normal display state.
*   **`submitEditContact()`**
    Updates the contact currently being edited with new values from the edit form, performs basic validation, calls `updateContactAPI` to persist changes, and then re-renders the contact list.
*   **`openDeleteModal()`**
    Displays a confirmation modal to the user, asking them to confirm the deletion of a contact.
*   **`closeDeleteModal()`**
    Hides the delete confirmation modal from the user's view.
*   **`confirmDelete()`**
    Executes the deletion of the currently selected contact by calling `deleteContactAPI`, removes the contact from the local `contacts` array, closes the delete modal, and re-renders the contact list.
*   **`searchContacts()`**
    Retrieves a search query from the input field and calls `searchContactsAPI` to fetch matching contacts from the backend. It then updates the displayed contact list with the search results.
*   **`signOut()`**
    Removes the user's ID from local storage and redirects the browser to the `login.html` page, effectively logging the user out.

---

## js/auth.js

This file contains client-side functions primarily for handling a frontend-only signup process and navigation between different authentication and main application pages. It does not interact with the backend API for signup.

### Functions

*   **`handleSignup()`**
    Validates user input fields for first name, last name, username, email, phone number, and password during signup. Upon successful client-side validation, it displays a success modal without making a backend API call.
*   **`goToLogin()`**
    Redirects the user's browser to the `login.html` page.
*   **`goToSignup()`**
    Redirects the user's browser to the `signup.html` page.
*   **`goToContact()`**
    Redirects the user's browser to the `contact.html` page, typically after successful login.