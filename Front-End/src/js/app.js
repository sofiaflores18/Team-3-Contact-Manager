// --- LOGIN & SIGNUP ---
// Parameters
let accountCreated = false;

// Functions
function goToSignup() {
  window.location.href = "signup.html";
}

function goToLogin() {
  sessionStorage.setItem("accountCreated", accountCreated.toString());
  window.location.href = "login.html";
}

// Use to display a message to the user upon returning to login.html
// Handles successful and unsuccessful account creation.
function handleReturnFromSignup() {
  const accNotif = document.getElementById("accountCreatedNotif");
  accountCreated = sessionStorage.getItem("accountCreated") === "true";

  if (accountCreated) {
    accNotif.textContent = "You successfully created an account. Proceed to Log in.";
    accNotif.style.display = 'block';
  }
  else {
    // Nothing to do
  }
  sessionStorage.removeItem("accountCreated"); // Prevents false positives
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

  // Fake login
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
  const password = document.getElementById("signupPassword").value.trim();
  const error = document.getElementById("signupError");
  error.innerText = "";

  if (!firstName || !lastName || !username || !password) {
    error.innerText = "All fields are required";
    return;
  }

  // More should go here that actually creates the account in the DB.
  accountCreated = true; // This is used upon redirect to login.html

  // This line below need to be replaced or removed, as well as its references.
  // handleReturnFromSignup() fulfills it's job in a less intrusive manner.
  document.getElementById("signupSuccessModal").classList.remove("hidden");
}

// --- CONTACTS ---
let contacts = [];
let editIndex = null;

function openAddModal() {
  document.getElementById("addContactModal").classList.remove("hidden");
}

function closeAddModal() {
  document.getElementById("addContactModal").classList.add("hidden");
}

function submitAddContact() {
  const f = document.getElementById("addFirstName").value.trim();
  const l = document.getElementById("addLastName").value.trim();
  const e = document.getElementById("addEmail").value.trim();
  const p = document.getElementById("addPhone").value.trim();
  const error = document.getElementById("addError");
  error.innerText = "";

  if (!f || !l || !e || !p) {
    error.innerText = "All fields required";
    return;
  }

  contacts.push({ firstName: f, lastName: l, email: e, phone: p, date: new Date().toLocaleDateString() });
  closeAddModal();
  document.getElementById("contactAddedModal").classList.remove("hidden");
  renderContacts();
}

function closeContactAddedModal() {
  document.getElementById("contactAddedModal").classList.add("hidden");
}

// --- RENDER CONTACT LIST ---
function renderContacts() {
  const list = document.getElementById("contactList");
  const empty = document.getElementById("emptyMessage");
  list.innerHTML = "";
  if (contacts.length === 0) {
    empty.style.display = "block";
    return;
  }
  empty.style.display = "none";
  contacts.forEach((c, index) => {
    const div = document.createElement("div");
    div.className = "contact-item";
    div.innerText = `${c.firstName} ${c.lastName} - ${c.email}`;
    div.onclick = () => openEditModal(index);
    list.appendChild(div);
  });
}

// --- EDIT CONTACT ---
function openEditModal(index) {
  editIndex = index;
  const c = contacts[index];
  document.getElementById("editFirstName").value = c.firstName;
  document.getElementById("editLastName").value = c.lastName;
  document.getElementById("editEmail").value = c.email;
  document.getElementById("editPhone").value = c.phone;
  document.getElementById("editContactModal").classList.remove("hidden");
}

function closeEditModal() {
  document.getElementById("editContactModal").classList.add("hidden");
}

function submitEditContact() {
  const f = document.getElementById("editFirstName").value.trim();
  const l = document.getElementById("editLastName").value.trim();
  const e = document.getElementById("editEmail").value.trim();
  const p = document.getElementById("editPhone").value.trim();
  const error = document.getElementById("editError");
  error.innerText = "";

  if (!f || !l || !e || !p) {
    error.innerText = "All fields required";
    return;
  }

  contacts[editIndex] = { ...contacts[editIndex], firstName: f, lastName: l, email: e, phone: p };
  closeEditModal();
  renderContacts();
}

// --- DELETE CONTACT ---
let deleteIndex = null;
function openDeleteModal(index) {
  deleteIndex = index;
  document.getElementById("deleteConfirmModal").classList.remove("hidden");
}

function closeDeleteModal() {
  document.getElementById("deleteConfirmModal").classList.add("hidden");
}

function confirmDelete() {
  contacts.splice(deleteIndex, 1);
  closeDeleteModal();
  renderContacts();
}

// --- SEARCH ---
function searchContacts() {
  const query = document.getElementById("searchInput").value.toLowerCase();
  const list = document.getElementById("contactList");
  list.innerHTML = "";
  contacts.forEach((c, index) => {
    const fullName = `${c.firstName} ${c.lastName}`.toLowerCase();
    if (fullName.includes(query) || c.email.toLowerCase().includes(query)) {
      const div = document.createElement("div");
      div.className = "contact-item";
      div.innerText = `${c.firstName} ${c.lastName} - ${c.email}`;
      div.onclick = () => openEditModal(index);
      list.appendChild(div);
    }
  });
}

// --- SIGN OUT ---
function signOut() {
  localStorage.removeItem("user");
  window.location.href = "login.html";
}

// Render initially
document.addEventListener("DOMContentLoaded", renderContacts);
