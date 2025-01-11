let reports = [];
const searchBar = document.querySelector('#search-bar');
const filterUrgency = document.querySelector('#filter-occupied');

function fetchReports() {
  fetch('/iQamaty_10/app/Controllers/get_reports.php')
    .then(response => response.json())
    .then(data => {
      if (data.message) {
        console.log(data.message);
        displayMessage(data.message);
      } else if (data.error) {
        console.error(data.error);
        displayMessage("Error fetching reports.");
      } else {
        reports = data;
        renderReports(reports);
      }
    })
    .catch(error => {
      console.error("Error fetching reports:", error);
      displayMessage("Error fetching reports.");
    });
}

// Function to render reports dynamically
function renderReports(reports) {
  const reportsContainer = document.querySelector('.reports-page');
  reportsContainer.innerHTML = ''; // Clear existing reports

  reports.forEach((report) => {
    const urgencyClass = report.Urgency === 'high' ? 'bg-red' :
                         report.Urgency === 'medium' ? 'bg-orange' : 'bg-green';

    const reportCard = document.createElement('div');
    reportCard.className = 'report bg-white rad-6 p-20 p-relative';

    reportCard.innerHTML = `
      <div class="report-header between-flex">
        <h4 class="fs-16">${capitalize(report.Category)} Issue</h4>
        <span class="urgency ${urgencyClass} c-white p-5 rad-6">${capitalize(report.Urgency)}</span>
      </div>
      <p class="fs-14 c-grey">Submitted by: <strong>${report.FullName}</strong></p>
      <p class="fs-14 c-grey">Room: <strong>${report.RoomNumber}</strong></p>
      <p class="fs-14 c-grey">Description: <strong>${truncateText(report.Description, 50)}</strong></p>
      <div class="report-info between-flex">
        <span class="c-grey">Date: ${formatDate(report.Date)}</span>
        <div>
          <button class="bg-blue c-white btn-shape" onclick="showReportDetails(${report.ReportID})">View Details</button>
          <button class="bg-red c-white btn-shape" onclick="markAsResolved(${report.ReportID})">Mark as Resolved</button>
        </div>
      </div>
    `;

    reportsContainer.appendChild(reportCard);
  });
}

// Function to display messages (e.g., error messages)
function displayMessage(message) {
  const reportsContainer = document.querySelector('.reports-page');
  reportsContainer.innerHTML = `<p class="fs-14 c-grey">${message}</p>`;
}

function showReportDetails(reportID) {
  const report = reports.find(r => r.ReportID === reportID);

  if (!report) {
    Swal.fire({
      icon: 'error',
      title: 'Report not found!',
      text: 'Please check the ID and try again.',
      confirmButtonText: 'OK'
    });
    return;
  }

  // Populate modal content
  document.getElementById('modal-title').innerText = `${capitalize(report.Category)} Issue`;
  document.getElementById('modal-fullname').innerText = report.FullName;
  document.getElementById('modal-room').innerText = report.RoomNumber;
  document.getElementById('modal-category').innerText = capitalize(report.Category);
  document.getElementById('modal-urgency').innerText = capitalize(report.Urgency);
  document.getElementById('modal-urgency').className = `p-5 rad-6 ${
    report.Urgency === 'high' ? 'bg-red' : report.Urgency === 'medium' ? 'bg-orange' : 'bg-green'
  }`;
  document.getElementById('modal-date').innerText = formatDate(report.Date);
  document.getElementById('modal-description').innerText = report.Description;

  // Handle uploaded image
  if (report.FileUploaded) {
    document.getElementById('modal-image-container').style.display = 'block';
    document.getElementById('modal-image').src = report.FileUploaded;
  } else {
    document.getElementById('modal-image-container').style.display = 'none';
  }

  // Show the modal
  const modal = document.getElementById('report-modal');
  modal.style.display = 'block';

  // Close modal when clicking outside the modal content
  modal.addEventListener('click', (e) => {
    const modalContent = document.querySelector('.modal-content');
    if (!modalContent.contains(e.target)) {
      modal.style.display = 'none';
    }
  });
}

// Function to filter reports based on search and urgency
function filterReports() {
  const query = searchBar.value.trim().toLowerCase();
  const urgencyFilter = filterUrgency.value;

  let filteredReports = reports.slice(); // Create a copy of the reports array to filter

  // Apply search filter by category or occupant name
  if (query) {
    filteredReports = filteredReports.filter((report) =>
      report.FullName.toLowerCase().includes(query) ||
      report.Category.toLowerCase().includes(query)
    );
  }

  // Apply urgency filter
  if (urgencyFilter) {
    filteredReports = filteredReports.filter((report) => report.Urgency === urgencyFilter);
  }

  renderReports(filteredReports); // Render filtered reports
}

// Close modal when the close button is clicked
document.getElementById('close-modal').addEventListener('click', () => {
  document.getElementById('report-modal').style.display = 'none';
});

// Function to mark a report as resolved
function markAsResolved(reportID) {
  Swal.fire({
    title: 'Are you sure you want to mark this report as resolved?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, resolve it',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/iQamaty_10/app/Controllers/delete_report.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ReportID=${reportID}`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Remove the report from the DOM
            const reportCard = document.querySelector(
              `.report-info button[onclick="markAsResolved(${reportID})"]`
            ).closest('.report');
            reportCard.remove();
            Swal.fire({
              icon: 'success',
              title: 'Resolved!',
              text: 'Report successfully marked as resolved!',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Failed to mark as resolved',
              text: data.message
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while marking the report as resolved.'
          });
        });
    }
  });
}

// Utility functions
function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function truncateText(text, maxLength) {
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

function formatDate(dateStr) {
  const date = new Date(dateStr);
  return date.toLocaleDateString('en-GB'); // Format: DD/MM/YYYY
}

// Event listeners for search bar and filter changes
searchBar.addEventListener("input", filterReports);
filterUrgency.addEventListener("change", filterReports);

// Fetch reports when page loads
document.addEventListener('DOMContentLoaded', fetchReports);
