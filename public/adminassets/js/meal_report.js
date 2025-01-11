let reports = [];

function fetchReports() {
  fetch('/iQamaty_10/app/Controllers/get_meal_report.php')
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

function renderReports(reports) {
  const reportsContainer = document.querySelector('.reports-page');
  reportsContainer.innerHTML = ''; // Clear existing reports

  reports.forEach((report) => {
    const reportCard = document.createElement('div');
    reportCard.className = 'report bg-white rad-6 p-20 p-relative';

    reportCard.innerHTML = `
      <div class="report-header between-flex">
        <h4 class="fs-16">Meal Issue</h4>
      </div>
      <p class="fs-14 c-grey">Submitted by: <strong>${report.FirstName} ${report.LastName}</strong></p>
      <p class="fs-14 c-grey">Description: <strong>${truncateText(report.MRDescription, 50)}</strong></p>
      <div class="report-info between-flex">
        <span class="c-grey">Date: ${formatDate(report.MRDate)}</span>
        <div>
          <button class="bg-blue c-white btn-shape" onclick="showReportDetails(${report.ReportID})">View Details</button>
          <button class="bg-red c-white btn-shape" onclick="markAsResolved(${report.ReportID})">Mark as Resolved</button>
        </div>
      </div>
    `;

    reportsContainer.appendChild(reportCard);
  });
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
  document.getElementById('modal-title').innerText = `Meal Issue`;
  document.getElementById('modal-fullname').innerText = `${report.FirstName} ${report.LastName}`;
  document.getElementById('modal-date').innerText = formatDate(report.MRDate);
  document.getElementById('modal-description').innerText = report.MRDescription;

  // Handle uploaded image
  if (report.Attachment) {
    document.getElementById('modal-image-container').style.display = 'block';
    document.getElementById('modal-image').src = report.Attachment;
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

// Close modal when the close button is clicked
document.getElementById('close-modal').addEventListener('click', () => {
  document.getElementById('report-modal').style.display = 'none';
});

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
      fetch('/iQamaty_10/app/Controllers/delete_meal_report.php', {
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
function truncateText(text, maxLength) {
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

function formatDate(dateStr) {
  const date = new Date(dateStr);
  return date.toLocaleDateString('en-GB'); // Format: DD/MM/YYYY
}

// Fetch reports on page load
document.addEventListener('DOMContentLoaded', fetchReports);