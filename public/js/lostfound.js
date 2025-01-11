// Declare events array globally
let events = [];

// Fetch items from the database via the PHP API
fetch('/iQamaty_10/app/Controllers/get_lostfound.php')
  .then(response => response.json())
  .then(data => {
    // Check if data contains a message or items
    if (data.message) {
      console.error(data.message); // No items found
    } else {
      events = data; // Store the fetched items in the global variable
      // Render the items
      renderEvents(events);
    }
  })
  .catch(error => {
    console.error("Error fetching events:", error);
  });

// Function to render items in HTML
function renderEvents(events) {
  const eventContainer = document.getElementById('events-container');
  eventContainer.innerHTML = '';  // Clear previous events

  events.forEach((event, index) => {
    const eventBox = document.createElement('div');
    eventBox.className = 'event-box';

    // Determine default image based on status
    const defaultImage = event.LFStatus.toLowerCase() === 'found'
      ? '/iQamaty_10/public/images/found-item.jpg'
      : '/iQamaty_10/public/images/lost-item.jpg';

    // Use the uploaded picture if available, otherwise fallback to default
    const imageSrc = event.LFPicture ? event.LFPicture : defaultImage;

    eventBox.innerHTML = `
      <img src="${imageSrc}" alt="${event.LFName}">
      <h3>${event.LFName}</h3>
      <p>${new Date(event.LFDate).toLocaleDateString('en-GB')}</p>
      <button class="button details-btn" onclick="showEventDetails(${index})">View Details</button>
    `;

    eventContainer.appendChild(eventBox);
  });

  // Add scroll reveal effects
  ScrollReveal().reveal('.event-box', {
    distance: '50px',
    origin: 'bottom',
    interval: 200,
    duration: 800
  });
}

// Function to show item details in a modal
function showEventDetails(index) {
  const modal = document.getElementById('event-modal');
  const event = events[index];  // Access the global events array and get the event by index

  // Populate modal content with item details
  document.getElementById('modal-title').innerText = event.LFName;
  document.getElementById('modal-date').innerText = `Date: ${new Date(event.LFDate).toLocaleDateString('en-GB')}`;
  document.getElementById('modal-location').innerText = `Location: ${event.LFLocation}`;
  document.getElementById('modal-description').innerText = event.LFDescription;

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
document.getElementById("menu-btn").addEventListener("click", function() {
  document.getElementById("nav-links").classList.toggle("open");
});
