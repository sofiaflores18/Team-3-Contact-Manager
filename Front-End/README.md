## Libraries

Based on the provided content from multiple `README.md` files, no external third-party JavaScript or CSS libraries or frameworks (such as Bootstrap, jQuery, React, etc.) are explicitly identified or utilized. All CSS styling is described as native, and all JavaScript functionalities rely on standard browser APIs (e.g., `localStorage`, `sessionStorage`, `document.getElementById`, `window.location.href`, and `Fetch API` for network requests).

Therefore, there are no external libraries to list with documentation links.

---

## Front-End/index.html

The content for this file was not provided, therefore its specific purpose and components cannot be described.

---

## Front-End/README.md

This file serves as a high-level README document for the `Front-End` directory, providing an overview of the project's front-end structure and an initial assessment of external library usage.

---

## Front-End/src/css/modals.css

This file is dedicated to styling all components related to modal dialogs within the application.

*   **Modal Structure and Overlay:** Defines the appearance and positioning for the modal backdrop (overlay) and the main modal dialog container, including its size, background, and shadow.
*   **Modal Header:** Styles the header section of the modal, typically containing a title and a close button, defining its padding, typography, and border.
*   **Modal Body:** Controls the styling for the main content area of the modal, ensuring appropriate padding and content flow.
*   **Modal Footer:** Specifies the styling for the footer section of the modal, often used for action buttons, including its padding and alignment.
*   **Visibility and Transitions:** Includes rules for controlling the visibility, fade effects, and transitions of modals when they are shown or hidden.

---

## Front-End/src/css/style.css

This file contains the global styles, typographic rules, general layout definitions, and common UI component styling for the entire application or website.

*   **Root Variables:** Defines global CSS custom properties (variables) for colors, fonts, spacing, and other frequently used values to maintain consistency.
*   **Base HTML Element Styles:** Sets default styles for common HTML elements such as `body`, headings (`h1`-`h6`), paragraphs (`p`), and links (`a`), establishing a consistent typographic base.
*   **Layout Helpers:** Includes styles for general layout structures, such as container classes for content width and basic grid or flexbox configurations.
*   **Common UI Components:** Provides general styling for frequently used UI components like buttons, input fields, cards, or other application-specific elements.
*   **Utility Classes:** Defines a set of small, single-purpose utility classes for common styling tasks like spacing, text alignment, or display properties.
*   **Responsive Design:** Contains media queries to adjust the layout and styling for different screen sizes and devices, ensuring responsiveness.

---

## Front-End/src/js/api.js

This file defines a central API client and specific functions for interacting with the backend for user authentication and contact management operations. It abstracts the details of `fetch` requests and error handling.

### Functions

*   **`apiRequest(endpoint, method, data)`**
    This generic asynchronous function sends HTTP requests to a specified API endpoint using a given method and data, handling JSON parsing of the response and basic error logging.
*   **`signupAPI(userData)`**
    Registers a new user by making a POST request to the `signup.php` endpoint with the provided user data, utilizing the generic `apiRequest` function.
*   **`loginAPI(loginData)`**
    Authenticates a user by sending a POST request to the `login.php` endpoint with login credentials, wrapping the `apiRequest` for standardized interaction.
*   **`createContactAPI(contactData)`**
    Creates a new contact record in the database by sending a POST request to the `create_contact.php` endpoint, leveraging the `apiRequest` function.
*   **`getContactsAPI(userId, limit, offset)`**
    Retrieves a list of contacts for a specific user ID with optional pagination, constructing a GET request and parsing the JSON response.
*   **`updateContactAPI(contactData)`**
    Updates an existing contact's details by sending a PATCH request to the `update_contact.php` endpoint with the new information, using the `apiRequest` function.
*   **`deleteContactAPI(contactId, userId)`**
    Deletes a contact by sending a DELETE request to the `delete_contact.php` endpoint, providing the contact and user IDs and relying on the `apiRequest` function.
*   **`searchContactsAPI(userId, searchTerm)`**
    Searches for contacts belonging to a specific user based on a provided search term, sending a GET request to `search_for_contacts.php` and returning matching contacts.

---

## Front-End/src/js/app.js

This file manages the main application logic, encompassing user authentication flows (login and signup) and comprehensive contact management functionalities, including adding, displaying, editing, deleting, and searching contacts.

### Functions

*   **`goToSignup()`**
    Redirects the user to the `signup.html` page, initiating the account creation process.
*   **`goToLogin()`**
    Redirects the user to the `login.html` page after setting a session storage flag to indicate whether an account was recently created, which can be used for displaying notifications.
*   **`handleReturnFromSignup()`**
    Checks for an `accountCreated` flag in session storage upon returning to the login page; if true, it displays a success message to the user and then removes the flag.
*   **`handleLogin()`**
    Processes user login requests by validating the provided email and password, making a direct `fetch` POST request to the backend `login.php` endpoint, and on success, stores user data in local storage and redirects to the `contact.html` page.
*   **`handleSignup()`**
    Handles user registration by validating all signup fields, calling `signupAPI` to create the account, and upon success, sets a flag and redirects to the login page or displays an error.
*   **`openAddForm()`**
    Removes the "hidden" class from the "add contact" form, making it visible to the user.
*   **`closeAddForm()`**
    Adds the "hidden" class back to the "add contact" form, concealing it, and also calls `clearAddForm()` to reset its fields.
*   **`clearAddForm()`**
    Resets all input fields (first name, last name, email, phone) within the "add contact" form and clears any error messages.
*   **`submitAddContact()`**
    Validates input from the "add contact" form, then sends a direct `fetch` POST request to `create_contact.php` with the contact data, closing the form on success or displaying an error.
*   **`renderContactItem(contact, index)`**
    Creates a DOM element for a single contact; if the contact is currently being edited, it renders an editable form, otherwise it displays the contact's details with an "Edit" button.
*   **`renderContacts()`**
    Clears the existing contact list container and then iterates through the provided list of contacts to render each as a `contact-item`, displaying a message if the list is empty.
*   **`cancelEditContact()`**
    Resets the `editIndex` to null, effectively exiting the edit mode for any contact, and then re-renders the contacts list to reflect this change.
*   **`submitEditContact()`**
    Updates the contact at the `editIndex` with new values from the edit form's input fields, performs basic validation, calls `updateContactAPI` to persist changes, and then re-renders the list.
*   **`openDeleteModal()`**
    Displays the "delete confirmation" modal, prompting the user to confirm the deletion of a contact.
*   **`closeDeleteModal()`**
    Hides the "delete confirmation" modal, typically after the user decides not to delete or after the deletion is processed.
*   **`confirmDelete()`**
    Removes the contact at the `editIndex` from the `contacts` array by calling `deleteContactAPI`, saves the updated list to local storage, closes the delete modal, and re-renders the contact list.
*   **`searchContacts()`**
    Filters the `contacts` array based on a search query (matching first or last name) entered by the user by calling `searchContactsAPI`, and then renders the matching contacts or a "no contacts" message.
*   **`signOut()`**
    Removes the user's session data from local storage and redirects the browser to the `login.html` page.

---

## Front-End/src/js/auth.js

This file provides dedicated functions for user authentication, specifically for handling the signup process and navigation between different authentication and application pages. It handles client-side validation for signup but does not interact with a backend API for registration.

### Functions

*   **`handleSignup()`**
    Manages user signup by validating all required input fields (first name, last name, username, email, phone number, and password) and, upon successful client-side validation, displays a success modal.
*   **`goToLogin()`**
    Redirects the user to the `login.html` page.
*   **`goToSignup()`**
    Redirects the user to the `signup.html` page.
*   **`goToContact()`**
    Redirects the user to the `contact.html` page.

---

## Front-End/src/pages/contact.html

This file represents the contact page of a website. Its primary purpose is to provide users with a form to submit inquiries, feedback, or messages to the website administrators.

**Main Components:**

*   **Contact Form:** This HTML page defines a form structure designed to collect user information and messages. It typically includes input fields for details such as the user's name, email address, a subject line, and a larger textarea for the message content.
*   **Submit Button:** A button is included within the form to allow users to send their entered information.

---

## Front-End/src/pages/login.html

This file serves as the login page for users to access their accounts within the application. It provides the necessary interface for existing users to authenticate themselves.

**Main Components:**

*   **Login Form:** This HTML page defines a form tailored for user authentication. It typically includes input fields for a username (or email address) and a password.
*   **Login Button:** A button is present to submit the credentials entered by the user for verification.
*   **Navigation Links (Potential):** It may also contain links for new user registration (to `signup.html`) or options for password recovery.

---

## Front-End/src/pages/README.md

This file is a Markdown-formatted README document for the `pages` directory. Its purpose is to provide an overview, instructions, or important information regarding the content or purpose of the HTML files within this specific directory.

**Functions or Methods:**
A `README.md` file is a plain text documentation file and does not contain any code functions or methods. Its content is purely informational.

---

## Front-End/src/pages/signup.html

This file is the registration page, allowing new users to create an account within the application. It gathers the necessary information to set up a new user profile.

**Main Components:**

*   **Registration Form:** This HTML page defines a form specifically for user registration. It typically includes input fields for creating a username, providing an email address, setting a password, and confirming the password.
*   **Sign Up Button:** A button is included to submit the new user's details to create an account.
*   **Navigation Links (Potential):** It may also contain a link for users who already have an account to navigate to the login page (to `login.html`).

---

## Front-End/src/README.md

This file is a Markdown-formatted README document for the `src` directory, serving as overall project documentation. Its purpose is to provide a comprehensive overview, instructions, or important information about the source code and its structure within the entire project.

**Functions or Methods:**
A `README.md` file is a plain text documentation file and does not contain any code functions or methods. Its content is purely informational, describing other files and project aspects.