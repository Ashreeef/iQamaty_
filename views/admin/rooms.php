<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage room assignments and track occupancy status." />
    <meta name="keywords" content="room management, room occupancy, dormitory rooms, iQamaty" />
    <title>iQamaty - All Rooms Admin</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/rooms.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
</head>
<body>
<div class="page d-flex">
    <?php include 'partials/sideBar.php'; ?>

    <div class="content w-full">  
        <?php include 'partials/header.php'; ?>

        <h1 class="p-relative">All Rooms</h1>
        <div class="projects p-20 bg-white rad-10 m-20">
            <div class="d-flex align-center justify-between mb-20">
                <input 
                    type="text" 
                    id="search-bar" 
                    placeholder="Search by room or occupant name..." 
                />
                <div class="filters">
                    <select id="filter-occupied" class="form-select">
                        <option value="">All</option>
                        <option value="occupied">Occupied</option>
                        <option value="unoccupied">Unoccupied</option>
                    </select>
                    <select id="filter-wing" class="form-select">
                        <option value="">All Wings</option>
                        <option value="A">Wing A</option>
                        <option value="B">Wing B</option>
                        <option value="C">Wing C</option>
                        <option value="D">Wing D</option>
                        <option value="E">Wing E</option>
                    </select>

                    <button id="toggle-manage-rooms" class="manageRoomsbtn">
                        Manage Rooms
                    </button>
                </div>
            </div>

            <!-- Displayed Rooms Count -->
            <div class="room-count">
                Displayed Rooms: <span id="filtered-rooms">0</span>
            </div>

            <div id="rooms-table-container" class="responsive-table">
                <table class="fs-15 w-full">
                    <thead>
                    <tr>
                        <td>Room Name</td>
                        <td>Occupied</td>
                        <td>Occupant Name</td>
                    </tr>
                    </thead>
                    <tbody id="room-table-body">
                        <!-- Populated dynamically via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Manage Rooms Section (initially hidden) -->
            <div id="manage-rooms-section" class="hidden modern-form-container">
                <h2 class="form-title">Manage Rooms</h2>
                
                <div class="input-group">
                    <label for="student-search">Search Student</label>
                    <input type="text" id="student-search" placeholder="Type at least 2 letters..." />
                    <div id="student-suggestions" class="suggestions hidden"></div>
                </div>

                <div class="input-group">
                    <label for="selected-student-info">Selected Student</label>
                    <input type="text" id="selected-student-info" disabled placeholder="No student selected" />
                </div>

                <div class="input-group">
                    <label for="current-room">Current Room</label>
                    <input type="text" id="current-room" disabled placeholder="N/A" />
                </div>

                <div class="input-group">
                    <label for="unoccupied-rooms">Assign an Unoccupied Room</label>
                    <select id="unoccupied-rooms">
                        <option value="">Select Unoccupied Room</option>
                        <!-- Populated dynamically -->
                    </select>
                </div>

                <div class="d-flex align-center gap-15" style="justify-content:flex-start; margin-top:15px;">
                    <button id="assign-room-btn" class="submit-btn" disabled>Assign</button>
                    <button id="revoke-room-btn" class="submit-btn" disabled>Revoke</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert2 for alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/iQamaty_10/public/adminassets/js/rooms.js"></script>
</body>
</html>
