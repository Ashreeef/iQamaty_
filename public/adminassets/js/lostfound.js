let items = [];

fetch('/iQamaty_10/app/Controllers/get_lostfound.php')
  .then(response => response.json())
  .then(data => {
    if (data.message) {
      renderNoItemsMessage(data.message);
    } else {
      items = data;
      renderItems(items);
    }
  })
  .catch(error => {
    console.error("Error fetching items:", error);
    renderNoItemsMessage("Error fetching items. Please try again later.");
  });

function renderNoItemsMessage(message) {
  const container = document.querySelector('.existing-lostfound table tbody');
  if (!container) {
    console.error('Container element for items not found');
    return;
  }
  container.innerHTML = `
    <tr>
      <td colspan="6" class="text-center no-items-message">${message}</td>
    </tr>
  `;
}

function renderItems(items) {
  const container = document.querySelector('.existing-lostfound table tbody');
  if (!container) {
    console.error('Container element for items not found');
    return;
  }
  container.innerHTML = '';

  items.forEach((item, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.LFName}</td>
      <td>${new Date(item.LFDate).toLocaleDateString('en-GB')}</td>
      <td>${item.LFLocation}</td>
      <td>${item.LFStatus}</td>
      <td>${item.LFDescription}</td>
      <td>
        <button class="delete-btn" onclick="deleteItem(${item.LFID}, ${index})">Delete</button>
        ${item.LFStatus === 'lost' ? 
          `<button class="mark-found-btn" onclick="markAsFound(${item.LFID}, ${index})">Mark as Found</button>` 
          : ''}
      </td>
    `;
    container.appendChild(row);
  });
}

document.getElementById('lostfound-form').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch('/iQamaty_10/app/Controllers/add_lostfound.php', {
    method: 'POST',
    body: formData,
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: data.message,
          timer: 1500,
          showConfirmButton: false
        });
        e.target.reset(); 
        fetchItems();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.message
        });
      }
    })
    .catch(error => {
      console.error('Error adding item:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'An error occurred while adding the item.'
      });
    });
});

function deleteItem(itemId, index) {
  Swal.fire({
    title: 'Are you sure you want to delete this item?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/iQamaty_10/app/Controllers/delete_lostfound.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `LFID=${itemId}`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Deleted',
              text: data.message,
              timer: 1500,
              showConfirmButton: false
            });
            items.splice(index, 1);
            renderItems(items);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message
            });
          }
        })
        .catch(error => {
          console.error('Error deleting item:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while deleting the item.'
          });
        });
    }
  });
}

function markAsFound(itemId, index) {
  Swal.fire({
    title: 'Are you sure you want to mark this item as found?',
    text: 'This action will change the status to "Found".',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, mark it',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/iQamaty_10/app/Controllers/mark_as_found.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `LFID=${itemId}`,
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Marked as Found',
              text: data.message,
              timer: 1500,
              showConfirmButton: false
            });
            items[index].LFStatus = 'Found';
            renderItems(items);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message
            });
          }
        })
        .catch(error => {
          console.error('Error marking item as found:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating the item.'
          });
        });
    }
  });
}

function fetchItems() {
  fetch('/iQamaty_10/app/Controllers/get_lostfound.php')
    .then(response => response.json())
    .then(data => {
      if (data.message) {
        renderNoItemsMessage(data.message);
      } else {
        items = data;
        renderItems(items);
      }
    })
    .catch(error => {
      console.error("Error fetching items:", error);
      renderNoItemsMessage("Error fetching items. Please try again later.");
    });
}
