
<?php
$event_id = $_GET['event_id'];

// Database connection
$conn = new mysqli('localhost', 'username', 'password', 'timesphere_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM event_management WHERE id = $event_id";
$result = $conn->query($sql);

$event = $result->fetch_assoc();

echo json_encode($event);

$conn->close();
?>