document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('theme-toggle').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });

    // Initialize calendar (simple example)
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = '<h2>Calendar</h2><p>Calendar content goes here...</p>';
});

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('hidden');
}

function logout() {
    // Clear session and redirect to login page
    window.location.href = 'logout.php';
}

function selectDivision() {
    alert('Select Division functionality');
}

function addEvent() {
    alert('Add Event functionality');
}

function updateEvent() {
    alert('Update Event functionality');
}

function checkUpdateRequest() {
    alert('Check Update Request functionality');
}

function generateReport() {
    alert('Generate Report functionality');
}

function viewPinnedEvents() {
    alert('View Pinned Events functionality');
}