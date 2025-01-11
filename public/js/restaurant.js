const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const mealHeader = document.querySelector(".meal-header");
const mealContent = document.querySelector(".meal-content");
const days = document.querySelectorAll(".days-navbar li");

const mealsData = {
  Saturday: [
    { name: "", content: { main: "", secondary: "", dessert: "" } },
    {
      name: "Lunch",
      content: {
        main: "Grilled Chicken Sandwich",
        secondary: "Caesar Salad",
        dessert: "Brownie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Spaghetti Bolognese",
        secondary: "Garlic Bread",
        dessert: "Ice Cream",
      },
    },
  ],
  Sunday: [
    {
      name: "Breakfast",
      content: { main: "Omelette", secondary: "Toast", dessert: "Yogurt" },
    },
    {
      name: "Lunch",
      content: {
        main: "Beef Burger",
        secondary: "French Fries",
        dessert: "Apple Pie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Chicken Alfredo",
        secondary: "Side Salad",
        dessert: "Cheesecake",
      },
    },
  ],
  Monday: [
    {
      name: "Breakfast",
      content: { main: "Omelette", secondary: "Toast", dessert: "Yogurt" },
    },
    {
      name: "Lunch",
      content: {
        main: "Beef Burger",
        secondary: "French Fries",
        dessert: "Apple Pie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Chicken Alfredo",
        secondary: "Side Salad",
        dessert: "Cheesecake",
      },
    },
  ],
  Tuesday: [
    {
      name: "Breakfast",
      content: { main: "Omelette", secondary: "Toast", dessert: "Yogurt" },
    },
    {
      name: "Lunch",
      content: {
        main: "Beef Burger",
        secondary: "French Fries",
        dessert: "Apple Pie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Chicken Alfredo",
        secondary: "Side Salad",
        dessert: "Cheesecake",
      },
    },
  ],
  Wednesday: [
    {
      name: "Breakfast",
      content: { main: "Omelette", secondary: "Toast", dessert: "Yogurt" },
    },
    {
      name: "Lunch",
      content: {
        main: "Beef Burger",
        secondary: "French Fries",
        dessert: "Apple Pie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Chicken Alfredo",
        secondary: "Side Salad",
        dessert: "Cheesecake",
      },
    },
  ],
  Thursday: [
    {
      name: "Breakfast",
      content: { main: "Omelette", secondary: "Toast", dessert: "Yogurt" },
    },
    {
      name: "Lunch",
      content: {
        main: "Beef Burger",
        secondary: "French Fries",
        dessert: "Apple Pie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Chicken Alfredo",
        secondary: "Side Salad",
        dessert: "Cheesecake",
      },
    },
  ],
  Friday: [
    {
      name: "Breakfast",
      content: { main: "Omelette", secondary: "Toast", dessert: "Yogurt" },
    },
    {
      name: "Lunch",
      content: {
        main: "Beef Burger",
        secondary: "French Fries",
        dessert: "Apple Pie",
      },
    },
    {
      name: "Dinner",
      content: {
        main: "Chicken Alfredo",
        secondary: "Side Salad",
        dessert: "Cheesecake",
      },
    },
  ],
};
// Fetch meals data from the server
async function fetchMealsData() {
  try {
    const response = await fetch("/iQamaty_10/app/Controllers/menu.php"); // Replace with the actual path to your PHP file
    if (!response.ok) {
      throw new Error("Failed to fetch meals data");
    }

    const data = await response.json();

    // Update mealsData with the fetched data
    for (const [day, meals] of Object.entries(data)) {
      mealsData[day] = meals.map((meal) => ({
        name: meal.name,
        content: {
          main: meal.content.main,
          secondary: meal.content.secondary,
          dessert: meal.content.dessert,
        },
      }));
    }

    // Refresh the UI with the updated data
    highlightSelectedDay();
    updateMeal();
  } catch (error) {
    console.error("Error fetching meals data:", error);
  }
}

fetchMealsData();
// Call the function to fetch and update meals data

// Determine the current day and meal index based on the current time
let currentMealIndex = getCurrentMealIndex(new Date());
let currentDay = new Date().toLocaleDateString("en-US", { weekday: "long" });

// Get the meal index based on the current time
function getCurrentMealIndex(time) {
  const hour = time.getHours();
  if (hour >= 0 && hour < 9) return 0; // breakfast
  else if (hour >= 9 && hour < 15) return 1; // lunch
  else return 2; // dinner
}

// Highlight the selected day in the UI
function highlightSelectedDay() {
  days.forEach((day) => day.classList.remove("selected"));
  document
    .querySelector(`[data-day="${currentDay}"]`)
    .classList.add("selected");
}

// Update meal content based on the selected day and time slot
function updateMeal() {
  const meals = mealsData[currentDay];
  const currentMeal = meals[currentMealIndex];
  mealHeader.textContent = currentMeal.name;
  mealContent.innerHTML = `
        <p><strong>Main Dish:</strong> ${currentMeal.content.main}</p>
        <p><strong>Secondary Dish:</strong> ${currentMeal.content.secondary}</p>
        <p><strong>Dessert:</strong> ${currentMeal.content.dessert}</p>
    `;

  // Animate the content with a fade-in effect
  mealContent.animate(
    [
      { opacity: 0, transform: "translateY(-10px)" },
      { opacity: 1, transform: "translateY(0)" },
    ],
    {
      duration: 500,
      easing: "ease",
    }
  );
}

prevBtn.addEventListener("click", () => {
  const meals = mealsData[currentDay];
  currentMealIndex = (currentMealIndex - 1 + meals.length) % meals.length;
  updateMeal();
});

nextBtn.addEventListener("click", () => {
  const meals = mealsData[currentDay];
  currentMealIndex = (currentMealIndex + 1) % meals.length;
  updateMeal();
});

days.forEach((dayElement) => {
  dayElement.addEventListener("click", (event) => {
    currentDay = event.target.getAttribute("data-day");
    currentMealIndex = getCurrentMealIndex(new Date()); // Reset meal index to the current time slot
    highlightSelectedDay();
    updateMeal();
  });
});

// opening the booking form

const DisplayReport = document.getElementById("report-overlay");

DisplayReport.style.display = "none";
function openReport() {
  DisplayReport.style.display = "flex";
}

const submit = document.getElementById("submit-report");
submit.addEventListener("click", (event) => {
  const description = document.getElementById("description").value.trim();

  if (description === "") {
    Swal.fire({
      title: "Empty Description!",
      text: "Please describe the issue.",
      icon: "error",
    });
    event.preventDefault();
    return; // Stop further execution
  }
});

// closing the report overlay

const ClosingReport = document.getElementById("report-overlay");

function closeReport() {
  ClosingReport.style.display = "none";
}

// Add a click event listener to the overlay
DisplayReport.addEventListener("click", (event) => {
  // Close the form only if the click is outside the form
  if (event.target === DisplayReport) {
    closeReport();
  }
});

// toggle navbar
document.getElementById("menu-btn").addEventListener("click", function () {
  document.getElementById("nav-links").classList.toggle("open");
});




document
  .getElementById("submit-report")
  .addEventListener("click", async (e) => {
    e.preventDefault();

    const studentID = document.querySelector(".id-input").value.trim();
    const description = document.getElementById("description").value.trim();
    const fileInput = document.getElementById("file-upload").files[0];
    const csrfToken = "<?php echo $_SESSION['csrf_token']; ?>"; // Embed token from PHP

    if (!studentID || !description) {
      Swal.fire("Error", "Please fill in all required fields.", "error");
      return;
    }

    const formData = new FormData();
    formData.append("StudentID", studentID);
    formData.append("MRDescription", description);
    formData.append("csrf_token", csrfToken); // Include CSRF token
    if (fileInput) {
      formData.append("Attachment", fileInput);
    }

    try {
      const response = await fetch("../../app/Controllers/save_meal_report.php", {
        method: "POST",
        body: formData,
      });

      const textResponse = await response.text(); // Debug raw response
      console.log("Raw Response:", textResponse);

      const result = JSON.parse(textResponse); // Parse as JSON

      if (result.success) {
        Swal.fire("Success", result.message, "success");
        document.querySelector(".report-form").reset(); // Reset the form
        closeReport(); // Close the modal
      } else {
        Swal.fire("Error", result.message, "error");
      }
    } catch (error) {
      console.error("Error submitting report:", error);
      Swal.fire("Error", "Failed to submit the report. Please try again.", "error");
    }
  });
