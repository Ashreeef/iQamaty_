<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage student records, room assignments, and track student-related dormitory services." />
    <meta name="keywords" content="student management, student records, room assignment, dormitory students, iQamaty" />
    <title>iQamaty - Students Admin</title>

    <!-- css files -->
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/sportsmanagement.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="page d-flex">
        <?php include 'partials/sideBar.php'; ?>

        <div class="content w-full">

            <?php include 'partials/header.php'; ?>

            <h1 class="p-relative">Sports Management</h1>

            <!-- Start Sport Creation Form -->
            <div class="sport-creation-form bg-white p-30 rad-15 m-20 shadow-lg">
                <h2 class="form-title">Create a New Sport</h2>
                <form id="sport-form" enctype="multipart/form-data">
                    <!-- Sport Name -->
                    <div class="input-group">
                        <label for="sport-name" class="form-label">Sport Name</label>
                        <input type="text" id="sport-name" name="sport-name" class="form-input" placeholder="Enter sport name" required>
                    </div>

                    <!-- Sport Picture, Date, Location -->
                    <div class="form-group flex-wrap">
                        <!-- Sport Picture -->
                        <div class="input-group">
                            <label for="sport-picture" class="form-label">sport Picture</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="sport-picture" name="sport-picture" class="form-input" accept="image/*">
                                <div class="file-input-label">
                                    <i class="fas fa-upload"></i> Choose Image
                                </div>
                            </div>
                        </div>



                        <!-- Sport Location -->
                        <div class="input-group">
                            <label for="sport-location" class="form-label">Location</label>
                            <input type="text" id="sport-location" name="sport-location" class="form-input" placeholder="Enter sport location" required>
                        </div>

                        <!-- Sport Register -->
                        <div class="input-group">
                            <label for="sport-register" class="form-label">Need Register</label>
                            <input type="checkbox" id="sport-register" name="sport-register" class="form-input">
                        </div>
                    </div>

                    <!-- Sport Description -->
                    <div class="input-group">
                        <label for="sport-description" class="form-label">Sport Description</label>
                        <textarea id="sport-description" name="sport-description" class="form-input" placeholder="Enter sport description" rows="4" required></textarea>
                    </div>

                    <!-- Sport Form Link -->
                    <div class="input-group">
                        <label for="sport-link" class="form-label">Registration Form Link (Optional)</label>
                        <input type="url" id="sport-link" name="sport-link" class="form-input" placeholder="Enter registration form link">
                    </div>

                    <button type="submit" class="save-btn full-width mt-20">Create sport</button>
                </form>
            </div>
            <!-- End Sports Creation Form -->

            <!-- Start Of New Team Form -->
            <div class="new-team-form">
                <h2>Add New Team</h2>
                <form id="add-team-form">
                    <label for="team-name">Team Name:</label>
                    <input type="text" id="team-name" name="team-name" placeholder="Enter team name" required>

                    <label for="team-sport">Team Sport:</label>
                    <select id="team-sport" name="team-sport" required>
                        <option value="">Select a sport</option>
                        <!-- Options will be populated dynamically -->
                    </select>

                    <button type="submit" class="btn">Add Team</button>
                </form>
            </div>
            <!-- End Of New Team Form -->

            <div class="tables-container">
                <!-- Existing Sports Table -->
                <div class="table-wrapper">
                    <h2>Existing Sports</h2>
                    <table class="sports-table">
                        <thead>
                            <tr>
                                <th>Sport Name</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be populated dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Existing Teams Table -->
                <div class="table-wrapper">
                    <h2>Existing Teams</h2>
                    <table class="teams-table">
                        <thead>
                            <tr>
                                <th>Team Name</th>
                                <th>Sport</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
                <!-- End Of Existing Teams Table -->
            </div>


            <!-- Add Student to Team Form -->
            <div class="add-student-form">
                <h2>Add Student to Team</h2>
                <form id="add-student-form">
                    <label for="student-id">Student ID:</label>
                    <input type="text" id="student-id" name="student-id" placeholder="Enter student ID" required />

                    <label for="team-select">Select Team:</label>
                    <select id="team-select" name="team-select" required>
                        <option value="">Select a team</option>
                        <!-- Options will be populated dynamically -->
                    </select>

                    <button type="submit" class="btn">Add Student</button>
                </form>
            </div>

            <!-- Team Members Viewer -->
            <div class="team-members-viewer">
                <h2>Team Members</h2>

                <!-- Team Selector -->
                <div class="team-selector">
                    <label for="team-select-viewer">Select Team:</label>
                    <select id="team-select-viewer" name="team-select-viewer">
                        <option value="">Select a team</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>

                <!-- Team Members Table -->
                <div class="table-members">
                    <table class="">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Joining Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!--End Of Team Members Viewer -->

            <!-- Add Training Session Form -->
            <div class="training-session-form">
                <h2>Add Training Session</h2>
                <form id="add-training-session-form">
                    <!-- Line for Team, Sport, and Day -->
                    <div class="form-group">
                        <div class="form-item">
                            <label for="team-select-session">Team</label>
                            <select id="team-select-session" name="team" required>
                                <option value="">Select Team</option>
                                <!-- Dynamic options will be populated -->
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="day-select">Day</label>
                            <select id="day-select" name="day" required>
                                <option value="">Select Day</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                            </select>
                        </div>
                    </div>

                    <!-- Line for Time and Coach Name -->
                    <div class="form-group">
                        <div class="form-item">
                            <label for="time-input">Time</label>
                            <input type="time" id="time-input" name="time" required>
                        </div>
                        <div class="form-item">
                            <label for="coach-name">Coach Name</label>
                            <input type="text" id="coach-name" name="coach" placeholder="Enter Coach Name" required>
                        </div>
                    </div>

                    <button type="submit" class="btn">Add Session</button>
                </form>
            </div>
            <!--End Of Add Training Session Form -->


            <!-- Training Sessions Table -->
            <div class="training-sessions-container">
                <h2>Training Sessions</h2>
                <div class="">
                    <table class="training-sessions-table">
                        <thead>
                            <tr>
                                <th>Team</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Coach</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Of Training Sessions Table -->




        </div>
    </div>


    <script src="/iQamaty_10/public/adminassets/js/sportmanagement.js"></script>
</body>

</html>