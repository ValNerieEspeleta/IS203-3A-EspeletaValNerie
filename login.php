<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'usermanagement');

    // Check user
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
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
    <h2>LOGIN FORM</h2>
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
