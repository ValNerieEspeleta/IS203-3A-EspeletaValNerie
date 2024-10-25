<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'usermanagement');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the URL
$user_id = $_GET['id'] ?? null;

if ($user_id) {
    // Prepare and execute the delete statement
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect to the users list with a success message
        header("Location: dashboard.php?message=User deleted successfully");
        exit();
    } else {
        // Redirect with an error message
        header("Location: dashboard.php?message=Error deleting user");
        exit();
    }

    $stmt->close();
} else {
    // Redirect if no user ID was provided
    header("Location: dashboard.php?message=Invalid user ID");
    exit();
}

$conn->close();
?>
