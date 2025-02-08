<?php
session_start();
if (!isset($_SESSION['user_id']) && !isset($_GET['role'])) {
    header("Location: login.php");
    exit();
}

$role = isset($_GET['role']) ? 'GUEST_USER' : $_SESSION['role'];
$firstname = $_SESSION['firstname'] ?? 'Guest';
$lastname = $_SESSION['lastname'] ?? '';
$division = $_SESSION['division'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Sphere</title>
    <link rel="stylesheet" href="css designs/timesphere.css">
    <script src="Script Files/timesphere.js" defer></script> <!-- Correct path to the JS file -->
</head>
<body>
    <div class="top-bar">
        <button id="burger-icon" onclick="toggleSidebar()">☰</button>
                    <div class="user-info">
                        <p class="user-name"><?php echo $firstname . ' ' . $lastname; ?></p>
                        <p class="user-email"><?php echo strtolower(str_replace(' ', '', $firstname) . '.' . strtolower($lastname) . '@deped.gov.ph'); ?></p>
                        <p class="user-division"><?php echo $division; ?></p>
                        <p class="user-role"><?php echo $role; ?></p>
                    </div>
    
    </div>
    <div class="main-container">
        <div class="sidebar" id="sidebar">
            <nav>
                <?php if ($role != 'GUEST_USER'): ?>
                    <button onclick="selectDivision()">Select Division</button>
                    <button onclick="addEvent()">Add Event</button>
                    <button onclick="updateEvent()">Update Event</button>
                    <?php if ($role == 'SUPER_ADMIN' || $role == 'ADMIN'): ?>
                        <button onclick="checkUpdateRequest()">Check Update Request</button>
                    <?php endif; ?>
                    <button onclick="generateReport()">Generate Report</button>
                <?php endif; ?>
                <button onclick="viewPinnedEvents()">Pinned Events</button>
                <button id="theme-toggle">Toggle Dark Mode</button>
        </div>
            </nav>
            <button onclick="logout()" class="logout-button">Logout</button>
        </div>
        <div class="main-content-container">
            <div class="main-content">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button id="prev-month" onclick="prevMonth()">&lt;</button>
                        <h1 id="calendar-month-year"></h1>
                        <button id="next-month" onclick="nextMonth()">&gt;</button>
                    </div>
                    <div class="calendar" id="calendar"></div>
                </div>
                <div class="event-container">
                    <h2 id="event-title">Events</h2>
                    <div class="event-list" id="event-list"></div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Department of Education - Cordillera Administrative Region &copy; <?php echo date('Y'); ?> Karu Echiji Toki. Version 1</p>
    </footer>
</body>
</html>