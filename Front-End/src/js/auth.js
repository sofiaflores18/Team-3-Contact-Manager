function handleSignup() {
  const firstName = document.getElementById("firstName").value.trim();
  const lastName = document.getElementById("lastName").value.trim();
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("signupEmail").value.trim();
  const phoneNumber = document.getElementById("signupNumber").value.trim();
  const password = document.getElementById("password").value;

  const error = document.getElementById("signupError");
  error.innerText = "";

  if (!firstName || !lastName || !username || !password || !email || !phoneNumber) {
    error.innerText = "All fields are required";
    return;
  }

  // Fake signup success (frontend only)
  document.getElementById("successModal").classList.remove("hidden");
}

function goToLogin() {
  window.location.href = "login.html";
}

function goToSignup() {
  window.location.href = "signup.html";
}

function goToContact() {
  window.location.href = "contact.html";
}

