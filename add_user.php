<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'usermanagement');

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ''; // Variable to store success/error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $profile_pic = $_FILES['profile_pic']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_pic);

    // Upload profile picture if provided
    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
        // Insert user into the database
        $sql = "INSERT INTO users (username, password, role, profile_pic) VALUES ('$username', '$password', '$role', '$target_file')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "User added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Failed to upload profile picture.";
    }
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

<h1>Add User</h1>
<a href="logout.php">Logout</a>

<form method="POST" enctype="multipart/form-data">
    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="role">Role:</label>
    <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <label for="profile_pic">Profile Picture:</label>
    <input type="file" name="profile_pic" accept="image/*">

    <button type="submit">Add User</button>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</form>
