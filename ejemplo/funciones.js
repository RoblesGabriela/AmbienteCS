function sendAjaxRequest(url, method, data, successCallback, errorCallback) {
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            successCallback(data);
        } else {
            errorCallback(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorCallback('An error occurred. Please try again.');
    });
}

function login(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    formData.append('action', 'login');

    sendAjaxRequest('process_user.php', 'POST', formData,
        function(data) {
            alert(data.message);
            window.location.href = 'dashboard.php';
        },
        function(errorMessage) {
            alert(errorMessage);
        }
    );
}

function register(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    formData.append('action', 'register');

    sendAjaxRequest('process_user.php', 'POST', formData,
        function(data) {
            alert(data.message);
            form.reset();
        },
        function(errorMessage) {
            alert(errorMessage);
        }
    );
}

function sendMessage(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    formData.append('action', 'send_message');

    sendAjaxRequest('process_user.php', 'POST', formData,
        function(data) {
            alert(data.message);
            form.reset();
        },
        function(errorMessage) {
            alert(errorMessage);
        }
    );
}

function updateProfile(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    formData.append('action', 'update_profile');

    sendAjaxRequest('process_user.php', 'POST', formData,
        function(data) {
            alert(data.message);
        },
        function(errorMessage) {
            alert(errorMessage);
        }
    );
}

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const messageForm = document.getElementById('message-form');
    const profileForm = document.getElementById('profile-form');

    if (loginForm) loginForm.addEventListener('submit', login);
    if (registerForm) registerForm.addEventListener('submit', register);
    if (messageForm) messageForm.addEventListener('submit', sendMessage);
    if (profileForm) profileForm.addEventListener('submit', updateProfile);
});
