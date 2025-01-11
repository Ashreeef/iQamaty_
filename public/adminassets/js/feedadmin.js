let feedItems = [];

// On page load, fetch existing feed announcements
window.addEventListener('DOMContentLoaded', () => {
  fetchFeedItems();
});

function fetchFeedItems() {
  fetch('/iQamaty_10/app/Controllers/get_feed.php')
    .then((response) => response.json())
    .then((data) => {
      if (data.message) {
        renderNoItemsMessage(data.message);
      } else {
        feedItems = data;
        renderFeedItems(feedItems);
      }
    })
    .catch((error) => {
      console.error('Error fetching feed items:', error);
      renderNoItemsMessage('Error fetching feed items. Please try again later.');
    });
}

function renderNoItemsMessage(message) {
  const container = document.querySelector('.existing-feed table tbody');
  if (!container) {
    console.error('Container element for feed items not found');
    return;
  }
  container.innerHTML = `
    <tr>
      <td colspan="6" class="text-center no-items-message">${message}</td>
    </tr>
  `;
}

function renderFeedItems(items) {
  const container = document.querySelector('.existing-feed table tbody');
  if (!container) {
    console.error('Container element for feed items not found');
    return;
  }
  container.innerHTML = '';

  items.forEach((item, index) => {
    // Format the date as needed
    const dateObj = new Date(item.created_at);
    const dateString = dateObj.toLocaleDateString('en-GB', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    });

    // If there's an image => show a preview link or thumbnail
    // For simplicity, we'll show the image path (or thumbnail).
    let imageCell = 'N/A';
    if (item.feed_image && item.feed_image.trim() !== '') {
      imageCell = `<img src="${item.feed_image}" alt="${item.feed_title}" style="max-width:100px; max-height:80px;" />`;
    }

    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.feed_title}</td>
      <td>${item.feed_admin}</td>
      <td>${dateString}</td>
      <td>${item.feed_description}</td>
      <td>${imageCell}</td>
      <td>
        <button class="delete-btn" onclick="deleteFeedItem(${item.feed_id}, ${index})">Delete</button>
        <!-- Optionally add an "Update" button if you want to allow editing -->
        <!--
        <button class="update-btn" onclick="updateFeedItem(${item.feed_id}, ${index})">
          Update
        </button>
        -->
      </td>
    `;
    container.appendChild(row);
  });
}

// Handle form submission to create a new feed announcement
document.getElementById('feed-form').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch('/iQamaty_10/app/Controllers/add_feed.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: data.message,
          timer: 1500,
          showConfirmButton: false,
        });
        e.target.reset();
        // re-fetch items or push the new item to the array
        fetchFeedItems();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.message,
        });
      }
    })
    .catch((error) => {
      console.error('Error adding feed item:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'An error occurred while adding the announcement.',
      });
    });
});

function deleteFeedItem(feedId, index) {
  Swal.fire({
    title: 'Are you sure you want to delete this announcement?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/iQamaty_10/app/Controllers/delete_feed.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `feed_id=${feedId}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Deleted',
              text: data.message,
              timer: 1500,
              showConfirmButton: false,
            });
            feedItems.splice(index, 1);
            renderFeedItems(feedItems);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message,
            });
          }
        })
        .catch((error) => {
          console.error('Error deleting feed item:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while deleting the announcement.',
          });
        });
    }
  });
}
