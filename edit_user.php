<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'usermanagement');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_GET['id'] ?? $_SESSION['user_id']; // For user profile
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $profile_pic = $_FILES['profile_pic'];

    // Check if a file was uploaded
    if ($profile_pic['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Directory to save uploaded files
        $file_name = basename($profile_pic['name']);
        $target_file = $upload_dir . $file_name;
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (in_array($profile_pic['type'], $allowed_types)) {
    // proceed with the upload
} else {
    echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
}
        // Move the uploaded file to the desired directory
        if (move_uploaded_file($profile_pic['tmp_name'], $target_file)) {
            // File upload was successful
            $sql = "UPDATE users SET username='$username', profile_pic='$target_file' WHERE id=$user_id";
        } else {
            echo "Error uploading file.";
        }
    } else {
        // If no file was uploaded, just update the username
        $sql = "UPDATE users SET username='$username' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    Username: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
    Profile Picture: <input type="file" name="profile_pic"><br>
    <button type="submit">Update</button>
</form>
