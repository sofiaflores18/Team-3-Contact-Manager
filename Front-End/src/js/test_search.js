
fetch("http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/read_contacts.php?user_id=1")
  .then(response => response.text())
  .then(data => console.log(data));

console.log("\n==========================================\n");
fetch("http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/search_for_contacts.php?user_id=1&firstname=Tristan")
  .then(response => response.text())
  .then(data => console.log(data));
