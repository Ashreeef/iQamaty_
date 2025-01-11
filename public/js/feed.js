document.addEventListener('DOMContentLoaded', () => {
    const announcementsContainer = document.getElementById('announcements-container');
    const lastEventContent = document.getElementById('last-event-content');
    const lastLostFoundContent = document.getElementById('last-lostfound-content');

    const announcements = [
        {
            admin_name: "Admin",
            created_at: "2024-12-27 10:00:00",
            title: "Welcome to iQamaty!",
            description: "We're excited to have you here. Stay tuned for more updates and announcements.",
            image: "/iQamaty_10/public/images/mahelma-bynight.jpg"
        },
        {
            admin_name: "Admin",
            created_at: "2024-12-26 14:30:00",
            title: "Holiday Schedule",
            description: "Please be informed about the upcoming holiday schedule. Classes will resume on January 5th.",
            image: "/iQamaty_10/public/images/mahelma-center.jpg"
        },
        {
            admin_name: "Admin",
            created_at: "2024-12-25 09:15:00",
            title: "Maintenance Notice",
            description: "Routine maintenance will be conducted this weekend. Please ensure all personal items are secured."
        },
        {
            admin_name: "Admin",
            created_at: "2024-12-24 16:45:00",
            title: "New Library Hours",
            description: "The library will now be open from 8 AM to 10 PM to better serve your study needs.",
            image: "https://via.placeholder.com/800x400.png?text=Library+Hours"
        }
    ];

    /*
    // COMMENTED-OUT FOR FETCHING FEED POSTS
    async function fetchAnnouncements() {
        try {
            const response = await fetch('/iQamaty_10/app/Controllers/get_feed.php');
            const data = await response.json();

            if (response.ok && Array.isArray(data)) {
                // Clear local announcements array, if needed
                announcements.length = 0; 
                announcements.push(...data.map(item => ({
                    admin_name: item.feed_admin,
                    created_at: item.created_at,
                    title: item.feed_title,
                    description: item.feed_description,
                    image: item.feed_image
                })));
                renderAnnouncements();
            } else if (data.message) {
                console.log(data.message);
                // Optionally handle "No announcements found" message
            } else {
                console.error('Unexpected response data:', data);
            }
        } catch (error) {
            console.error('Error fetching feed announcements:', error);
        }
    }
    // fetchAnnouncements();
    */

    function formatDate(datetime) {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric'
        };
        const date = new Date(datetime);
        return date.toLocaleDateString('en-US', options);
    }

    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
    }

    function renderAnnouncements() {
        announcementsContainer.innerHTML = '';

        announcements.forEach(announcement => {
            const postElement = document.createElement('div');
            postElement.classList.add('post');

            const hasImage = announcement.image && announcement.image.trim() !== '';

            postElement.innerHTML = `
                <div class="post-header">
                    <div class="admin-name"><i class="ri-admin-line"></i> ${escapeHTML(announcement.admin_name)}</div>
                    <div class="post-date">${formatDate(announcement.created_at)}</div>
                </div>
                <div class="post-content">
                    <h3>${escapeHTML(announcement.title)}</h3>
                    <p>${escapeHTML(announcement.description)}</p>
                    ${hasImage ? `<img src="${escapeHTML(announcement.image)}" alt="${escapeHTML(announcement.title)}">` : ''}
                </div>
            `;

            announcementsContainer.appendChild(postElement);
        });
    }

    async function fetchLastEvent() {
        try {
            const response = await fetch('/iQamaty_10/app/Controllers/get_events.php');
            const data = await response.json();

            if (response.ok && Array.isArray(data) && data.length > 0) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                let upcomingEvent = null;

                for (let event of data) {
                    const eventDate = new Date(event.EventDate);
                    eventDate.setHours(0, 0, 0, 0);
                    if (eventDate >= today) {
                        upcomingEvent = event;
                        break;
                    }
                }

                if (upcomingEvent) {
                    lastEventContent.innerHTML = `
                        <img src="${escapeHTML(upcomingEvent.EventPicture)}" alt="${escapeHTML(upcomingEvent.EventName)}">
                        <h3>${escapeHTML(upcomingEvent.EventName)}</h3>
                        <p>${escapeHTML(upcomingEvent.EventDetails)}</p>
                        <p><strong>Date:</strong> ${formatDate(upcomingEvent.EventDate)}</p>
                        <p><strong>Location:</strong> ${escapeHTML(upcomingEvent.EventLocation)}</p>
                        ${
                            upcomingEvent.EventFormLink 
                            ? `<p><a href="${escapeHTML(upcomingEvent.EventFormLink)}" target="_blank">Register Here</a></p>` 
                            : ''
                        }
                    `;
                } else {
                    const latestPastEvent = data[data.length - 1];
                    lastEventContent.innerHTML = `
                        <img src="${escapeHTML(latestPastEvent.EventPicture)}" alt="${escapeHTML(latestPastEvent.EventName)}">
                        <h3>${escapeHTML(latestPastEvent.EventName)}</h3>
                        <p>${escapeHTML(latestPastEvent.EventDetails)}</p>
                        <p><strong>Date:</strong> ${formatDate(latestPastEvent.EventDate)}</p>
                        <p><strong>Location:</strong> ${escapeHTML(latestPastEvent.EventLocation)}</p>
                        ${
                            latestPastEvent.EventFormLink 
                            ? `<p><a href="${escapeHTML(latestPastEvent.EventFormLink)}" target="_blank">Register Here</a></p>` 
                            : ''
                        }
                    `;
                }
            } else if (data.message) {
                lastEventContent.innerHTML = `<p>${escapeHTML(data.message)}</p>`;
            } else {
                lastEventContent.innerHTML = `<p>No upcoming events found.</p>`;
            }
        } catch (error) {
            console.error('Error fetching last event:', error);
            lastEventContent.innerHTML = `<p>Error loading event data.</p>`;
        }
    }

    async function fetchLastLostFound() {
        try {
            const response = await fetch('/iQamaty_10/app/Controllers/get_lostfound.php');
            const data = await response.json();

            if (response.ok && Array.isArray(data) && data.length > 0) {
                const latestItem = data[0];
                lastLostFoundContent.innerHTML = `
                    <img src="${escapeHTML(latestItem.LFPicture)}" alt="${escapeHTML(latestItem.LFName)}">
                    <h3>${escapeHTML(latestItem.LFName)}</h3>
                    <p>${escapeHTML(latestItem.LFDescription)}</p>
                    <p><strong>Date:</strong> ${formatDate(latestItem.LFDate)}</p>
                    <p><strong>Location:</strong> ${escapeHTML(latestItem.LFLocation)}</p>
                    <p><strong>Status:</strong> ${escapeHTML(latestItem.LFStatus)}</p>
                `;
            } else {
                lastLostFoundContent.innerHTML = `<p>No lost/found items found.</p>`;
            }
        } catch (error) {
            console.error('Error fetching last lost/found item:', error);
            lastLostFoundContent.innerHTML = `<p>Error loading lost/found data.</p>`;
        }
    }

    renderAnnouncements();
    fetchLastEvent();
    fetchLastLostFound();
});

// toggle navbar
document.getElementById("menu-btn").addEventListener("click", function() {
    document.getElementById("nav-links").classList.toggle("open");
});
