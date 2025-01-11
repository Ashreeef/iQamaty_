const totalUsersEl = document.getElementById('total-users');
const pendingReportsEl = document.getElementById('pending-reports');
const upcomingEventsEl = document.getElementById('upcoming-events');
const occupiedRoomsEl = document.getElementById('occupied-rooms');
const todaysMenuEl = document.getElementById('todays-menu');
const reportsChartCtx = document.getElementById('reportsChart').getContext('2d');
const categoryChartCtx = document.getElementById('categoryChart').getContext('2d');
const addTaskButton = document.getElementById('add-task-btn');
const taskInput = document.getElementById('task-input');
const taskList = document.getElementById('task-list');
const todayDayNameEl = document.getElementById('today-day-name');
const todayDateEl = document.getElementById('today-date');

// Set today's date and day name
const today = new Date();
const dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
const todayDayName = dayNames[today.getDay()];
todayDayNameEl.textContent = todayDayName;
todayDateEl.textContent = today.toLocaleDateString('en-GB');

// Load tasks from localStorage and display them
function loadTasks() {
    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
    tasks.forEach(task => appendTaskToDOM(task));
}

function appendTaskToDOM(task) {
    const taskRow = document.createElement('div');
    taskRow.className = 'task-row';
    taskRow.innerHTML = `
        <div class="info">
            <h3 class="mt-0 mb-5 fs-15">${task.text}</h3>
            <p class="m-0 c-grey">${task.description || 'No description'}</p>
        </div>
        <i class="fa fa-trash delete"></i>
    `;
    taskList.appendChild(taskRow);
}

// Add a task
addTaskButton.addEventListener('click', function () {
    const taskText = taskInput.value.trim();
    if (taskText !== '') {
        const task = {
            text: taskText,
            description: 'No description'
        };

        const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
        tasks.push(task);
        localStorage.setItem('tasks', JSON.stringify(tasks));

        appendTaskToDOM(task);
        taskInput.value = '';
    } else {
        alert('Please enter a task.');
    }
});

// Delete a task
taskList.addEventListener('click', function (event) {
    if (event.target.classList.contains('delete')) {
        const task = event.target.closest('.task-row');
        const taskText = task.querySelector('h3').textContent;
        task.remove();

        let tasks = JSON.parse(localStorage.getItem('tasks')) || [];
        tasks = tasks.filter(t => t.text !== taskText);
        localStorage.setItem('tasks', JSON.stringify(tasks));
    }
});

// Fetch Students -> Total Users
fetch('/iQamaty_10/app/Controllers/get_students.php')
.then(res => res.json())
.then(data => {
    if (data.message) {
        totalUsersEl.textContent = '0';
    } else if (Array.isArray(data)) {
        const students = data;
        // Total users = number of students
        totalUsersEl.textContent = students.length;
    }
})
.catch(() => {
    totalUsersEl.textContent = 'Error';
});

// Fetch Reports -> Pending Reports & Charts
let reportsData = [];
fetch('/iQamaty_10/app/Controllers/get_reports.php')
.then(res => res.json())
.then(data => {
    if (data.message) {
        pendingReportsEl.textContent = '0';
        return;
    }
    reportsData = Array.isArray(data) ? data : [];
    pendingReportsEl.textContent = reportsData.length.toString();
    updateCharts(reportsData);
})
.catch(() => {
    pendingReportsEl.textContent = 'Error';
});

// Fetch Events -> Upcoming Events
fetch('/iQamaty_10/app/Controllers/get_events.php')
.then(res => res.json())
.then(events => {
    if (events.message) {
        upcomingEventsEl.textContent = '0';
        return;
    }
    const now = new Date();
    const upcoming = events.filter(e => {
        const eventDate = new Date(e.EventDate);
        return eventDate > now;
    });
    upcomingEventsEl.textContent = upcoming.length.toString();
})
.catch(() => {
    upcomingEventsEl.textContent = 'Error';
});

// Fetch Menu -> Today's Menu
fetch('/iQamaty_10/app/Controllers/menu.php')
.then(res => res.json())
.then(menuData => {
    const todayMenu = menuData[todayDayName] || [];
    todaysMenuEl.innerHTML = '';
    if (todayMenu.length === 0) {
        todaysMenuEl.innerHTML = '<li>No menu available for today.</li>';
    } else {
        todayMenu.forEach(meal => {
            const {name, content} = meal;
            const li = document.createElement('li');
            li.innerHTML = `<strong>${name}:</strong> ${content.main}, ${content.secondary}, ${content.dessert}`;
            todaysMenuEl.appendChild(li);
        });
    }
})
.catch(() => {
    todaysMenuEl.innerHTML = '<li>Error loading menu.</li>';
});

// Fetch Rooms -> Occupied Rooms count
fetch('/iQamaty_10/app/Controllers/get_rooms.php')
.then(res => res.json())
.then(rooms => {
    if (rooms.message) {
        occupiedRoomsEl.textContent = '0/0';
        return;
    }
    const totalRooms = rooms.length;
    const occupiedCount = rooms.filter(r => r.Occupied == 1).length;
    occupiedRoomsEl.textContent = `${occupiedCount}/${totalRooms}`;
})
.catch(() => {
    occupiedRoomsEl.textContent = 'Error';
});

// Charts
let reportsChart;
let categoryChart;

function updateCharts(reports) {
    // Reports Over Time: group by month-year
    const monthlyCounts = {};
    reports.forEach(r => {
        const d = new Date(r.Date);
        const key = `${d.getFullYear()}-${d.getMonth()+1}`; // YYYY-M
        monthlyCounts[key] = (monthlyCounts[key] || 0) + 1;
    });

    const sortedKeys = Object.keys(monthlyCounts).sort();
    const reportsOverTimeData = {
        labels: sortedKeys,
        datasets: [{
            label: 'Reports',
            data: sortedKeys.map(k => monthlyCounts[k]),
            backgroundColor: 'rgba(59,130,246,0.2)',
            borderColor: 'rgba(59,130,246,1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    // Reports by Category
    const categoryCounts = {};
    reports.forEach(r => {
        categoryCounts[r.Category] = (categoryCounts[r.Category] || 0) + 1;
    });
    const categoryLabels = Object.keys(categoryCounts);
    const categoryValues = categoryLabels.map(l => categoryCounts[l]);
    const categoryData = {
        labels: categoryLabels,
        datasets: [{
            data: categoryValues,
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#ef4444',
                '#f59e0b',
                '#6366f1',
                '#ec4899',
                '#6b7280'
            ]
        }]
    };

    // Update or create charts
    if (reportsChart) {
        reportsChart.destroy();
    }
    reportsChart = new Chart(reportsChartCtx, {
        type: 'line',
        data: reportsOverTimeData,
        options: {
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    if (categoryChart) {
        categoryChart.destroy();
    }
    categoryChart = new Chart(categoryChartCtx, {
        type: 'doughnut',
        data: categoryData,
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

// Load tasks on page load
window.onload = loadTasks;
