// Declare events array globally
let events = [];

// Fetch events from the database via the PHP API
fetch('../../app/Controllers/get_events.php')
  .then(response => response.json())
  .then(data => {
    events = data; // Store the fetched events in the global variable
    // Render the events
    renderEvents(events);
  })
  .catch(error => {
    console.error("Error fetching events:", error);
  });

// Function to render events in HTML
function renderEvents(events) {
  const eventContainer = document.getElementById('events-container');
  eventContainer.innerHTML = ''; // Clear previous events

  events.forEach((event, index) => {
    const eventBox = document.createElement('div');
    eventBox.className = 'event-box';

    eventBox.innerHTML = `
      <img src="${event.EventPicture}" alt="${event.EventName}">
      <h3>${event.EventName}</h3>
      <p>${new Date(event.EventDate).toLocaleDateString('en-GB')}</p>
      <button class="button details-btn" onclick="showEventDetails(${index})">View Details</button>
    `;

    eventContainer.appendChild(eventBox);
  });

  ScrollReveal().reveal('.event-box', {
    distance: '50px',
    origin: 'bottom',
    interval: 200,
    duration: 800,
  });
}

// Function to show event details in a modal
function showEventDetails(index) {
  const modal = document.getElementById('event-modal');
  const event = events[index]; // Access the global events array and get the event by index

  // Populate modal content with event details
  document.getElementById('modal-title').innerText = event.EventName;
  document.getElementById('modal-date').innerText = `Date: ${new Date(event.EventDate).toLocaleDateString('en-GB')}`;
  document.getElementById('modal-location').innerText = `Location: ${event.EventLocation}`;
  document.getElementById('modal-description').innerText = event.EventDetails;

  // Handle registration button visibility and link
  const registerBtn = document.getElementById('register-btn');
  if (event.EventFormLink && event.EventFormLink.trim() !== "") {
    registerBtn.style.display = 'inline-block';
    registerBtn.href = event.EventFormLink; 
    registerBtn.target = "_blank";
    registerBtn.innerHTML = `<span>Register</span>`;
  } else {
    registerBtn.style.display = 'none'; // Hide if no link is provided
  }

  // Show the modal
  modal.style.display = 'flex';

  // Close modal when clicking outside the modal content
  modal.addEventListener('click', (e) => {
    const modalContent = document.querySelector('.modal-content');
    if (!modalContent.contains(e.target)) {
      modal.style.display = 'none';
    }
  });
}

// Close modal button event
document.getElementById('close-modal').addEventListener('click', () => {
  document.getElementById('event-modal').style.display = 'none';
});

// Toggle navbar (optional for responsive design)
document.getElementById("menu-btn").addEventListener("click", function () {
  document.getElementById("nav-links").classList.toggle("open");
});
