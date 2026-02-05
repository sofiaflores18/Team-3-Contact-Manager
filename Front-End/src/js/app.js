// ================== DATA ==================
let contacts = JSON.parse(localStorage.getItem("contacts")) || [];
let editIndex = null;
let deleteIndex = null;

// ================== HELPERS ==================
function saveContacts() {
  localStorage.setItem("contacts", JSON.stringify(contacts));
}

// ================== ADD CONTACT ==================
function openAddModal() {
  document.getElementById("addContactModal").classList.remove("hidden");
}

function closeAddModal() {
  document.getElementById("addContactModal").classList.add("hidden");
}

function submitAddContact() {
  const f = addFirstName.value.trim();
  const l = addLastName.value.trim();
  const e = addEmail.value.trim();
  const p = addPhone.value.trim();
  const error = document.getElementById("addError");
  error.innerText = "";

  if (!f || !l || !e || !p) {
    error.innerText = "All fields required";
    return;
  }

  contacts.push({ firstName: f, lastName: l, email: e, phone: p });
  saveContacts();
  closeAddModal();
  document.getElementById("contactAddedModal").classList.remove("hidden");
  renderContacts();
}

function closeContactAddedModal() {
  document.getElementById("contactAddedModal").classList.add("hidden");
}

// ================== RENDER ==================
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
    div.className = "contact-item";

    const span = document.createElement("span");
    span.innerText = `${c.firstName} ${c.lastName} - ${c.email}`;
    span.onclick = () => openEditModal(index);

    const delBtn = document.createElement("button");
    delBtn.innerText = "Delete";
    delBtn.onclick = (e) => {
      e.stopPropagation(); // prevents edit from opening
      openDeleteModal(index);
    };

    div.appendChild(span);
    div.appendChild(delBtn);
    container.appendChild(div);
  });
}

// ================== EDIT ==================
function openEditModal(index) {
  editIndex = index;
  const c = contacts[index];

  editFirstName.value = c.firstName;
  editLastName.value = c.lastName;
  editEmail.value = c.email;
  editPhone.value = c.phone;

  document.getElementById("editContactModal").classList.remove("hidden");
}

function closeEditModal() {
  document.getElementById("editContactModal").classList.add("hidden");
}

function submitEditContact() {
  const f = editFirstName.value.trim();
  const l = editLastName.value.trim();
  const e = editEmail.value.trim();
  const p = editPhone.value.trim();
  const error = document.getElementById("editError");
  error.innerText = "";

  if (!f || !l || !e || !p) {
    error.innerText = "All fields required";
    return;
  }

  contacts[editIndex] = { firstName: f, lastName: l, email: e, phone: p };
  saveContacts();
  closeEditModal();
  renderContacts();
}

// ================== DELETE ==================
function openDeleteModal() {
  deleteIndex = editIndex;
  document.getElementById("deleteConfirmModal").classList.remove("hidden");
}

function closeDeleteModal() {
  deleteIndex = null;
  document.getElementById("deleteConfirmModal").classList.add("hidden");
}

function confirmDelete() {
  contacts.splice(deleteIndex, 1);
  saveContacts();
  closeDeleteModal();
  closeEditModal();
  renderContacts();
}

// ================== SEARCH ==================
function searchContacts() {
  const query = searchInput.value.toLowerCase();
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

// ================== AUTH ==================
function signOut() {
  localStorage.removeItem("user");
  window.location.href = "login.html";
}

// ================== INIT ==================
document.addEventListener("DOMContentLoaded", renderContacts);
