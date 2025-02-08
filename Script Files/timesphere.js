document.addEventListener('DOMContentLoaded', function() {
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;

    const yearPicker = document.getElementById('year-picker');
    yearPicker.classList.add('styled-dropdown'); // Add class for styling
    yearPicker.innerHTML = ''; // Clear existing options
    for (let year = 1990; year <= 2025; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.text = year;
        yearPicker.add(option);
    }
    yearPicker.value = currentYear;

    const monthPicker = document.getElementById('month-picker');
    monthPicker.classList.add('styled-dropdown'); // Add class for styling
    monthPicker.value = currentMonth;

    document.getElementById('theme-toggle').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });

    loadCalendar(currentYear, currentMonth);
});

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContentContainer = document.querySelector('.main-content-container');
    sidebar.classList.toggle('hidden');
    if (sidebar.classList.contains('hidden')) {
        mainContentContainer.style.marginLeft = '0';
    } else {
        mainContentContainer.style.marginLeft = '250px'; /* Adjust to match the width of the sidebar */
    }
}

function logout() {
    // Clear session and redirect to login page
    window.location.href = 'logout.php';
}

function selectDivision() {
    const division = document.getElementById('select-division').value;
    alert('Selected Division: ' + division);
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

function loadCalendar(year, month) {
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = ''; // Clear existing calendar content

    const firstDay = new Date(year, month - 1, 1).getDay();
    const daysInMonth = new Date(year, month, 0).getDate();

    // Create day cells
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.classList.add('day-cell');
        calendar.appendChild(emptyCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const dayCell = document.createElement('div');
        dayCell.classList.add('day-cell');
        dayCell.innerText = day;
        dayCell.onclick = () => showEventDetails(day);
        calendar.appendChild(dayCell);
    }

    // Highlight current date
    const today = new Date();
    const currentDayCell = calendar.children[firstDay + today.getDate() - 1];

    if (year === today.getFullYear() && month === today.getMonth() + 1) {
        // Check if the current day has events
        const eventsExist = checkIfCurrentDayHasEvents(today.getDate(), events); // Assuming `events` is available

        if (eventsExist) {
            currentDayCell.classList.add('current-date-event'); // Apply a different style if the current date has events
        } else {
            currentDayCell.classList.add('current-date'); // Apply default highlight style
        }
    }

    // Fetch events from the database and populate the calendar
    fetch(`fetch_events.php?year=${year}&month=${month}`)
        .then(response => response.json())
        .then(events => {
            events.forEach(event => {
                const eventDate = new Date(event.event_date).getDate();
                const eventCell = calendar.children[firstDay + eventDate - 1];
                eventCell.style.backgroundColor = event.color; // Set event color
                eventCell.title = event.event_name; // Set event name as tooltip
                eventCell.onclick = () => showEventDetails(event.id); // Show event details on click
            });
        });
}

// Function to check if the current day has events
function checkIfCurrentDayHasEvents(day, events) {
    return events.some(event => new Date(event.event_date).getDate() === day); // Check if any event matches the current day
}


function prevMonth() {
    // Logic to go to the previous month
}

function nextMonth() {
    // Logic to go to the next month
}

function changeYear() {
    const year = document.getElementById('year-picker').value;
    const month = document.getElementById('month-picker').value;
    loadCalendar(parseInt(year), parseInt(month));
}

function changeMonth() {
    const year = document.getElementById('year-picker').value;
    const month = document.getElementById('month-picker').value;
    loadCalendar(parseInt(year), parseInt(month));
}

function showEventDetails(eventId) {
    // Fetch event details from the database and display in modal
    fetch(`fetch_event_details.php?event_id=${eventId}`)
        .then(response => response.json())
        .then(event => {
            document.getElementById('modal-event-title').innerText = event.title;
            document.getElementById('modal-event-details').innerText = event.details;
            document.getElementById('event-modal').style.display = 'block';
        });
}

function closeModal() {
    document.getElementById('event-modal').style.display = 'none';
}

function editEvent() {
    // Logic to edit event
}

function deleteEvent() {
    // Logic to delete event
}