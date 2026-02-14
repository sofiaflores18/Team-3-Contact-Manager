// API Utility Functions
//const API_BASE = 'http://165.245.135.60/Team-3-Contact-Manager/Back-End/';
const API_BASE = 'http://localhost/Team-3-Contact-Manager/Back-End/';

async function apiRequest(endpoint, data = {}) {
    try {
        const response = await fetch(API_BASE + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        // Get the response as text first so we can see what the server is saying(debugging)
        const text = await response.text();
        console.log("Raw Server Response:", text); 

        try {
            return JSON.parse(text);
        } catch (jsonError) {
            console.error('JSON Parse Error. The server sent back HTML/Text instead of JSON.');
            return { status: 'error', message: 'Server sent invalid response' };
        }
        
    } catch (error) {
        console.error('API Error:', error);
        return { status: 'error', message: 'Network error' };
    }
}


// Auth functions
async function signupAPI(userData) {
    const data = {
        action: 'signup',
        ...userData
    };
    return await apiRequest('authenticate.php', data);
}

async function loginAPI(loginData) {
    const data = {
        action: 'login',
        ...loginData
    };
    return await apiRequest('authenticate.php', data);
}


// Contact functions
async function createContactAPI(contactData) {
    const data = {
        action: 'create',
        ...contactData
    };
    return await apiRequest('contacts.php', data);
}

async function getContactsAPI(userId) {
    const data = {
        action: 'read',
        user_id: userId
    };
    return await apiRequest('contacts.php', data);
}

async function updateContactAPI(contactData) {
    const data = {
        action: 'update',
        ...contactData
    };
    return await apiRequest('contacts.php', data);
}


async function deleteContactAPI(contactId, userId) {
    const data = {
        action: 'delete',
        id: contactId,
        user_id: userId
    };
    return await apiRequest('contacts.php', data);
}

async function searchContactsAPI(userId, searchTerm) {
    const data = {
        action: 'search',
        user_id: userId,
        firstname: searchTerm
    };
    return await apiRequest('contacts.php', data);
}