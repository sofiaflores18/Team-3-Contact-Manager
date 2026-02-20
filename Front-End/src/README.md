## Libraries

No external third-party libraries or frameworks (such as CSS frameworks, JavaScript libraries like jQuery or React, or UI component libraries) are identified or utilized within the provided code files. All CSS styling is native, and all JavaScript functionalities rely on standard browser APIs (e.g., `localStorage`, `sessionStorage`, `document.getElementById`, `window.location.href`, and `Fetch API` for network requests).

For the HTML files (`contact.html`, `login.html`, `signup.html`), as their content was not provided, it is not possible to definitively identify any external libraries they might be linking to or using. Typically, such libraries would be included via `<link>` tags for CSS or `<script>` tags for JavaScript within the HTML document's `<head>` or `<body>`.

---

### src/css/modals.css

This file is dedicated to styling all components related to modal dialogs within the application.

*   **Modal Structure and Overlay:** Defines the appearance and positioning for the modal backdrop (overlay) and the main modal dialog container, including its size, background, and shadow.
*   **Modal Header:** Styles the header section of the modal, typically containing a title and a close button, defining its padding, typography, and border.
*   **Modal Body:** Controls the styling for the main content area of the modal, ensuring appropriate padding and content flow.
*   **Modal Footer:** Specifies the styling for the footer section of the modal, often used for action buttons, including its padding and alignment.
*   **Visibility and Transitions:** Includes rules for controlling the visibility, fade effects, and transitions of modals when they are shown or hidden.

### src/css/style.css

This file contains the global styles, typographic rules, general layout definitions, and common UI component styling for the entire application or website.

*   **Root Variables:** Defines global CSS custom properties (variables) for colors, fonts, spacing, and other frequently used values to maintain consistency.
*   **Base HTML Element Styles:** Sets default styles for common HTML elements such as `body`, headings (`h1`-`h6`), paragraphs (`p`), and links (`a`), establishing a consistent typographic base.
*   **Layout Helpers:** Includes styles for general layout structures, such as container classes for content width and basic grid or flexbox configurations.
*   **Common UI Components:** Provides general styling for frequently used UI components like buttons, input fields, cards, or other application-specific elements.
*   **Utility Classes:** Defines a set of small, single-purpose utility classes for common styling tasks like spacing, text alignment, or display properties.
*   **Responsive Design:** Contains media queries to adjust the layout and styling for different screen sizes and devices, ensuring responsiveness.

### src/js/api.js

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

### src/js/app.js

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

### src/js/auth.js

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

### src/pages/contact.html

This file likely represents the contact page of a web application or website. Its primary purpose is to offer users a form to submit inquiries, feedback, or messages to the site administrators.

**Main Components:**

*   **Contact Form:** This HTML page defines a form structure designed to collect user information and messages. It typically includes input fields for details such as the user's name, email address, a subject line, and a larger textarea for the message content.
*   **Submit Button:** A button is included within the form to allow users to send their entered information.

### src/pages/login.html

This file serves as the login page, providing an interface for existing users to authenticate and access their accounts within the application.

**Main Components:**

*   **Login Form:** This HTML page defines a form tailored for user authentication. It typically includes input fields for a username (or email address) and a password.
*   **Login Button:** A button is present to submit the credentials entered by the user for verification.
*   **Navigation Links (Potential):** It may also contain links for new user registration (to `signup.html`) or options for password recovery.

### src/pages/README.md

This file is a Markdown-formatted README document for the `pages` directory. Its purpose is to provide an overview, instructions, or important information regarding the content or purpose of the HTML files within this specific directory.

**Functions or Methods:**
A `README.md` file is a plain text documentation file and does not contain any code functions or methods. Its content is purely informational.

### src/pages/signup.html

This file acts as the registration page, enabling new users to create an account within the application. It is designed to collect the necessary information to set up a new user profile.

**Main Components:**

*   **Registration Form:** This HTML page defines a form specifically for user registration. It typically includes input fields for creating a username, providing an email address, setting a password, and confirming the password.
*   **Sign Up Button:** A button is included to submit the new user's details to create an account.
*   **Navigation Links (Potential):** It may also contain a link for users who already have an account to navigate to the login page (to `login.html`).

### src/README.md

This file is a Markdown-formatted README document for the `src` directory, serving as overall project documentation. Its purpose is to provide a comprehensive overview, instructions, or important information about the source code and its structure within the entire project.

**Functions or Methods:**
A `README.md` file is a plain text documentation file and does not contain any code functions or methods. Its content is purely informational, describing other files and project aspects.