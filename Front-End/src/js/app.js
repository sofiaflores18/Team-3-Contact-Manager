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
let contacts = JSON.parse(localStorage.getItem("contacts")) || [];
let editIndex = null;
let deleteIndex = null;

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
  saveContacts(); 
  closeAddForm();
  clearAddForm();
  renderContacts();
}




function openEditForm(index) {
  editIndex = index;
  const c = contacts[index];
  document.getElementById("editFirstName").value = c.firstName;
  document.getElementById("editLastName").value = c.lastName;
  document.getElementById("editEmail").value = c.email;
  document.getElementById("editPhone").value = c.phone;
  document.getElementById("editContactForm").classList.remove("hidden");
}

function closeEditForm() {
  document.getElementById("editContactForm").classList.add("hidden");
  clearEditForm();
}

function clearEditForm() {
  document.getElementById("editFirstName").value = "";
  document.getElementById("editLastName").value = "";
  document.getElementById("editEmail").value = "";
  document.getElementById("editPhone").value = "";
  document.getElementById("editError").innerText = "";
}

function renderContacts(list = contacts) {
  const container = document.getElementById("contactList");
  const empty = document.getElementById("emptyMessage");

  container.innerHTML = "";

  if (list.length === 0) {
    empty.style.display = "block";
    return;
  }

  empty.style.display = "none";

  list.forEach((c, index) => {
    const div = document.createElement("div");
    div.className = "contact-item";

    const span = document.createElement("span");
    span.innerText = `${c.firstName} ${c.lastName} - ${c.phone} -${c.email}`;
    span.onclick = () => openEditForm(index); 

    const delBtn = document.createElement("button");
    delBtn.innerText = "Delete";
    delBtn.onclick = (e) => {
      e.stopPropagation();
      openDeleteModal(index); 
    };

    div.appendChild(span);
    div.appendChild(delBtn);
    container.appendChild(div);
  });
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
  saveContacts(); 
  closeEditForm();
  renderContacts();
}

function openDeleteModal(index) {
  deleteIndex = index;
  document.getElementById("deleteConfirmModal").classList.remove("hidden");
}

function closeDeleteModal() {
  document.getElementById("deleteConfirmModal").classList.add("hidden");
}

function confirmDelete() {
  contacts.splice(deleteIndex, 1);
  saveContacts(); 
  closeDeleteModal();
  renderContacts();
}


function searchContacts() {
  const query = document.getElementById("searchInput").value.toLowerCase();
  const container = document.getElementById("contactList");

  if (query === "") {
    renderContacts();
    return;
  }

  const matches = contacts.filter(c =>
    `${c.firstName} ${c.lastName}`.toLowerCase().includes(query)
  );

  if (matches.length === 0) {
    container.innerHTML = `<p class="error">No contacts match your search.</p>`;
    return;
  }

  renderContacts(matches);
}

function signOut() {
  localStorage.removeItem("user");
  window.location.href = "login.html";
}

document.addEventListener("DOMContentLoaded", renderContacts);