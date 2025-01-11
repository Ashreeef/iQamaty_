document.addEventListener("DOMContentLoaded", function () {
  const addEmployeeBtn = document.querySelector(".addEmployeebtn");
  const addEmployeeForm = document.querySelector("#add-employee-form");
  const searchBar = document.querySelector("#search-bar");
  const employeeForm = document.querySelector("#employee-form");

  let showForm = false;

  // Toggle between Employees Table and Add Employee Form
  addEmployeeBtn.addEventListener("click", function () {
      showForm = !showForm;

      if (showForm) {
          addEmployeeForm.classList.remove("hidden");
          addEmployeeBtn.textContent = "See Employees";
      } else {
          addEmployeeForm.classList.add("hidden");
          addEmployeeBtn.textContent = "Add Employee";
      }
  });

  // Function to fetch employees and display them in cards
  async function fetchEmployees() {
      const employeeContainer = document.getElementById('employee-cards');
      employeeContainer.innerHTML = '<p class="loading-message">Loading employees...</p>';

      try {
          const response = await fetch('/iQamaty_10/app/Controllers/get_employees.php');
          const employees = await response.json();

          // Clear the loading message
          employeeContainer.innerHTML = '';

          if (employees && employees.length > 0) {
              employees.forEach(employee => {
                  // Create employee card for each employee
                  const card = document.createElement('div');
                  card.classList.add('friend', 'bg-white', 'rad-6', 'p-20', 'p-relative');

                  card.innerHTML = `
                      <div class="contact">
                          <i class="fa-solid fa-phone"></i>
                          <i class="fa-regular fa-envelope"></i>
                      </div>
                      <div class="txt-c">
                          <img class="rad-half mt-10 mb-10 w-100 h-100" src="${employee.ProfileImage || '/iQamaty_10/public/adminassets/imgs/default-avatar.jpg'}" alt="Employee Image" />
                          <h4 class="m-0">${employee.FirstName} ${employee.LastName}</h4>
                          <p class="c-grey fs-13 mt-5 mb-0">${employee.Role || 'Unknown Role'}</p>
                      </div>
                      <div class="info between-flex fs-13">
                          <div>
                              <a class="bg-red c-white btn-shape" href="#" onclick="removeEmployee(${employee.AdminID})">Remove</a>
                          </div>
                      </div>
                  `;
                  
                  // Append the card to the container
                  employeeContainer.appendChild(card);
              });
          } else {
              employeeContainer.innerHTML = '<p class="error-message">No employees found.</p>';
          }
      } catch (error) {
          employeeContainer.innerHTML = '<p class="error-message">Failed to load employees.</p>';
      }
  }

  // Function to validate form fields
  function validateForm() {
      const FirstName = document.getElementById("FirstName").value.trim();
      const LastName = document.getElementById("LastName").value.trim();
      const Email = document.getElementById("Email").value.trim();
      const Password = document.getElementById("Password").value.trim();
      const confirmPassword = document.getElementById("ConfirmPassword").value.trim();
      const PhoneNumber = document.getElementById("PhoneNumber").value.trim();

      let errors = [];

      // Validate First Name
      const firstnameRegex = /^[\p{L}]+$/u;
      if (FirstName === "") {
          errors.push("First Name is required.");
      } else if (!firstnameRegex.test(FirstName)) {
          errors.push("Please enter a valid first name.");
      }

      // Validate Last Name
      const lastnameRegex = /^[\p{L}]+$/u;
      if (LastName === "") {
          errors.push("Last Name is required.");
      } else if (!lastnameRegex.test(LastName)) {
          errors.push("Please enter a valid last name.");
      }

      // Validate Email
      const emailRegex = /^[a-zA-Z0-9._-]+@(dou\.algouest\.dz)$/;
      if (Email === "") {
          errors.push("Email is required.");
      } else if (!emailRegex.test(Email)) {
          if (!emailRegex.test(Email)) {
              errors.push("Please enter a valid email.");
          }
      }

      // Validate Phone
      const phoneRegex = /^(05|06|07)\d{8}$/;
      if (PhoneNumber === "") {
          errors.push("Phone number is required.");
      } else if (!phoneRegex.test(PhoneNumber)) {
          errors.push("Please enter a valid phone number.");
      }

      // Validate Password
      const passwordregex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
      if (Password === "") {
          errors.push("Password is required.");
      } else if (!passwordregex.test(Password)) {
          errors.push("Password must be at least 8 characters long and include both letters and numbers.");
      }

      // Validate Confirm Password
      if (confirmPassword === "") {
          errors.push("Confirm Password is required.");
      } else if (confirmPassword !== Password) {
          errors.push("Passwords do not match.");
      }

      return errors;
  }

  // Handle Add Employee Form Submission
  employeeForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const errors = validateForm();

      if (errors.length > 0) {
          Swal.fire({
              icon: "error",
              title: "Oops...",
              html: `<ul>${errors.map(error => `<li>${error}</li>`).join('')}</ul>`
          });
          return;
      }

      const formData = new FormData(employeeForm);

      try {
          const response = await fetch("/iQamaty_10/app/Controllers/add_employee.php", {
              method: "POST",
              body: formData,
          });
          const result = await response.json();

          if (result.success) {
              Swal.fire({
                  icon: "success",
                  title: "Employee Added",
                  text: "Employee added successfully!",
              });
              fetchEmployees();
              employeeForm.reset();
              addEmployeeBtn.click(); // Switch back to table view
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: result.message,
              });
          }
      } catch (error) {
          Swal.fire({
              icon: "error",
              title: "Error",
              text: "An error occurred while adding the employee.",
          });
      }
  });

  // Remove Employee
  async function removeEmployee(id) {
    if (!confirm("Are you sure you want to remove this employee?")) return;

    try {
        const response = await fetch(`/iQamaty_10/app/Controllers/remove_employee.php?id=${id}`, { method: "DELETE" });
        const result = await response.json();

        if (result.success) {
            alert("Employee removed successfully!");
            fetchEmployees();
        } else {
            alert("Failed to remove employee.");
        }
    } catch (error) {
        alert("An error occurred.");
    }
  }

  // Search functionality
  searchBar.addEventListener("input", function () {
      const query = searchBar.value.trim();
      fetchEmployees(query);
  });

  fetchEmployees();
});
