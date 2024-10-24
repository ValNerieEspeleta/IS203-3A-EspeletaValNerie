<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'usermanagement');

    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
        $redirect = true; // Flag to indicate redirection
    } else {
        $message = "Error: " . $conn->error;
    }
    
    $conn->close();
}
?>
<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #e9f5e9; /* Light green background */
        color: #333;
        margin: 0;
        padding: 20px;
    }

    /* Form Container */
    form {
        background: #ffffff; /* White background for form */
        border: 2px solid #4CAF50; /* Green border */
        border-radius: 10px; /* Rounded corners */
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
        max-width: 400px; /* Limit form width */
        margin: auto; /* Center the form */
    }

    /* Form Elements */
    input[type="text"], input[type="password"], select {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #4CAF50; /* Green border */
        border-radius: 5px; /* Rounded corners */
        font-size: 16px;
    }

    /* Button Styles */
    button {
        background-color: #4CAF50; /* Green background */
        color: white;
        border: none;
        border-radius: 5px; /* Rounded corners */
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049; /* Darker green on hover */
    }

    /* Headings */
    h2 {
        color: #4CAF50; /* Green color for headings */
        text-align: center; /* Center the heading */
    }

    /* Success Message */
    .message {
        color: #4CAF50; /* Green color for message */
        text-align: center;
        margin-top: 20px;
    }

    /* Responsive Styles */
    @media (max-width: 600px) {
        form {
            width: 100%; /* Full width on small screens */
            padding: 10px; /* Less padding */
        }

        input[type="text"], input[type="password"], select {
            width: 100%; /* Full width inputs */
        }
    }
</style>
<form method="POST" action="">
    <h2>REGISTRATION FORM</h2>
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Role: <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Register</button>
    
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
        <?php if (isset($redirect) && $redirect): ?>
            <script>
                setTimeout(function() {
                    window.location.href = 'login.php'; // Redirect to login page after 3 seconds
                }, 3000); // 3000 milliseconds = 3 seconds
            </script>
        <?php endif; ?>
    <?php endif; ?>
</form>
