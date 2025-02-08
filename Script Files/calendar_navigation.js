document.addEventListener('DOMContentLoaded', function() {
    const yearPicker = document.getElementById('year-picker');
    const monthPicker = document.getElementById('month-picker');

    // Initialize the calendar with the current year and month
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    yearPicker.value = currentYear;
    monthPicker.value = currentMonth;

    loadCalendar(currentYear, currentMonth);
});

function loadCalendar(year, month) {
    // Fetch events from the server and handle errors
    fetchEvents(year, month).then(events => {
        renderCalendar(year, month, events);
    }).catch(error => {
        console.error('Error fetching events:', error);
    });
}

function fetchEvents(year, month) {
    return fetch(`fetch_events.php?year=${year}&month=${month}`)
        .then(response => response.json())
        .then(data => {
            // Handle empty or invalid data gracefully
            return Array.isArray(data.events) ? data.events : [];
        })
        .catch(err => {
            console.error('Error fetching events:', err);
            return [];
        });
}

function renderCalendar(year, month, events) {
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = '';

    const firstDay = new Date(year, month - 1, 1).getDay();
    const daysInMonth = new Date(year, month, 0).getDate();

    let dayCell;

    // Create empty day cells for days before the start of the month
    for (let i = 0; i < firstDay; i++) {
        dayCell = document.createElement('div');
        dayCell.classList.add('day-cell', 'empty');
        calendar.appendChild(dayCell);
    }

    // Create day cells for all days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        dayCell = document.createElement('div');
        dayCell.classList.add('day-cell');
        dayCell.innerHTML = `<span>${day}</span>`;
        calendar.appendChild(dayCell);
    }

    // Display events for the current month
    displayEvents(events);
}

function displayEvents(events) {
    const dayCells = document.querySelectorAll('.day-cell:not(.empty)');

    // Iterate through each event and associate it with the correct day
    events.forEach(event => {
        const eventDate = new Date(event.start_date);  // Use 'start_date' from the database
        const eventDay = eventDate.getDate();

        // Only display events that fall within the correct month
        if (eventDay >= 1 && eventDay <= dayCells.length) {
            const dayCell = dayCells[eventDay - 1]; // Event is associated with the correct day cell index
            dayCell.classList.add('event'); // Add the 'event' class to mark the day with an event

            // Get event details
            const eventTitle = event.event_name;
            const eventCategoryClass = getEventCategoryClass(event.program_owner);

            // Add event details inside the day cell
            dayCell.innerHTML += `
                <div class="event-title ${eventCategoryClass}">
                    <strong>${eventTitle}</strong><br>
                    <small>Location: ${event.location}</small><br>
                    <small>Memo Number: ${event.memo_number}</small>
                </div>`;
        }
    });
}

function prevMonth() {
    const yearPicker = document.getElementById('year-picker');
    const monthPicker = document.getElementById('month-picker');
    let year = parseInt(yearPicker.value);
    let month = parseInt(monthPicker.value);

    // Navigate to the previous month, adjust year if necessary
    if (month === 1) {
        month = 12;
        year -= 1;
    } else {
        month -= 1;
    }

    // Update the year and month values in the dropdowns
    yearPicker.value = year;
    monthPicker.value = month;

    // Ensure the year picker does not go below 2000
    if (year < 2000) {
        year = 2000;
        yearPicker.value = year;
    }

    loadCalendar(year, month);
}

function nextMonth() {
    const yearPicker = document.getElementById('year-picker');
    const monthPicker = document.getElementById('month-picker');
    let year = parseInt(yearPicker.value);
    let month = parseInt(monthPicker.value);

    // Navigate to the next month, adjust year if necessary
    if (month === 12) {
        month = 1;
        year += 1;
    } else {
        month += 1;
    }

    // Update the year and month values in the dropdowns
    yearPicker.value = year;
    monthPicker.value = month;

    // Ensure the year picker does not go above 2050
    if (year > 2050) {
        year = 2050;
        yearPicker.value = year;
    }

    loadCalendar(year, month);
}

function changeYear() {
    const year = parseInt(document.getElementById('year-picker').value);
    const month = parseInt(document.getElementById('month-picker').value);
    loadCalendar(year, month);
}

function changeMonth() {
    const year = parseInt(document.getElementById('year-picker').value);
    const month = parseInt(document.getElementById('month-picker').value);
    loadCalendar(year, month);
}

function getEventCategoryClass(owner) {
    // Categorize events by program owner
    switch (owner) {
        case 'Owner 1':
            return 'event-category-1';
        case 'Owner 2':
            return 'event-category-2';
        case 'Owner 3':
            return 'event-category-3';
        default:
            return 'event-category-default'; // Default class for uncategorized events
    }
}
