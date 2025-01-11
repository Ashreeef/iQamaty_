document.addEventListener("DOMContentLoaded", function () {
    const studentTableBody = document.querySelector("#student-table-body");
    const addStudentBtn = document.querySelector(".addStudentbtn");
    const studentsTable = document.querySelector("#students-table");
    const addStudentForm = document.querySelector("#add-student-form");
    const searchBar = document.querySelector("#search-bar");
    const studentForm = document.querySelector("#student-form");

    let showForm = false;

    // Toggle between Students Table and Add Student Form
    addStudentBtn.addEventListener("click", function () {
        showForm = !showForm;

        if (showForm) {
            studentsTable.classList.add("hidden");
            addStudentForm.classList.remove("hidden");
            addStudentBtn.textContent = "See Students";
        } else {
            studentsTable.classList.remove("hidden");
            addStudentForm.classList.add("hidden");
            addStudentBtn.textContent = "Add Student";
        }
    });

    // Function to fetch students
    async function fetchStudents(query = "") { 
        try {
            const response = await fetch(`/iQamaty_10/app/Controllers/get_students.php?query=${encodeURIComponent(query)}`);
            const data = await response.json();

            if (data.error) {
                studentTableBody.innerHTML = `<tr><td colspan="8">Error: ${data.error}</td></tr>`;
                return;
            }

            if (data.message) {
                studentTableBody.innerHTML = `<tr><td colspan="8">${data.message}</td></tr>`;
                return;
            }

            studentTableBody.innerHTML = data
                .map(
                    (student) => `
                    <tr class="student-row" data-id="${student.StudentID}">
                        <td>${student.StudentID}</td>
                        <td>${student.FirstName}</td>
                        <td>${student.LastName}</td>
                        <td>${student.School}</td>
                        <td>${student.Room}</td>
                        <td>${student.Wilaya}</td>
                        <td>${student.Email}</td>
                        <!-- Last cell: Phone + trash icon -->
                        <td>
                            ${student.PhoneNumber}
                            <i class="fa fa-trash delete-student-icon" data-id="${student.StudentID}"></i>
                        </td>
                    </tr>
                `
                )
                .join("");

            // click events to trash icons
            document.querySelectorAll(".delete-student-icon").forEach(icon => {
                icon.addEventListener("click", () => {
                    const studentId = icon.dataset.id;
                    removeStudent(studentId);
                });
            });

        } catch (error) {
            studentTableBody.innerHTML = `<tr><td colspan="8">Error loading data.</td></tr>`;
        }
    }

    async function removeStudent(studentId) {
        const confirmation = await Swal.fire({
            title: "Are you sure?",
            text: "You are about to delete this student. This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel"
        });

        if (!confirmation.isConfirmed) return;

        try {
            const response = await fetch("/iQamaty_10/app/Controllers/remove_student.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ studentId })
            });

            const result = await response.json();
            if (result.success) {
                Swal.fire("Deleted!", "The student has been removed.", "success");
                fetchStudents(); // Refresh table
            } else {
                Swal.fire("Error", result.error || "Failed to delete student.", "error");
            }
        } catch (err) {
            Swal.fire("Error", "An error occurred while deleting the student.", "error");
        }
    }

    function validateForm() {
        const StudentID = document.getElementById("StudentID").value.trim();
        const FirstName = document.getElementById("FirstName").value.trim();
        const LastName = document.getElementById("LastName").value.trim();
        const Email = document.getElementById("Email").value.trim();
        const Password = document.getElementById("Password").value.trim();
        const confirmPassword = document.getElementById("ConfirmPassword").value.trim();
        const PhoneNumber = document.getElementById("PhoneNumber").value.trim();
        const School = document.getElementById("School").value.trim();
        const Room = document.getElementById("Room").value.trim();
        const Wilaya = document.getElementById("Wilaya").value.trim();

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
        const emailRegex = /^[a-zA-Z0-9._-]+@(ensia\.edu\.dz|nhsm\.edu\.dz)$/;
        if (Email === "") {
            errors.push("Email is required.");
        } else if (!emailRegex.test(Email)) {
            if (Email.includes("ensia.edu.dz") && School !== "ENSIA") {
                errors.push("Not an ENSIA student.");
            } else if (Email.includes("nhsm.edu.dz") && School !== "NHSM") {
                errors.push("Not an NHSM student.");
            } else {
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

        // Validate Student ID
        const studentIDregex = /^\d{12}$/;
        if (StudentID === "") {
            errors.push("Student ID is required.");
        } else if (!studentIDregex.test(StudentID)) {
            errors.push("Please enter a valid student ID.");
        }

        // Validate Room Number
        const roomregex = /^[AaBbCcDdEe]{1}\d{1}[- ]\d{2}$/;
        if (Room === "") {
            errors.push("Room number is required.");
        } else if (!roomregex.test(Room)) {
            errors.push("Please enter a valid room number.");
        }

        // Validate School
        if (School === "Select") {
            errors.push("Please select a school.");
        }

        // Validate Wilaya
        if (Wilaya === "Select2") {
            errors.push("Please select a Wilaya.");
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

    // Handle Add Student Form Submission
    studentForm.addEventListener("submit", async function (e) {
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

        const formData = new FormData(studentForm);

        try {
            const response = await fetch("/iQamaty_10/app/Controllers/add_student.php", {
                method: "POST",
                body: formData,
            });
            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: "success",
                    title: "Student Added",
                    text: "Student added successfully!",
                });
                fetchStudents();
                studentForm.reset();
                addStudentBtn.click(); // Switch back to table view
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
                text: "An error occurred while adding the student.",
            });
        }
    });

    // Search functionality
    searchBar.addEventListener("input", function () {
        const query = searchBar.value.trim();
        fetchStudents(query);
    });

    fetchStudents();
});
