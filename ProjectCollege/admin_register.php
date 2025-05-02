<?php
include 'db.php';
include 'sidebar';

$email = $_POST['email'];
$phone = $_POST['phone'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check for existing username
$check_user = "SELECT * FROM admins WHERE username = '$username'";
$result = mysqli_query($conn, $check_user);

if (mysqli_num_rows($result) > 0) {
    echo "Username already exists. Please choose a different one. <a href='admin_register.html'>Try again</a>";
    exit;
}

// Secure password hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into admins table
$sql = "INSERT INTO admins (email, phone, username, password) 
        VALUES ('$email', '$phone', '$username', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    echo "Admin registered successfully. <a href='admin_login.html'>Login Now</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>