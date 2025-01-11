<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage events for students in the dormitory." />
    <meta name="keywords" content="event management, dormitory events, iQamaty" />
    <title>iQamaty - Event Management Admin</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/eventmanagement.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
</head>
<body>
<div class="page d-flex">
    <?php include 'partials/sideBar.php'; ?>

    <div class="content w-full">
        
        <?php include 'partials/header.php'; ?>

        <h1 id="event-title" class="p-relative">Event Management</h1>

        <!-- Start Event Creation Form -->
        <div class="event-creation-form bg-white p-30 rad-15 m-20 shadow-lg">
            <h3 class="form-title">Create a New Event</h3>
            <form id="event-form" enctype="multipart/form-data">
                <!-- Event Name -->
                <div class="input-group">
                    <label for="event-name" class="form-label">Event Name</label>
                    <input type="text" id="event-name" name="event-name" class="form-input" placeholder="Enter event name" required>
                </div>

                <!-- Event Picture, Date, Location -->
                <div class="form-group flex-wrap">
                    <!-- Event Picture -->
                    <div class="input-group">
                        <label for="event-picture" class="form-label">Event Picture</label>
                        <div class="file-input-wrapper">
                            <input type="file" id="event-picture" name="event-picture" class="form-input" accept="image/*">
                            <div class="file-input-label">
                                <i class="fas fa-upload"></i> Choose Image
                            </div>
                        </div>
                    </div>

                    <!-- Event Date -->
                    <div class="input-group">
                        <label for="event-date" class="form-label">Event Date</label>
                        <input type="date" id="event-date" name="event-date" class="form-input" required>
                    </div>

                    <!-- Event Location -->
                    <div class="input-group">
                        <label for="event-location" class="form-label">Location</label>
                        <input type="text" id="event-location" name="event-location" class="form-input" placeholder="Enter event location" required>
                    </div>
                </div>

                <!-- Event Description -->
                <div class="input-group">
                    <label for="event-description" class="form-label">Event Description</label>
                    <textarea id="event-description" name="event-description" class="form-input" placeholder="Enter event description" rows="4" required></textarea>
                </div>

                <!-- Event Form Link -->
                <div class="input-group">
                    <label for="event-link" class="form-label">Registration Form Link (Optional)</label>
                    <input type="url" id="event-link" name="event-link" class="form-input" placeholder="Enter registration form link">
                </div>

                <button type="submit" class="save-btn full-width mt-20">Create Event</button>
            </form>
        </div>
        <!-- End Event Creation Form -->

        <!-- Start Existing Events Table -->
        <div class="existing-events bg-white p-20 rad-10 m-20 shadow-md">
            <h2>Existing Events</h2>
            <div class="responsive-table">
                <table class="fs-15 w-full">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Event Date</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Form Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Existing Events Will Be Dynamically Populated Here -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Existing Events Table -->
    </div>
</div>

<div id="notification-container"></div>

<script src="/iQamaty_10/public/adminassets/js/eventmanagement.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--To include SweetAlert2 library-->
</body>
</html>
