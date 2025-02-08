<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timesphere_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $error_message = json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    file_put_contents('logs/fetch_event_log.txt', $error_message . PHP_EOL, FILE_APPEND);  // Log connection error
    die($error_message);  // Terminate the script and show the error message
}

// Log successful connection
file_put_contents('logs/fetch_event_log.txt', "Connected to the database successfully.\n", FILE_APPEND);

// Prepare the SQL query to fetch all events (no filtering by year or month)
$sql = "SELECT event_name, start_date, end_date, program_owner, location, memo_number 
        FROM event_management";

// Prepare the query
$stmt = $conn->prepare($sql);

// Check for any query preparation errors
if ($stmt === false) {
    $error_message = json_encode(['error' => 'Query preparation failed: ' . $conn->error]);
    file_put_contents('logs/fetch_event_log.txt', $error_message . PHP_EOL, FILE_APPEND);  // Log query preparation error
    exit($error_message);
}

// Log successful query preparation
file_put_contents('logs/fetch_event_log.txt', "Query prepared successfully: $sql\n", FILE_APPEND);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if any events are found
if ($result->num_rows > 0) {
    // Fetch all events
    $events = $result->fetch_all(MYSQLI_ASSOC);
    $response = json_encode(['events' => $events]);

    // Log the fetched events data
    file_put_contents('logs/fetch_event_log.txt', "Fetched events: " . json_encode($events) . PHP_EOL, FILE_APPEND);
} else {
    // If no events are found, return a message
    $response = json_encode(['message' => 'No events found.']);
    
    // Log the message when no events are found
    file_put_contents('logs/fetch_event_log.txt', "No events found.\n", FILE_APPEND);
}

// Log the final response (either events or no events)
file_put_contents('logs/fetch_event_log.txt', "Response: $response\n", FILE_APPEND);

// Close the statement and the connection
$stmt->close();
$conn->close();

// Output the response (so the client can still receive it)
echo $response;
?>
