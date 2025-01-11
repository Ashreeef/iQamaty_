let events = [];
const notificationContainer = document.getElementById('notification-container');

// Display notifications
function showNotification(message, type = 'success') {
  const notification = document.createElement('div');
  notification.className = `notification ${type}`;
  notification.innerText = message;

  notificationContainer.appendChild(notification);

  setTimeout(() => {
    notification.classList.add('fade-out');
    setTimeout(() => notification.remove(), 500);
  }, 3000);
}

// Fetch existing events
function fetchExistingEvents() {
  fetch('/iQamaty_10/app/Controllers/get_events.php')
    .then(response => response.json())
    .then(data => {
      events = data;
      renderEvents(events);
    })
    .catch(error => {
      console.error("Error fetching events:", error);
      const tbody = document.querySelector('.existing-events table tbody');
      tbody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center">Error fetching events. Please try again later.</td>
        </tr>
      `;
    });
}

// Render events in the table
function renderEvents(events) {
  const tbody = document.querySelector('.existing-events table tbody');
  tbody.innerHTML = '';

  if (events.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="text-center">No events found.</td>
      </tr>
    `;
    return;
  }

  events.forEach(event => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${event.EventName}</td>
      <td>${new Date(event.EventDate).toLocaleDateString('en-GB')}</td>
      <td>${event.EventLocation}</td>
      <td>${event.EventDetails}</td>
      <td>${event.EventFormLink ? `<a href="${event.EventFormLink}" target="_blank">Form Link</a>` : 'N/A'}</td>
      <td>
        <a href="javascript:void(0)" class="delete-btn" onclick="deleteEvent(event, ${event.EventID})">Delete</a>
      </td>
    `;
    tbody.appendChild(row);
  });
}

// Handle event form submission
document.getElementById('event-form').addEventListener('submit', async function (e) {
  e.preventDefault();

  const form = e.target;
  const name = document.getElementById("event-name").value.trim();
  const picture = document.getElementById("event-picture").value.trim();
  const link = document.getElementById("event-link").value.trim();
  const location = document.getElementById("event-location").value.trim();
  const description = document.getElementById('event-description').value.trim();
  const date = document.getElementById('event-date').value.trim();

  let errors = [];

  // Form validation
  if (name === "") errors.push("Name is required.");
  if (!/^[a-zA-Z\s]+$/.test(name)) errors.push("Invalid name format.");
  if (description === "") errors.push("Description is required.");
  if (location === "") errors.push("Location is required.");
  if (!/^[a-zA-Z\s]+$/.test(location)) errors.push("Invalid location format.");
  if (date === "") errors.push("Event date is required.");

  if (errors.length > 0) {
    Swal.fire({
      icon: "error",
      title: "Form errors",
      html: `<ul style="text-align: left; padding-left: 20px;">
                ${errors.map(error => `<li>${error}</li>`).join('')}
             </ul>`,
    });
    return;
  }

  // Prepare form data
  const formData = new FormData();
  formData.append("event-name", name);
  formData.append("event-location", location);
  formData.append("event-description", description);
  formData.append("event-date", date);
  formData.append("event-link", link || "");
  formData.append("event-picture", picture);

  // Handle file upload (if any)
  const fileInput = document.getElementById("event-picture");
  const file = fileInput?.files[0];
  if (file) {
    formData.append('event-picture', file);
  }

  // Send the form data to the server
  try {
    const response = await fetch('/iQamaty_10/app/Controllers/add_event.php', {
      method: 'POST',
      body: formData
    });

    const data = await response.json();
    if (data.success) {
      showNotification(data.message, 'success');
      form.reset();
      fetchExistingEvents(); // Refresh the event list
    } else {
      showNotification(data.message, 'error');
    }
  } catch (error) {
    console.error("Error submitting event:", error);
    showNotification('An error occurred while creating the event.', 'error');
  }
});

// Handle event deletion
function deleteEvent(e, eventID) {
  e.preventDefault(); // to prevent scrolling to top
  Swal.fire({
    title: 'Are you sure you want to delete this event?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/iQamaty_10/app/Controllers/delete_event.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `EventID=${eventID}`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showNotification(data.message, 'success');
            events = events.filter(event => event.EventID !== eventID);
            renderEvents(events);
          } else {
            showNotification(data.message, 'error');
          }
        })
        .catch(error => {
          console.error("Error deleting event:", error);
          showNotification('An error occurred while deleting the event.', 'error');
        });
    }
  });
}

// Fetch events on page load
document.addEventListener('DOMContentLoaded', fetchExistingEvents);
