<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timesphere_db"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a user
function createUser($conn, $firstname, $middlename, $lastname, $division, $password, $role) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (firstname, middlename, lastname, division, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $middlename, $lastname, $division, $hashedPassword, $role);
    $stmt->execute();
    $stmt->close();
}

// Create users
createUser($conn, "Super", "Admin", "User", "IT Division", "superadminpassword", "SUPER_ADMIN");
createUser($conn, "Admin", "User", "One", "HRDD", "adminpassword", "ADMIN");
createUser($conn, "Standard", "User", "Two", "FINANCE", "standardpassword", "STANDARD_USER");
createUser($conn, "Guest", "User", "Three", "ESSD", "guestpassword", "GUEST_USER");
createUser($conn, "Carl Elton", "Payang", "Temporal", "FTAD", "Badiwan@123!", "SUPER_ADMIN"); // Add your user
createUser($conn, "Janette", "Orangon", "Payang", "ORD", "Poblacion", "SUPER_ADMIN"); // Add your user

echo "Users created successfully";

$conn->close();
?>