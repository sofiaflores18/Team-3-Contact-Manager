// --- Updated Path to include /endpoints/ ---
const API_BASE = 'http://165.245.135.60/Team-3-Contact-Manager/API/endpoints/';

async function apiRequest(endpoint, method = 'POST', data = {}) {
    try {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
        };

        if (method !== 'GET') {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(API_BASE + endpoint, options);
        const text = await response.text();
        
        console.log("Raw Server Response:", text); 

        try {
            return JSON.parse(text);
        } catch (jsonError) {
            // This is where you see the red error because the text is HTML, not JSON
            console.error('JSON Parse Error. Ensure the file exists at: ' + API_BASE + endpoint, jsonError);
            return { status: 'error', message: 'Server sent invalid response' };
        }
    } catch (error) {
        console.error('API Error:', error);
        return { status: 'error', message: 'Network error' };
    }
}

// --- Auth functions ---
async function signupAPI(userData) {
    // This will now correctly hit /Back-End/endpoints/signup.php
    return await apiRequest('signup.php', 'POST', userData);
}

async function loginAPI(loginData) {
    // CHANGED: authenticate.php -> login.php to match your backend files
    return await apiRequest('login.php', 'POST', loginData);
}

// --- Contact functions ---
async function createContactAPI(contactData) {
    return await apiRequest('create_contact.php', 'POST', contactData);
}

async function getContactsAPI(userId, limit = 20, offset = 0) {
    const params = new URLSearchParams({
        user_id: userId,
        limit: limit,
        offset: offset
    });

    const response = await fetch(`${API_BASE}read_contacts.php?${params}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    });

    const text = await response.text();
    try {
        return JSON.parse(text);
    } catch (jsonError) {
        return [];
    }
}

async function updateContactAPI(contactData) {
    return await apiRequest('update_contact.php', 'PATCH', contactData);
}

async function deleteContactAPI(contactId, userId) {
    const data = { contact_id: contactId, user_id: userId };
    return await apiRequest('delete_contact.php', 'DELETE', data);
}

async function searchContactsAPI(userId, searchTerm) {
    const params = new URLSearchParams({
        user_id: userId,
        // Ensure backend expects 'firstname' or update to 'search'
        firstname: searchTerm 
    });
    
    const response = await fetch(`${API_BASE}search_for_contacts.php?${params}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    });
    
    const text = await response.text();
    try {
        return JSON.parse(text);
    } catch (jsonError) {
        return [];
    }
}
