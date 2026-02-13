# Local Testing Guide

## For testing API end points on the virtual machine, use swaggerhub explore
Utilizing powershell because WSL has some IP address issues, feel free to use bash with ease if you are working on linux OS

### Locally testing signup on authenticate.php endpoint:
```powershell
curl.exe -X POST "http://localhost/Team-3-Contact-Manager/Back-End/authenticate.php" `
  -d "action=signup" `
  -d "firstname=Test" `
  -d "lastname=User" `
  -d "username=testuser123" `
  -d "email=testuser1@example.com" `
  -d "phone=555-1234" `
  -d "password=secret" `
  -c cookies.txt

```

### Locally testing creating contact on contacts.php endpoint:
```powershell
curl.exe -X POST "http://localhost/Team-3-Contact-Manager/Back-End/contacts.php" `
  -d "action=create" `
  -d "firstname=Test" `
  -d "lastname=User" `
  -d "email=testuser1@example.com" `
  -d "phone=555-1234" `
  -b cookies.txt

```

```bash
curl -X POST "http://localhost/Team-3-Contact-Manager/Back-End/authenticate.php" \
  -H "Content-Type: application/json" \
  -d '{
    "action": "signup",
    "firstname": "Test",
    "lastname": "User",
    "username": "testuser123",
    "email": "testuser1@example.com",
    "phone": "555-1234",
    "password": "secret"
  }'


```

