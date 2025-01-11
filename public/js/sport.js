
// Sample array of sports (later will be fetched from DB)
const sports = [
  
  
];

// Function to fetch sports data for the user side
const fetchUserSports = async () => {
  try {
    const response = await fetch('/iQamaty_10/app/Controllers/get_sport_user.php');
    const result = await response.json();

    console.log("Fetched Result:", result); // Log the raw result

    if (result.success) {
      console.log("Sports Data:", result.data); // Log the data array
      return result.data;
    } else {
      console.error('Failed to fetch user sports:', result.message);
      return [];
    }
  } catch (error) {
    console.error('Error fetching user sports:', error);
    return [];
  }
};




// Function to populate the sports array dynamically
const populateUserSports = async () => {
  const fetchedSports = await fetchUserSports();

  // Update the global sports array directly
  sports.length = 0; // Clear the existing array
  sports.push(...fetchedSports.map(sport => ({
    title: sport.SName,
    location: sport.SLocation,
    description:sport.SDescription,
    image: sport.SPicture,
    registration: sport.isRegister,
    registrationLink: sport.SFormLink,
  })));

  // Render the updated sports data
  renderEvents();
};

// Function to render events in HTML
function renderEvents() {
  const sportContainer = document.getElementById('sports-container');
  
  sports.forEach((sport, index) => {
    const sportBox = document.createElement('div');
    sportBox.className = 'sport-box';

    sportBox.innerHTML = `
      <img src="${sport.image}" alt="${sport.title}">
      <h3>${sport.title}</h3>
      <button class="button details-btn" onclick="showEventDetails(${index})">Join</button>
    `;

    sportContainer.appendChild(sportBox);
  });

  ScrollReveal().reveal('.sport-box', {
    distance: '50px',
    origin: 'bottom',
    interval: 200,
    duration: 800
  });
}

// Call the populateUserSports function on page load
document.addEventListener('DOMContentLoaded', populateUserSports);







// function to show event details in a modal
function showEventDetails(index) {
const modal = document.getElementById('sport-modal');
document.getElementById('modal-title').innerText = sports[index].title;

document.getElementById('modal-location').innerText = `Location: ${sports[index].location}`;
document.getElementById('modal-description').innerText = `Description: ${sports[index].description}`;

// show registration button if provided
const registerBtn = document.getElementById('register-btn');
if (sports[index].registration) {
  registerBtn.style.display = 'block';

  // Replace any previous event listener with a new one
  const newRegisterBtn = registerBtn.cloneNode(true);
  registerBtn.replaceWith(newRegisterBtn);

  // Attach click event listener for redirection
  newRegisterBtn.addEventListener('click', () => {
    const registrationLink = sports[index].registrationLink;
    if (registrationLink) {
      window.open(registrationLink, '_blank'); // Open the form in a new tab
    } else {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "No registration link available."
      });
    }
  });
}


modal.style.display = 'flex';

  // close modal when clicking outside the modal content
  modal.addEventListener('click', (e) => {
    const modalContent = document.querySelector('.modal-content');
    if (!modalContent.contains(e.target)) {
      modal.style.display = 'none';
    }
  });
}

// to close the modal
document.getElementById('close-modal').addEventListener('click', () => {
document.getElementById('sport-modal').style.display = 'none';
});

// the events page
document.addEventListener('DOMContentLoaded', renderEvents);




// Selecting tabs
const joinTab = document.getElementById('joinBtn');
const bookTab = document.getElementById('bookBtn');

// Content containers
const joinContent = document.getElementById('joinContent');
const bookContent = document.getElementById('bookContent');

// Default state: Show Join Teams content
joinTab.classList.add('active');
joinContent.style.display = 'block';
bookContent.style.display = 'none';

// Function to show the Join Teams section
function JoinPage() {
    // Update active tab
    joinTab.classList.add('active');
    bookTab.classList.remove('active');

    // Show Join Teams content and hide Book Stadium content
    joinContent.style.display = 'block';
    bookContent.style.display = 'none';
}

// Function to show the Book Stadium section
function BookPage() {
    // Update active tab
    bookTab.classList.add('active');
    joinTab.classList.remove('active');

    // Show Book Stadium content and hide Join Teams content
    bookContent.style.display = 'block';
    joinContent.style.display = 'none';
}

// Populate the timetable dynamically
const timetableData = [
  "Monday at 3-5 PM",
  "Tuesday at 4-6 PM",
  "Wednesday at 1-3 PM",
  "Thursday at 2-4 PM",
  "Friday at 4-6 PM"
];

// Define the time slots data
const timeSlots = [
  { value: "mon3-5", text: "Monday at 3-5 PM" },
  { value: "tue4-6", text: "Tuesday at 4-6 PM" },
  { value: "wed1-3", text: "Wednesday at 1-3 PM" },
  { value: "thu2-4", text: "Thursday at 2-4 PM" },
  { value: "fri4-6", text: "Friday at 4-6 PM" }
];

function renderTimetable() {
  const timetable = document.getElementById('timetable');
  timetable.innerHTML = timetableData.map(slot => `<li>${slot}</li>`).join('');
}

// Function to populate the timeSelect dropdown dynamically
function renderTimeSelect() {
  const timeSelect = document.getElementById('timeSelect');
  timeSelect.innerHTML = timeSlots.map(slot => 
    `<option value="${slot.value}">${slot.text}</option>`
  ).join('');
}

// Call renderTimetable after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  renderTimetable(); // New function
  renderTimeSelect(); // New function to render the time slots dropdown

});


// opening the booking form

const bookingModal = document.getElementById('bookingModal');
const modalOverlay = document.getElementById('modal-overlay');

// Function to open the booking modal
function openBookingForm() {
    bookingModal.classList.add('show');  // Show the modal
    modalOverlay.classList.add('show');  // Show the shadowed overlay
}

// Function to close the booking modal
function closeBookingModal() {
    bookingModal.classList.remove('show');  // Hide the modal
    modalOverlay.classList.remove('show');  // Hide the shadowed overlay
}

// Event listener for clicking outside the modal to close it
modalOverlay.addEventListener('click', (event) => {
    if (event.target === modalOverlay) {
        closeBookingModal();
    }
});


// input validation for the id's input
function submitBooking() {
  const inputField = document.getElementById('playerIds');
  const errorMessage = document.getElementById('errorMessage');
  const inputValue = inputField.value.trim(); // Trim to remove leading/trailing spaces

  // Clear any previous error message
  errorMessage.textContent = '';

  // Check if the input is empty
  if (!inputValue) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please enter at least 5 player IDs separated by commas (,)"
    });
    return;
  }

  // Split the input into an array by commas
  const ids = inputValue.split(',').map(id => id.trim()); // Trim each ID

  // Check if there are at least 5 IDs
  if (ids.length < 5) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please enter at least 5 player IDs separated by commas (,)"
    });
    return;
  }

  // Validate each ID
  const isValid = ids.every(id => /^\d{12}$/.test(id)); // Each ID must be 12 digits

  if (!isValid) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Each player ID must be a 12-digit integer."
    });
    return;
  }

  // If validation passes
  const booked = document.getElementById('booked');
  booked.addEventListener('click', () => {
    Swal.fire({
      title: 'Registration Done!',
      text: `You have registered successfully.`,
      icon: 'success'
    }).then(() => {
      closeBookingModal(); // Close the booking modal after the SweetAlert
    });
  });
}

// toggle navbar
document.getElementById("menu-btn").addEventListener("click", function() {
  document.getElementById("nav-links").classList.toggle("open");
});
