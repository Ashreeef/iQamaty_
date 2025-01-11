// JavaScript for Dorms Dashboard and Weekly Menu

// Function to send new dish to the backend
const addDishToDatabase = async (dishName, dishType) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_dish.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ dishName, dishType }),
        });

        const result = await response.json();

        if (result.success) {
            alert(`Dish added successfully with ID: ${result.dishID}`);
            await populateSelectOptions(); // Update the options after adding a new dish
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add the dish. Please try again.');
    }
};

// Function to fetch dishes from the backend
const fetchDishes = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/get_dish.php');
        const result = await response.json();

        if (result.success) {
            return result.data;
        } else {
            console.error(result.message);
            alert("Failed to fetch dishes.");
            return null;
        }
    } catch (error) {
        console.error('Error:', error);
        alert("Failed to fetch dishes. Please try again.");
        return null;
    }
};

// Function to populate select options
const populateSelectOptions = async () => {
    const dishes = await fetchDishes();
    if (!dishes) return;

    document.querySelectorAll('.menu-select').forEach(select => {
        const dishType = select.getAttribute('data-dish-type'); // e.g., 'main dish', 'secondary dish', 'dessert'
        const options = dishes[dishType] || [];

        // Clear existing options
        select.innerHTML = '<option value="">Select a dish</option>';

        // Add new options
        options.forEach(dish => {
            const option = document.createElement('option');
            option.value = dish.DishID;
            option.textContent = dish.DName;
            select.appendChild(option);
        });
    });
};

// Function to save the menu to the backend
document.getElementById("new-menu-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const day = document.getElementById("days").value; // Selected day
    const mealTypes = ["breakfast", "lunch", "dinner"];
    const dishes = {};

    // Check which meal type has values
    let selectedMealType = null;
    mealTypes.forEach((mealType) => {
        const main = document.getElementById(`${mealType}-main`).value;
        const secondary = document.getElementById(`${mealType}-secondary`).value;
        const dessert = document.getElementById(`${mealType}-dessert`).value;

        if (main || secondary || dessert) {
            selectedMealType = mealType;
            dishes.main = main || null;
            dishes.secondary = secondary || null;
            dishes.dessert = dessert || null;
        }
    });

    if (!selectedMealType) {
        alert("Please fill out at least one meal before saving.");
        return;
    }

    // Send data to the backend
    await saveMealToDatabase(day, selectedMealType, dishes);
});

// Save a single meal to the backend
const saveMealToDatabase = async (day, mealType, dishes) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_menu.php', { // Adjust the path
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ day, mealType, dishes }),
        });

        const result = await response.json();

        if (result.success) {
            alert(`${mealType} for ${day} saved successfully!`);
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to save the meal. Please try again.');
    }
};




// Function to fetch the current menu data from the backend
const fetchCurrentMenu = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/menu.php');
        const result = await response.json();

        if (result) {
            return result; // Return menu data
        } else {
            console.error("Failed to fetch current menu data.");
            return null;
        }
    } catch (error) {
        console.error("Error while fetching menu data:", error);
        return null;
    }
};

// Function to populate the Current Weekly Menu table
const populateCurrentMenuTable = async () => {
    const menuData = await fetchCurrentMenu();

    if (!menuData) return;

    const tableBody = document.querySelector(".current-table tbody");
    tableBody.innerHTML = ""; // Clear existing rows

    const days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    days.forEach(day => {
        const dayMenu = menuData[day] || [];

        // Create rows for breakfast, lunch, and dinner
        const mealTypes = ['Breakfast', 'Lunch', 'Dinner'];
        mealTypes.forEach((mealType, index) => {
            const row = document.createElement("tr");

            // Add Day cell with rowspan on the first meal type
            if (index === 0) {
                const dayCell = document.createElement("td");
                dayCell.textContent = day;
                dayCell.rowSpan = 3; // One cell spans all meals
                row.appendChild(dayCell);
            }

            // Add Meal type cell
            const mealTypeCell = document.createElement("td");
            mealTypeCell.textContent = mealType;
            row.appendChild(mealTypeCell);

            // Add Main, Secondary, and Dessert cells
            const mealData = dayMenu.find(menu => menu.name === mealType) || { content: {} };

            const mainCell = document.createElement("td");
            mainCell.textContent = mealData.content.main || "-";
            row.appendChild(mainCell);

            const secondaryCell = document.createElement("td");
            secondaryCell.textContent = mealData.content.secondary || "-";
            row.appendChild(secondaryCell);

            const dessertCell = document.createElement("td");
            dessertCell.textContent = mealData.content.dessert || "-";
            row.appendChild(dessertCell);

            tableBody.appendChild(row);
        });
    });
};

// Main function to initialize event listeners
document.addEventListener("DOMContentLoaded", () => {
    const newDishForm = document.getElementById("new-dish-form");
    const newMenuForm = document.getElementById("new-menu-form");
    const daysSelect = document.getElementById("days");
    const mealSection = document.getElementById("meal-section");

    // Populate select options on page load
    populateSelectOptions();

    // Populate current weekly menu table on page load
    populateCurrentMenuTable();

    // Handle new dish form submission
    newDishForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const dishName = document.getElementById('dish-name').value;
        const dishType = newDishForm.querySelector("input[name='dish-type']:checked").value;

        await addDishToDatabase(dishName, dishType);
        newDishForm.reset();
    });

    // Handle new menu form submission
    newMenuForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const selectedDay = daysSelect.value;

        // Collect selected dishes for each meal
        const menu = {
            breakfast: {
                main: document.getElementById("breakfast-main").value,
                secondary: document.getElementById("breakfast-secondary").value,
                dessert: document.getElementById("breakfast-dessert").value,
            },
            lunch: {
                main: document.getElementById("lunch-main").value,
                secondary: document.getElementById("lunch-secondary").value,
                dessert: document.getElementById("lunch-dessert").value,
            },
            dinner: {
                main: document.getElementById("dinner-main").value,
                secondary: document.getElementById("dinner-secondary").value,
                dessert: document.getElementById("dinner-dessert").value,
            },
        };

        // Save menu to database
        await saveMenuToDatabase(selectedDay, menu);
        newMenuForm.reset();
        mealSection.style.display = "none"; // Hide meal section
    });
});



// existing dishes table:
// Fetch dishes and populate the existing dishes table
const fetchAndPopulateDishes = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/get_existing_dishes.php'); // Adjust the path
        const result = await response.json();

        if (result.success) {
            const dishes = result.data;
            const tableBody = document.querySelector(".existing-menus tbody");

            // Clear existing rows
            tableBody.innerHTML = "";

            // Populate rows dynamically
            dishes.forEach(dish => {
                const row = document.createElement("tr");

                // Dish ID
                const idCell = document.createElement("td");
                idCell.textContent = dish.DishID;
                row.appendChild(idCell);

                // Dish Name
                const nameCell = document.createElement("td");
                nameCell.textContent = dish.DName;
                row.appendChild(nameCell);

                // Dish Type
                const typeCell = document.createElement("td");
                typeCell.textContent = dish.DType;
                row.appendChild(typeCell);

                // Actions
                const actionsCell = document.createElement("td");
                actionsCell.innerHTML = `<a href="#" class="delete-btn" data-id="${dish.DishID}">Delete</a>`;
                row.appendChild(actionsCell);

                tableBody.appendChild(row);
            });
        } else {
            alert(result.message || "Failed to fetch dishes.");
        }
    } catch (error) {
        console.error('Error:', error);
        alert("An error occurred while fetching dishes.");
    }
};

// Delete a dish
const deleteDish = async (dishID) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/delete_dish.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ dishID }),
        });

        const result = await response.json();

        if (result.success) {
            alert("Dish deleted successfully.");
            fetchAndPopulateDishes(); // Refresh the table
        } else {
            alert(result.message || "Failed to delete the dish.");
        }
    } catch (error) {
        console.error('Error:', error);
        alert("An error occurred while deleting the dish.");
    }
};

// Initialize table on page load
document.addEventListener("DOMContentLoaded", () => {
    fetchAndPopulateDishes();

    // Handle delete action
    document.querySelector(".existing-menus tbody").addEventListener("click", (e) => {
        if (e.target.classList.contains("delete-btn")) {
            e.preventDefault();
            const dishID = e.target.getAttribute("data-id");

            if (confirm("Are you sure you want to delete this dish?")) {
                deleteDish(dishID);
            }
        }
    });
});
