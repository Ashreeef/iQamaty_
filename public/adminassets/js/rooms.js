document.addEventListener("DOMContentLoaded", function () {
    const roomTableBody = document.querySelector("#room-table-body");
    const searchBar = document.querySelector("#search-bar");
    const filterOccupied = document.querySelector("#filter-occupied");
    const filterWing = document.querySelector("#filter-wing");
    const filteredRoomsDisplay = document.querySelector("#filtered-rooms");

    let allRooms = [];

    async function fetchRooms() {
        try {
            const response = await fetch("/iQamaty_10/app/Controllers/get_rooms.php");
            const data = await response.json();

            if (data.error) {
                roomTableBody.innerHTML = `<tr><td colspan="3">Error: ${data.error}</td></tr>`;
                filteredRoomsDisplay.textContent = "0";
                return;
            }

            allRooms = data;
            displayRooms(allRooms);
        } catch (error) {
            roomTableBody.innerHTML = `<tr><td colspan="3">Error loading data.</td></tr>`;
            filteredRoomsDisplay.textContent = "0";
        }
    }

    function displayRooms(rooms) {
        if (!rooms || rooms.length === 0) {
            roomTableBody.innerHTML = `<tr><td colspan="3">No rooms found.</td></tr>`;
        } else {
            roomTableBody.innerHTML = rooms
                .map(room => `
                    <tr>
                        <td>${room.RoomName}</td>
                        <td data-status="${room.Occupied ? 'occupied' : 'unoccupied'}">
                            ${room.Occupied ? 'Occupied' : 'Unoccupied'}
                        </td>
                        <td>${room.OccupantName || 'N/A'}</td>
                    </tr>
                `)
                .join("");
        }

        // Update displayed rooms count
        filteredRoomsDisplay.textContent = rooms.length;
    }

    function filterRooms() {
        const query = searchBar.value.trim().toLowerCase();
        const occupiedFilter = filterOccupied.value;
        const wingFilter = filterWing.value;
        
        let filtered = allRooms.slice();

        if (query) {
            filtered = filtered.filter(room =>
                (room.RoomName.toLowerCase().includes(query)) ||
                (room.OccupantName && room.OccupantName.toLowerCase().includes(query))
            );
        }

        if (occupiedFilter) {
            filtered = filtered.filter(room =>
                (occupiedFilter === "occupied" && room.Occupied) ||
                (occupiedFilter === "unoccupied" && !room.Occupied)
            );
        }

        if (wingFilter) {
            filtered = filtered.filter(room =>
                room.RoomName.startsWith(wingFilter)
            );
        }

        displayRooms(filtered);
    }

    searchBar.addEventListener("input", filterRooms);
    filterOccupied.addEventListener("change", filterRooms);
    filterWing.addEventListener("change", filterRooms)
    fetchRooms();


    const toggleManageRoomsBtn  = document.getElementById("toggle-manage-rooms");
    const roomsTableContainer   = document.getElementById("rooms-table-container");
    const manageRoomsSection    = document.getElementById("manage-rooms-section");

    let manageMode = false; 

    toggleManageRoomsBtn.addEventListener("click", () => {
        manageMode = !manageMode;
        if (manageMode) {
            roomsTableContainer.classList.add("hidden");
            manageRoomsSection.classList.remove("hidden");
            toggleManageRoomsBtn.textContent = "See Rooms";
            fetchUnoccupiedRooms();
        } else {
            roomsTableContainer.classList.remove("hidden");
            manageRoomsSection.classList.add("hidden");
            toggleManageRoomsBtn.textContent = "Manage Rooms";
        }
    });


    const studentSearch = document.getElementById("student-search");
    const studentSuggestions = document.getElementById("student-suggestions");
    const selectedStudentInfo = document.getElementById("selected-student-info");
    const currentRoomInput = document.getElementById("current-room");
    const unoccupiedRooms = document.getElementById("unoccupied-rooms");
    const assignRoomBtn = document.getElementById("assign-room-btn");
    const revokeRoomBtn = document.getElementById("revoke-room-btn");

    let selectedStudent   = null;
    let unoccupiedRoomsList = [];

    // Real-time search for student
    studentSearch.addEventListener("input", async () => {
        const query = studentSearch.value.trim();
        if (query.length < 2) {
            // Hide suggestions if less than 2 chars
            studentSuggestions.innerHTML = "";
            studentSuggestions.classList.add("hidden");
            return;
        }

        try {
            const response = await fetch(`/iQamaty_10/app/Controllers/get_students.php?query=${encodeURIComponent(query)}`);
            const students = await response.json();

            if (!Array.isArray(students)) {
                studentSuggestions.innerHTML = `<div>${students.message || students.error || 'No results'}</div>`;
                studentSuggestions.classList.remove("hidden");
                return;
            }

            // Display suggestions
            studentSuggestions.innerHTML = students.map(s => `
                <div 
                  data-id="${s.StudentID}" 
                  data-room="${s.Room || ''}">
                    ${s.FirstName} ${s.LastName} - ${s.Email}
                </div>
            `).join("");
            studentSuggestions.classList.remove("hidden");
        } catch (err) {
            console.error(err);
            studentSuggestions.innerHTML = "<div>Error fetching students</div>";
            studentSuggestions.classList.remove("hidden");
        }
    });

    // Click on a suggestion
    studentSuggestions.addEventListener("click", (e) => {
        if (e.target && e.target.dataset.id) {
            const studentID  = e.target.dataset.id;
            const studentRoom= e.target.dataset.room || "";
            const fullText   = e.target.textContent;

            // Set the selectedStudent object
            selectedStudent = {
                StudentID: studentID,
                Room: studentRoom
            };

            selectedStudentInfo.value = fullText;
            currentRoomInput.value    = studentRoom ? studentRoom : "No room assigned";

            // Show/hide Revoke button depending on if they have a room
            revokeRoomBtn.disabled    = studentRoom ? false : true;

            assignRoomBtn.disabled    = !unoccupiedRooms.value;

            studentSuggestions.innerHTML = "";
            studentSuggestions.classList.add("hidden");
        }
    });

    async function fetchUnoccupiedRooms() {
        try {
            const response = await fetch("/iQamaty_10/app/Controllers/get_unoccupied_rooms.php");
            unoccupiedRoomsList = await response.json();

            unoccupiedRooms.innerHTML = `<option value="">Select Unoccupied Room</option>`;
            if (Array.isArray(unoccupiedRoomsList)) {
                unoccupiedRoomsList.forEach(room => {
                    const opt = document.createElement("option");
                    opt.value = room.RoomID;
                    opt.textContent = room.RoomName;
                    unoccupiedRooms.appendChild(opt);
                });
            }
        } catch (err) {
            console.error(err);
        }
    }

    unoccupiedRooms.addEventListener("change", () => {
        if (selectedStudent && unoccupiedRooms.value) {
            assignRoomBtn.disabled = false;
        } else {
            assignRoomBtn.disabled = true;
        }
    });

    assignRoomBtn.addEventListener("click", async () => {
        if (!selectedStudent || !unoccupiedRooms.value) return;
        try {
            const response = await fetch("/iQamaty_10/app/Controllers/assign_room.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    studentId: selectedStudent.StudentID,
                    roomId: unoccupiedRooms.value
                })
            });
            const result = await response.json();
            if (result.success) {
                Swal.fire("Success", "Room assigned successfully.", "success");
                fetchRooms();
                fetchUnoccupiedRooms();
                // Update local student data
                selectedStudent.Room = "Assigned";
                currentRoomInput.value = "Assigned"; // or you can fetch the actual room name
                revokeRoomBtn.disabled = false; 
            } else {
                Swal.fire("Error", result.error || "Failed to assign room.", "error");
            }
        } catch (err) {
            Swal.fire("Error", "Server error while assigning room.", "error");
        }
    });

    // Revoke Room
    revokeRoomBtn.addEventListener("click", async () => {
        if (!selectedStudent) return;
        try {
            const response = await fetch("/iQamaty_10/app/Controllers/revoke_room.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    studentId: selectedStudent.StudentID
                })
            });
            const result = await response.json();
            if (result.success) {
                Swal.fire("Success", "Room revoked successfully.", "success");
                // Refresh rooms
                fetchRooms();
                // Refresh unoccupied rooms
                fetchUnoccupiedRooms();
                // Update local display
                selectedStudent.Room = "";
                currentRoomInput.value = "No room assigned";
                revokeRoomBtn.disabled = true;
            } else {
                Swal.fire("Error", result.error || "Failed to revoke room.", "error");
            }
        } catch (err) {
            Swal.fire("Error", "Server error while revoking room.", "error");
        }
    });
});