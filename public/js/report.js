// Asynchronous display with ScrollReveal
ScrollReveal().reveal('.header__content', { delay: 300 });
ScrollReveal().reveal('.report__form', { delay: 500, distance: '50px', origin: 'bottom' });

document.getElementById("menu-btn")?.addEventListener("click", function () {
    document.getElementById("nav-links").classList.toggle("open");
});

// File upload name display
const fileInput = document.getElementById('file-upload');
const fileName = document.querySelector('.file-name');

fileInput.addEventListener('change', function () {
    if (this.files.length > 0) {
        fileName.textContent = this.files[0].name;
    } else {
        fileName.textContent = 'No file chosen';
    }
});

const submitButton = document.querySelector(".submit");

submitButton.addEventListener('click', async (e) => {
    e.preventDefault(); // Prevent the form from submitting immediately

    // Get values from the form fields
    const name = document.getElementById("full-name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone-number").value.trim();
    const studentID = document.getElementById("student-id").value.trim();
    const room = document.getElementById('room-number').value.trim();
    const issue = document.getElementById('issue-category').value.trim();
    const description = document.getElementById('description').value.trim();
    const date = document.getElementById('incident-date').value.trim();
    const urgency = document.getElementById('urgency-level').value.trim();

    // Error messages container
    let errors = [];

    // Validate Name
    const nameRegex = /^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/;
    if (name === "") {
        errors.push("Name is required.");
    } else if (!nameRegex.test(name)) {
        errors.push("Please enter a valid name.");
    }

    // Validate Email
    const emailRegex = /^[a-zA-Z0-9._-]+@(ensia\.edu\.dz|nhsm\.edu\.dz)$/;
    if (email === "") {
        errors.push("Email is required.");
    } else if (!emailRegex.test(email)) {
        errors.push("Please enter a valid email.");
    }

    // Validate Phone
    const phoneRegex = /^(05|06|07)\d{8}$/;
    if (phone === "") {
        errors.push("Phone number is required.");
    } else if (!phoneRegex.test(phone)) {
        errors.push("Please enter a valid phone number.");
    }

    // Validate Student ID
    const studentIDregex = /^\d{12}$/;
    if (studentID === "") {
        errors.push("Student ID is required.");
    } else if (!studentIDregex.test(studentID)) {
        errors.push("Please enter a valid student ID.");
    }

    // Validate Room Number
    const roomregex = /^[AaBbCcDdEe]{1}(?:[Rr]|\d)\s?[- ]\d{2}$/;
    if (room === "") {
        errors.push("Room number is required.");
    } else if (!roomregex.test(room)) {
        errors.push("Please enter a valid room number.");
    }

    // Validate Type of Issue
    if (issue === "") {
        errors.push("Issue Category is required.");
    }

    // Validate Description
    if (description === "") {
        errors.push("Description field must be filled.");
    }

    // Validate Date
    if (date === "") {
        errors.push("Incident date is required.");
    }

    // Validate Urgency Level
    if (urgency === "") {
        errors.push("Urgency level is required.");
    }

    // If there are errors, show them
    if (errors.length > 0) {
        if (errors.length === 9) { // Check if all fields are empty
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "All fields are empty.",
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: `
                <ul style="text-align: left; padding-left: 20px;">
                    ${errors.map((error) => `<li>${error}</li>`).join("")}
                </ul>
                `,
                width: '400px',
            });
        }
        return;
    }
    

    // Prepare the data to send
    let reportData = {
        fullName: name,
        studentID: studentID,
        email: email,
        phoneNumber: phone,
        roomNumber: room,
        category: issue,
        description: description,
        incidentDate: date,
        incidentTime: document.getElementById('incident-time').value.trim() || null,
        urgency: urgency,
    };

    // Handle file upload
    const file = fileInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onloadend = async () => {
            reportData.fileUploaded = reader.result.split(',')[1]; // Get base64 part after comma
            reportData.fileName = file.name;
            await submitReport(reportData); // Submit the data once the file is processed
        };
        reader.readAsDataURL(file);
    } else {
        await submitReport(reportData); // Submit the data if no file is uploaded
    }
});

// Function to submit the report data to the server
async function submitReport(reportData) {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_report.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(reportData),
        });

        const result = await response.json();

        if (response.ok) {
            Swal.fire({
                title: 'Done',
                text: result.success || 'Report submitted successfully.',
                icon: 'success',
                width: '400px',
            }).then(() => {
                // Optionally reset the form after successful submission
                document.querySelector('.report__form').reset();
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: result.error || 'Failed to submit report.',
                width: '400px',
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: 'An error occurred while submitting the report. Please try again later.',
            width: '400px',
        });
    }
}
