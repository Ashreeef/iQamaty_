function updateTime() {
  const now = new Date();
  const timeElement = document.getElementById("time");
  let hours = now.getHours();
  let minutes = now.getMinutes();
  let seconds = now.getSeconds();
  timeElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes
    .toString()
    .padStart(2, '0')} <span>:${seconds.toString().padStart(2, '0')}</span>`;
}

function updateGregorianDate() {
  const now = new Date();
  const options = { year: "numeric", month: "2-digit", day: "2-digit" };
  const gregorianDate = now.toLocaleDateString("en-GB", options);
  document.getElementById("gregorian-date").innerText = gregorianDate;
}

// Function to fetch the Hijri date from Aladhan API
function updateHijriDate() {
  const now = new Date();
  const day = now.getDate();
  const month = now.getMonth() + 1; // JS months are 0-based
  const year = now.getFullYear();

  fetch(`https://api.aladhan.com/v1/gToH?date=${day}-${month}-${year}`)
    .then((response) => response.json())
    .then((data) => {
      const hijriDate = data.data.hijri.date;
      document.getElementById("islamic-date").innerText = hijriDate;
    })
    .catch((error) => {
      console.error("Error fetching Hijri date:", error);
      document.getElementById("islamic-date").innerText = "Error fetching date";
    });
}

async function fetchTodayPrayerTimes() {
  try {
    const response = await fetch("/iQamaty_10/app/Controllers/get_prayer_times.php");
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const prayerTimesWeek = await response.json();

    // Check if there's an error in the response
    if (prayerTimesWeek.error) {
      throw new Error(prayerTimesWeek.error);
    }

    renderTodayPrayerTimes(prayerTimesWeek);
  } catch (error) {
    console.error("Failed to fetch prayer times:", error);
    document.getElementById("prayer-times").innerHTML = `<p>Failed to load prayer times. Please try again later.</p>`;
  }
}

function renderTodayPrayerTimes(prayerTimesWeek) {
  const prayerTimesContainer = document.getElementById("prayer-times");
  prayerTimesContainer.innerHTML = ""; // Clear existing content

  const now = new Date();
  const year = now.getUTCFullYear();
  const month = String(now.getUTCMonth() + 1).padStart(2, '0');
  const day = String(now.getUTCDate()).padStart(2, '0');
  const todayStr = `${year}-${month}-${day}`;

  // Find today's prayer times
  const todayPrayerTimes = prayerTimesWeek.find((time) => time.date === todayStr);

  if (!todayPrayerTimes) {
    prayerTimesContainer.innerHTML = `<p>No prayer times available for today.</p>`;
    return;
  }

  const prayers = [
    { name: "Fajr", time: todayPrayerTimes.fajr, iqama: "+20" },
    { name: "Dhuhr", time: todayPrayerTimes.dhuhr, iqama: "+10" },
    { name: "Asr", time: todayPrayerTimes.asr, iqama: "+10" },
    { name: "Maghrib", time: todayPrayerTimes.maghrib, iqama: "+5" },
    { name: "Isha", time: todayPrayerTimes.isha, iqama: "+10" },
  ];

  const currentMinutes = now.getHours() * 60 + now.getMinutes();

  let nextPrayerIndex = prayers.findIndex((prayer) => {
    if (!prayer.time) return false; // Skip if time is not available
    const [hours, minutes] = prayer.time.split(":").map(Number);
    return currentMinutes < hours * 60 + minutes;
  });

  if (nextPrayerIndex === -1) {
    nextPrayerIndex = 0; // Highlight Fajr if the day has ended
  }

  prayers.forEach((prayer, index) => {
    const prayerBox = document.createElement("div");
    prayerBox.classList.add("prayer-box");

    if (index === nextPrayerIndex) {
      prayerBox.classList.add("next-prayer"); // Special class for the nextmost prayer
    }

    const iconBox = document.createElement("div");
    iconBox.classList.add("icon-box");

    const icon = document.createElement("i");
    icon.classList.add(getIconClass(prayer.name));
    iconBox.appendChild(icon);

    const prayerName = document.createElement("h3");
    prayerName.innerText = prayer.name;

    const formattedTime = formatTime(prayer.time); 
    const prayerTime = document.createElement("span");

    prayerTime.innerHTML = `${formattedTime} <span style="margin-left: 4px;">${prayer.iqama}</span>`;

    prayerBox.appendChild(iconBox);
    prayerBox.appendChild(prayerName);
    prayerBox.appendChild(prayerTime);
    prayerTimesContainer.appendChild(prayerBox);
  });
}

function formatTime(time) {
  if (!time) return "N/A";
  const [hours, minutes] = time.split(":");
  return `${hours}:${minutes}`;
}

function getIconClass(prayer) {
  switch (prayer) {
    case "Fajr":
      return "ri-sun-foggy-line";
    case "Dhuhr":
      return "ri-sun-line";
    case "Asr":
      return "ri-sun-cloudy-line";
    case "Maghrib":
      return "ri-contrast-2-line";
    case "Isha":
      return "ri-moon-clear-line";
    default:
      return "";
  }
}

// ScrollReveal animations
function initializeScrollReveal() {
  ScrollReveal().reveal(".mosque-title", {
    delay: 300,
    distance: "50px",
    origin: "top",
    duration: 1000,
  });

  ScrollReveal().reveal(".clock", {
    delay: 500,
    distance: "50px",
    origin: "left",
    duration: 1000,
  });

  ScrollReveal().reveal(".date-info", {
    delay: 700,
    distance: "50px",
    origin: "right",
    duration: 1000,
  });

  ScrollReveal().reveal(".prayer-boxes", {
    delay: 900,
    distance: "50px",
    origin: "bottom",
    duration: 1000,
    interval: 200,
  });
}

document.getElementById("menu-btn").addEventListener("click", function () {
  document.getElementById("nav-links").classList.toggle("open");
});

// Initialize functions
initializeScrollReveal();
setInterval(updateTime, 1000);
updateGregorianDate();
updateHijriDate();
fetchTodayPrayerTimes();
