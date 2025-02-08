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
    <link rel="stylesheet" href="css designs/Main_Title.css"> <!-- Main title CSS -->
    <link rel="stylesheet" href="css designs/calendar_events.css"> <!-- Calendar and event styling -->
    <link rel="stylesheet" href="Styles/styles.css"> <!-- General styles -->
    <link rel="stylesheet" href="css designs/calendar_navigation.css"> <!-- Link to the new CSS file -->
    <script src="Script Files/timesphere.js" defer></script> <!-- JS for functionality -->
    <script src="Script Files/calendar_events.js" defer></script> <!-- JS for calendar -->
    <script src="Script Files/calendar_navigation.js" defer></script> <!-- JS for navigation -->
</head>
<body>
    <div class="top-bar">
        <button id="burger-icon" onclick="toggleSidebar()">☰</button>
        <h1 class="main-title">DepEd CAR TimeSphere</h1>
    </div>
    <div class="main-container">
        <div class="sidebar" id="sidebar">
            <div class="user-info">
                <p class="user-name"><?php echo $firstname . ' ' . $lastname; ?></p>
                <p class="user-email"><?php echo strtolower(str_replace(' ', '', $firstname) . '.' . strtolower($lastname) . '@deped.gov.ph'); ?></p>
                <p class="user-division"><?php echo $division; ?></p>
                <p class="user-role"><?php echo $role; ?></p>
            </div>
            <nav>
                <?php if ($role != 'GUEST_USER'): ?>
                    <p>Select Division Calendar:</p>
                    <select id="select-division" onchange="selectDivision()">
                        <option value="">All</option>
                        <option value="FTAD">FTAD</option>
                        <option value="PPRD">PPRD</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="FINANCE">FINANCE</option>
                        <option value="QAD">QAD</option>
                        <option value="HRDD">HRDD</option>
                        <option value="ORD">ORD</option>
                        <option value="ESSD">ESSD</option>
                        <option value="ADMIN.RECORDS">ADMIN.RECORDS</option>
                        <option value="ADMIN.PAYROLL">ADMIN.PAYROLL</option>
                        <option value="ADMIN.GENERAL SERVICES UNIT">ADMIN.GENERAL SERVICES UNIT</option>
                        <option value="ADMIN.PERSONNEL">ADMIN.PERSONNEL</option>
                        <option value="ADMIN.SUPPLY">ADMIN.SUPPLY</option>
                        <option value="ORD.ICTU">ORD.ICTU</option>
                        <option value="ORD.PAU">ORD.PAU</option>
                        <option value="ORD.LU">ORD.LU</option>
                    </select>
                    <button onclick="addEvent()">Add Event</button>
                    <button onclick="updateEvent()">Update Event</button>
                    <?php if ($role == 'SUPER_ADMIN' || $role == 'ADMIN'): ?>
                        <button onclick="checkUpdateRequest()">Check Update Request</button>
                    <?php endif; ?>
                    <button onclick="generateReport()">Generate Report</button>
                <?php endif; ?>
                <button onclick="viewPinnedEvents()">Pinned Events</button>
                <button id="theme-toggle" onclick="toggleDarkMode()">Toggle Dark Mode</button>
            </nav>
            <button onclick="logout()" class="logout-button">Logout</button>
        </div>
        <div class="main-content-container">
            <div class="main-content">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button id="prev-month" onclick="prevMonth()">&lt;</button>
                        <select id="year-picker" onchange="changeYear()">
                            <?php 
                                $startYear = 2015;
                                $endYear = 2050;
                                for ($year = $startYear; $year <= $endYear; $year++): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select id="month-picker" onchange="changeMonth()">
                            <?php for ($month = 1; $month <= 12; $month++): ?>
                                <option value="<?php echo $month; ?>"><?php echo date('F', mktime(0, 0, 0, $month, 10)); ?></option>
                            <?php endfor; ?>
                        </select>
                        <button id="next-month" onclick="nextMonth()">&gt;</button>
                    </div>
                    <div class="calendar-days">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>
                    <div class="calendar" id="calendar"></div> <!-- Event days will be appended here -->
                </div>
                <div class="event-container">
                    <h2 id="event-title">Events</h2>
                    <div class="event-list" id="event-list"></div> <!-- Display upcoming events here -->
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Department of Education - Cordillera Administrative Region &copy; <?php echo date('Y'); ?> Karu Echiji Toki. Version 1</p>
    </footer>
</body>
</html>
