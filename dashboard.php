<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'usermanagement');

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f4f8;
    color: #333;
    margin: 0;
    padding: 20px;
}

h1, h2 {
    color: #4a90e2;
    margin-bottom: 20px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 15px;
    text-align: left;
}

th {
    background-color: #4a90e2;
    color: white;
}

td {
    background-color: #ffffff;
    transition: background-color 0.3s;
}

td:hover {
    background-color: #f7f7f7;
}

/* Image Styles */
img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

/* Form Styles */
form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
}

input, select, button {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

button {
    background-color: #4a90e2;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #357ABD;
}

/* Responsive Styles */
@media (max-width: 600px) {
    body {
        padding: 10px;
    }

    table, th, td {
        display: block;
        width: 100%;
    }

    input, select, button {
        width: 100%;
    }
}
</style>
<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
<a href="logout.php">Logout</a>

<?php if ($_SESSION['role'] == 'admin') { ?>
    <a href="add_user.php">Add User</a>
    <h2>Users List</h2>
    <table>
        <tr><th>ID</th><th>Profile_pic</th><th>Username</th><th>Action</th></tr>
        <?php
       $result = $conn->query("SELECT * FROM users");
       while ($user = $result->fetch_assoc()) {
           // Set a default image if no profile picture is available
           $profile_pic = $user['profile_pic'] ? $user['profile_pic'] : 'uploads/default.png'; // Use a default image if none exists
       
           echo "<tr>
                   <td>{$user['id']}</td>
                   <td><img src='{$profile_pic}' alt='Profile Picture' width='50' height='50'></td>
                   <td>{$user['username']}</td>
                   <td>
                       <a href='edit_user.php?id={$user['id']}'>Edit</a> | 
                       <a href='delete_user.php?id={$user['id']}'>Delete</a>
                   </td>
                 </tr>";
       }
        ?>
    </table>
<?php } else { ?>
    <h2>Users List</h2>
    <table>
        <tr><th>ID</th><th>Profile_pic</th><th>Username</th></tr>
        <?php
        $result = $conn->query("SELECT id, username, profile_pic FROM users");
        while ($user = $result->fetch_assoc()) {
            // Set a default image if no profile picture is available
            $profile_pic = $user['profile_pic'] ? $user['profile_pic'] : 'uploads/default.png'; // Use a default image if none exists
            
            echo "<tr>
                    <td>{$user['id']}</td>
                    <td><img src='{$profile_pic}' alt='Profile Picture' width='50' height='50'></td>
                    <td>{$user['username']}</td>
                  </tr>";
        }
        ?>
    </table>
<?php } ?>

<h2>Your Profile</h2>
<p>Username: <?php echo $_SESSION['username']; ?></p>
