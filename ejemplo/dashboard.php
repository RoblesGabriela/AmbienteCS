<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <span id="user-name"></span>!</h1>
        <div id="dashboard-content">
            <h2>Your Dashboard</h2>
            <p>This is where you can add your dashboard content.</p>
        </div>
        <button id="logout-btn">Logout</button>
    </div>
    <script src="/js/app.js"></script>
    <script>
        // Check if user is logged in
        fetch('/src/controllers/UserController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=check_login'
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                window.location.href = 'login.html';
            } else {
                document.getElementById('user-name').textContent = data.name;
            }
        })
        .catch(error => console.error('Error:', error));

        // Logout functionality
        document.getElementById('logout-btn').addEventListener('click', function() {
            fetch('/src/controllers/UserController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=logout'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.html';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
