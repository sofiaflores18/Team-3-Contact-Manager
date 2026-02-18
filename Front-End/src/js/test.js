fetch("http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/me.php?user_id=1")
  .then(response => response.text())
  .then(data => console.log(data));


fetch("http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/login.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
	    username: "testuser",
	    password: "password"
    })
})
.then(response => response.json())
.then(data => {
    console.log(data);
})
.catch(error => {
    console.error("Error:", error);
});


fetch("http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/search_for_contacts.php?user_id=1&firstname=''")
  .then(response => response.text())
  .then(data => console.log(data));
