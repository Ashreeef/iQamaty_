document.addEventListener("DOMContentLoaded", () => {
  const prayerTimesTableBody = document.querySelector("#prayer-times-table tbody");
  const form = document.getElementById("prayer-times-form");
  const weekTitle = document.getElementById("week-title");

  const daysOfWeek = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];

  const getStartOfWeek = (date) => {
    const start = new Date(date);
    start.setDate(date.getDate() - date.getDay()); // Set to Sunday
    start.setHours(0, 0, 0, 0);
    return start;
  };

  const formatDate = (date) =>
    `${date.toLocaleString("default", { month: "short" })} ${date.getDate()}, ${date.getFullYear()}`;

  const getCurrentWeekDates = () => {
    const today = new Date();
    const startOfWeek = getStartOfWeek(today);
    const dates = [];
    for (let i = 0; i < 7; i++) {
      const day = new Date(startOfWeek);
      day.setDate(startOfWeek.getDate() + i);
      dates.push(day);
    }
    return dates;
  };

  const currentWeekDates = getCurrentWeekDates();
  const savePrayerTimesEndpoint = "/iQamaty_10/app/Controllers/save_prayer_times.php";
  const getPrayerTimesEndpoint = "/iQamaty_10/app/Controllers/get_prayer_times.php";

  // Display week range in the title
  weekTitle.textContent = `Prayer Times Management for ${formatDate(
    currentWeekDates[0]
  )} - ${formatDate(currentWeekDates[6])}`;

  // Fetch and populate table with existing prayer times
  const loadPrayerTimes = async () => {
    try {
      const response = await fetch(getPrayerTimesEndpoint);
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
      const data = await response.json();

      // Check if there's an error in the response
      if (data.error) {
        throw new Error(data.error);
      }

      populateTable(data);
    } catch (error) {
      console.error("Failed to load prayer times:", error);
      showNotification("Failed to load prayer times. Please try again later.");
    }
  };

  const populateTable = (prayerTimesWeek) => {
    prayerTimesTableBody.innerHTML = ""; // Clear existing rows

    currentWeekDates.forEach((date, index) => {
      const dayName = daysOfWeek[index];
      const isoDate = date.toISOString().slice(0, 10); // YYYY-MM-DD format
      const formattedDate = formatDate(date);

      // to check if there's existing data for this date
      const existingTime = prayerTimesWeek.find((time) => time.date === isoDate);

      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${dayName}</td>
        <td data-date="${isoDate}">${formattedDate}</td>
        <td><input type="time" name="fajr[${isoDate}]" value="${existingTime ? existingTime.fajr : ""}" /></td>
        <td><input type="time" name="dhuhr[${isoDate}]" value="${existingTime ? existingTime.dhuhr : ""}" /></td>
        <td><input type="time" name="asr[${isoDate}]" value="${existingTime ? existingTime.asr : ""}" /></td>
        <td><input type="time" name="maghrib[${isoDate}]" value="${existingTime ? existingTime.maghrib : ""}" /></td>
        <td><input type="time" name="isha[${isoDate}]" value="${existingTime ? existingTime.isha : ""}" /></td>
        <td><button type="button" class="save-btn" data-date="${isoDate}" data-day="${dayName}">Save</button></td>
      `;
      prayerTimesTableBody.appendChild(row);
    });
  };

  // Utility to show toast notifications
  const showNotification = (message) => {
    const notificationContainer = document.getElementById("notification-container");
    const notification = document.createElement("div");
    notification.className = "toast-notification";
    notification.innerHTML = message;

    notificationContainer.appendChild(notification);

    setTimeout(() => {
      notification.remove();
    }, 3500);
  };

  // Save individual day
  prayerTimesTableBody.addEventListener("click", async (e) => {
    if (e.target.classList.contains("save-btn")) {
      const date = e.target.dataset.date;
      const day = e.target.dataset.day;
      const row = e.target.closest("tr");

      const times = {
        day_of_week: day,
        date: date,
        fajr: row.querySelector(`[name="fajr[${date}]"]`).value,
        dhuhr: row.querySelector(`[name="dhuhr[${date}]"]`).value,
        asr: row.querySelector(`[name="asr[${date}]"]`).value,
        maghrib: row.querySelector(`[name="maghrib[${date}]"]`).value,
        isha: row.querySelector(`[name="isha[${date}]"]`).value,
      };

      try {
        const response = await fetch(savePrayerTimesEndpoint, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ prayerTimes: { [date]: times } }),
        });

        const result = await response.json();
        if (response.ok) {
          const successMessages = result.success.join('<br>') || `${day}'s prayer times saved successfully!`;
          showNotification(successMessages);
          // Refresh the table to reflect the saved override
          loadPrayerTimes();
        } else {
          showNotification(result.error || `Failed to save ${day}'s prayer times.`);
        }
      } catch (error) {
        console.error("Error saving prayer time:", error);
        showNotification(`Failed to save ${day}'s prayer times. Please try again.`);
      }
    }
  });

  // Save all days
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const prayerTimes = {};

    document.querySelectorAll("#prayer-times-table tbody tr").forEach((row) => {
      const date = row.querySelector("td:nth-child(2)").dataset.date;
      const day = row.querySelector("td:first-child").textContent.trim();

      prayerTimes[date] = {
        day_of_week: day,
        date: date,
        fajr: row.querySelector(`[name="fajr[${date}]"]`).value,
        dhuhr: row.querySelector(`[name="dhuhr[${date}]"]`).value,
        asr: row.querySelector(`[name="asr[${date}]"]`).value,
        maghrib: row.querySelector(`[name="maghrib[${date}]"]`).value,
        isha: row.querySelector(`[name="isha[${date}]"]`).value,
      };
    });

    try {
      const response = await fetch(savePrayerTimesEndpoint, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ prayerTimes }),
      });

      const result = await response.json();
      if (response.ok) {
        const successMessages = result.success.join('<br>') || "All prayer times have been saved successfully!";
        showNotification(successMessages);
        // Refresh the table to reflect the saved overrides
        loadPrayerTimes();
      } else {
        showNotification(result.error || "Failed to save prayer times.");
      }
    } catch (error) {
      console.error("Error saving prayer times:", error);
      showNotification("An error occurred while saving all prayer times.");
    }
  });

  // Load existing prayer times on page load
  loadPrayerTimes();
});
