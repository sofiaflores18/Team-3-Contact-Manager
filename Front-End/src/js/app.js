// --- LOGIN & SIGNUP ---
let accountCreated = false;

function goToSignup() {
  window.location.href = "signup.html";
}

function goToLogin() {
  sessionStorage.setItem("accountCreated", accountCreated.toString());
  window.location.href = "login.html";
}

function handleReturnFromSignup() {
  const accNotif = document.getElementById("accountCreatedNotif");
  accountCreated = sessionStorage.getItem("accountCreated") === "true";

  if (accountCreated) {
    accNotif.textContent = "You successfully created an account. Proceed to Log in.";
    accNotif.style.display = 'block';
  }
  sessionStorage.removeItem("accountCreated");
}

function handleLogin() {
  const email = document.getElementById("loginEmail").value.trim();
  const password = document.getElementById("loginPassword").value;

  document.getElementById("loginEmailError").innerText = "";
  document.getElementById("loginPasswordError").innerText = "";
  document.getElementById("loginServerError").innerText = "";

  if (!email || !password) {
    if (!email) document.getElementById("loginEmailError").innerText = "Email required";
    if (!password) document.getElementById("loginPasswordError").innerText = "Password required";
    return;
  }

  if (email && password) {
    localStorage.setItem("user", JSON.stringify({ email }));
    window.location.href = "contact.html";
  } else {
    document.getElementById("loginServerError").innerText = "Invalid login";
  }
}

function handleSignup() {
  const firstName = document.getElementById("firstName").value.trim();
  const lastName = document.getElementById("lastName").value.trim();
  const username = document.getElementById("signupUsername").value.trim();
  const email = document.getElementById("signupEmail").value.trim();
  const phoneNumber = document.getElementById("signupNumber").value.trim();
  const password = document.getElementById("signupPassword").value.trim();
  const error = document.getElementById("signupError");
  error.innerText = "";

  if (!firstName || !lastName || !username || !password || !email || !phoneNumber) {
    error.innerText = "All fields are required";
    return;
  }

  accountCreated = true;
  goToLogin();
}

// --- CONTACTS ---
// TODO: These two parts will probably need a rework when the API gets merged
let contacts = JSON.parse(localStorage.getItem("contacts")) || [];
// Only one contact can be edited or deleted at a time
let editIndex = null;

function saveContacts() {
  localStorage.setItem("contacts", JSON.stringify(contacts));
}

function openAddForm() {
  document.getElementById("addContactForm").classList.remove("hidden");
}

function closeAddForm() {
  document.getElementById("addContactForm").classList.add("hidden");
  clearAddForm();
}

function clearAddForm() {
  document.getElementById("addFirstName").value = "";
  document.getElementById("addLastName").value = "";
  document.getElementById("addEmail").value = "";
  document.getElementById("addPhone").value = "";
  document.getElementById("addError").innerText = "";
}

function submitAddContact() {
  const firstname = document.getElementById("addFirstName").value.trim();
  const lastname = document.getElementById("addLastName").value.trim();
  const email = document.getElementById("addEmail").value.trim();
  const phone = document.getElementById("addPhone").value.trim();
  const error = document.getElementById("addError");
  error.innerText = "";

  // Catch for if any of the fields are not filled in.
  if (!firstname || !lastname || !email || !phone) {
    error.innerText = "All fields required";
    return;
  }

  // TODO: This should be replaced with something that communicates with the db.
  contacts.push({
    firstName: firstname,
    lastName: lastname,
    email: email,
    phone: phone,
    date: new Date().toLocaleDateString()
  });

  saveContacts(); 
  closeAddForm();
  renderContacts();
}

// This creates the actual contact list division element to be displayed when
// Any of the CRUD elements are used--Add, Search, Edit, and Delete respectively
function renderContactItem(contact, index) {
  const div = document.createElement("div");
  div.className = "contact-item";

  // If editIndex is a value that correlates to someone in the list,
  // Then that contact is expanded into an edit form.
  if (editIndex === index) {
    const editForm = document.createElement("div");
    editForm.innerHTML = `
      <label>First Name</label>
      <input type="text" class="text-box" value="${contact.firstName}" id="editFirstName${index}">
      <label>Last Name</label>
      <input type="text" class="text-box" value="${contact.lastName}" id="editLastName${index}">
      <label>Email</label>
      <input type="text" class="text-box" value="${contact.email}" id="editEmail${index}">
      <label>Phone</label>
      <input type="text" class="text-box" value="${contact.phone}" id="editPhone${index}">
      <p class="error" id="editError${index}"></p>
      <button onclick="submitEditContact()">Save</button>
      <button onclick="cancelEditContact()" class="secondary">Cancel</button>
      <button onclick="openDeleteModal(${index})" style="color: darkred" class="secondary">Delete</button>
    `;
    div.appendChild(editForm);
  } else {
    // All other contacts are displayed like usual.
    const span = document.createElement("span");
    span.innerText = `${contact.firstName} ${contact.lastName} - ${contact.phone} - ${contact.email}`;

    const editButton = document.createElement("button");
    editButton.innerText = "Edit";
    editButton.onclick = () => {
      editIndex = index;
      renderContacts();
    };

    div.appendChild(span);
    div.appendChild(editButton);
  }

  return div;
}

function renderContacts(list = contacts) {
  const container = document.getElementById("contactList");
  const empty = document.getElementById("emptyMessage");

  container.innerHTML = "";

  if (!Array.isArray(list) || list.length === 0) {
    empty.style.display = "block";
    return;
  }

  empty.style.display = "none";

  list.forEach((contact, index) => {
    const contactDiv = renderContactItem(contact, index);
    container.appendChild(contactDiv);
  });
}

function cancelEditContact() {
  editIndex = null;
  renderContacts();
}

function submitEditContact() {
  // In case submit was somehow sent without a contact selected.
  if (editIndex === null) return;

  // Autofills the prompts with the current information for this index.
  const firstname = document.getElementById(`editFirstName${editIndex}`).value.trim();
  const lastname = document.getElementById(`editLastName${editIndex}`).value.trim();
  const email = document.getElementById(`editEmail${editIndex}`).value.trim();
  const phone = document.getElementById(`editPhone${editIndex}`).value.trim();
  const error = document.getElementById(`editError${editIndex}`);
  error.innerText = "";

  // Catch for if any of the fields are not filled in.
  if (!firstname || !lastname || !email || !phone) {
    error.innerText = "All fields required";
    return;
  }

  contacts[editIndex] = { ...contacts[editIndex],
    firstName: firstname,
    lastName: lastname,
    email: email,
    phone: phone
  };

  editIndex = null;
  saveContacts();
  renderContacts();
}

function openDeleteModal() {
  document.getElementById("deleteConfirmModal").classList.remove("hidden");
}

function closeDeleteModal() {
  document.getElementById("deleteConfirmModal").classList.add("hidden");
}

function confirmDelete() {
  contacts.splice(editIndex, 1);
  editIndex = null;
  saveContacts(); 
  closeDeleteModal();
  renderContacts();
}

// Gets the relevant contacts and presents them in the contact list container.
function searchContacts() {
  const query = document.getElementById("searchInput").value.toLowerCase();

  if (query === "") {
    renderContacts();
    return;
  }

  const matches = contacts.filter(contact =>
    `${contact.firstName} ${contact.lastName}`.toLowerCase().includes(query)
  );

  if (matches.length === 0) {
    document.getElementById("emptyMessage").innerText = "No contacts match your Search\n";
    return;
  }

  renderContacts(matches);
}

function signOut() {
  localStorage.removeItem("user");
  window.location.href = "login.html";
}

document.addEventListener("DOMContentLoaded", renderContacts);
