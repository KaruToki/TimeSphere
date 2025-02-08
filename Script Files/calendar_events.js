document.addEventListener('DOMContentLoaded', function() {
    const year = 2025;
    const month = 2; // February

    loadCalendar(year, month);
});

function loadCalendar(year, month) {
    // Fetch events from the server
    fetchEvents(year, month).then(events => {
        renderCalendar(year, month, events);
    });
}

function fetchEvents(year, month) {
    return fetch(`fetch_events.php?year=${year}&month=${month}`)
        .then(response => response.json())
        .then(data => data.events);
}

function renderCalendar(year, month, events) {
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = '';

    const firstDay = new Date(year, month - 1, 1).getDay();
    const daysInMonth = new Date(year, month, 0).getDate();

    let dayCell;
    for (let i = 0; i < firstDay; i++) {
        dayCell = document.createElement('div');
        dayCell.classList.add('day-cell', 'empty');
        calendar.appendChild(dayCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        dayCell = document.createElement('div');
        dayCell.classList.add('day-cell');
        dayCell.innerHTML = `<span>${day}</span>`;
        calendar.appendChild(dayCell);
    }

    displayEvents(events);
}

function displayEvents(events) {
    const dayCells = document.querySelectorAll('.day-cell:not(.empty)');

    events.forEach(event => {
        const eventDate = new Date(event.start_date); // Assuming start_date is used
        const eventDay = eventDate.getDate();

        // Check that the event day is within the valid range of the current month
        if (eventDay >= 1) {
            const dayCell = dayCells[eventDay - 1]; // The correct day cell index is eventDay - 1
            dayCell.classList.add('event');
            const eventCategoryClass = getEventCategoryClass(event.activity_type); // Use activity_type
            dayCell.innerHTML += `<div class="event-title ${eventCategoryClass}">${event.event_name}</div>`;
        }
    });
}


function getEventCategoryClass(activityType) {
    // Categorizing by activity type
    switch (activityType) {
        case 'Meeting':
            return 'event-category-meeting';
        case 'Training':
            return 'event-category-training';
        case 'Orientation':
            return 'event-category-orientation';
        case 'Workshop':
            return 'event-category-workshop';
        case 'Awarding':
            return 'event-category-awarding';
        case 'Wellness':
            return 'event-category-wellness';
        case 'Other':
            return 'event-category-other';
        default:
            return ''; // Default class if no match
    }
}
