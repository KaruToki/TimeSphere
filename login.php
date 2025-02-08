<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timesphere_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, firstname, middlename, lastname, division, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $firstname, $middlename, $lastname, $division, $hashedPassword, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['middlename'] = $middlename;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['division'] = $division;
        $_SESSION['role'] = $role;
        echo "Login successful. Redirecting...";
        header("Location: timesphere.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css designs\login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>

<body>
    <div id="particles-js"></div>
    <video autoplay muted loop id="background-video">
        <source src="mp4 files/portrain raining.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="title-container">
        <h1>Regional Office Time Sphere</h1>
        <!--<img src="svg files\calendar-and-clock-svgrepo-com.svg" alt="Illustration" class="line-art">-->
    </div>
    <div class="animation-container">
        <div id="lottie-animation"></div>
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="login-button-group">
                <button type="submit">Login</button>
                <button class="view-calendar-button" onclick="window.location.href='timesphere.php?role=guest'">View Calendar</button>
                <button id="theme-toggle" type="button">Toggle Dark/Light Mode</button>
            </div>
        </form>
    </div>

    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'json files\particles.json' // Replace with the path to your Lottie animation file
        });

        particlesJS.load('particles-js', 'json files/particles.json', function() {
            console.log('particles.js loaded - callback');
        });

        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>
