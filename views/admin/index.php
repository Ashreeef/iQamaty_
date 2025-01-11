<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Admin Dashboard for managing dormitory operations, overseeing students and employees, and tracking projects and tasks."/>
    <title>iQamaty - Admin Dashboard</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css"/>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css"/>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css"/>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/dashboard.css"/>
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
</head>
<body>
<div class="page d-flex">

    <?php include 'partials/sideBar.php'; ?>
    <div class="content w-full">
        <?php include 'partials/header.php'; ?>

        <div class="content w-full container">
            <h1 class="p-relative page-title">Dashboard</h1>

            <!-- Row 1: Welcome & Latest Feeds -->
            <div class="row-grid two-columns gap-20 mb-20">
                <!-- Welcome Widget (static) -->
                <div class="welcome bg-white rad-10 txt-c-mobile block-mobile shadow-sm">
                    <div class="intro p-20 d-flex space-between bg-light">
                        <div>
                            <h2 class="m-0 fw-bold">Welcome</h2>
                            <p class="c-grey mt-5">Admin</p>
                        </div>
                        <img class="hide-mobile" src="/iQamaty_10/public/adminassets/imgs/welcome.png" alt="Welcome Illustration" />
                    </div>
                    <img src="/iQamaty_10/public/adminassets/imgs/avatar.png" alt="Avatar" class="avatar" />
                    <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                        <div class="info-box">
                            <span class="fw-bold">Flen</span> 
                            <span class="d-block c-grey fs-14 mt-10">Administrator</span>
                        </div>
                        <div class="info-box">
                            <span class="fw-bold" id="today-day-name">Monday</span>
                            <span class="d-block c-grey fs-14 mt-10" id="today-date"></span>
                        </div>
                        <div class="info-box">
                            <span class="fw-bold">300</span>
                            <span class="d-block c-grey fs-14 mt-10">Lunch Served</span>
                        </div>
                    </div>
                </div>

                <!-- Latest Feeds Widget (static) -->
                <div class="latest-news p-20 bg-white rad-10 txt-c-mobile shadow-sm">
                    <h2 class="mt-0 mb-20 fw-bold">Latest Feeds (Backend Needed)</h2>
                    <ul class="feeds-list">
                        <li><i class="fa fa-bullhorn c-blue"></i> New WiFi routers installed on 2nd Floor</li>
                        <li><i class="fa fa-info-circle c-green"></i> Security drill scheduled for tomorrow morning</li>
                        <li><i class="fa fa-leaf c-orange"></i> Gardening team will clean the courtyard this weekend</li>
                        <li><i class="fa fa-check-circle c-red"></i> Maintenance in A1-32 completed successfully</li>
                    </ul>
                </div>
            </div>

            <!-- Row 2: Tasks & Today's Menu -->
            <div class="row-grid two-columns gap-20 mb-20">
                <!-- Tasks Widget -->
                <div class="tasks p-20 bg-white rad-10 shadow-sm">
                    <h2 class="mt-0 mb-20 fw-bold">Dormitory Administration Tasks</h2>
                    <div class="add-task d-flex">
                        <input type="text" id="task-input" placeholder="Enter a new task" class="task-input">
                        <button id="add-task-btn" class="btn-primary">Add Task</button>
                    </div>
                    <!-- Task list container -->
                    <div id="task-list" class="mt-20"></div>
                </div>

                <!-- Today's Menu Widget -->
                <div class="search-items p-20 bg-white rad-10 shadow-sm">
                    <h2 class="mt-0 mb-20 fw-bold">Today's Menu</h2>
                    <ul class="menu-list" id="todays-menu">
                        <!-- filled with js -->
                    </ul>
                </div>
            </div>

            <!-- Row 3: Stats Section -->
            <div class="stats-section d-grid gap-20 mb-20">
                <div class="stat-box bg-white p-20 rad-10 shadow-sm">
                    <h3 class="fw-bold">Total Users</h3>
                    <p class="fs-30 fw-bold c-blue mt-10" id="total-users">Loading...</p>
                </div>
                <div class="stat-box bg-white p-20 rad-10 shadow-sm">
                    <h3 class="fw-bold">Pending Reports</h3>
                    <p class="fs-30 fw-bold c-red mt-10" id="pending-reports">Loading...</p>
                </div>
                <div class="stat-box bg-white p-20 rad-10 shadow-sm">
                    <h3 class="fw-bold">Upcoming Events</h3>
                    <p class="fs-30 fw-bold c-green mt-10" id="upcoming-events">Loading...</p>
                </div>
                <div class="stat-box bg-white p-20 rad-10 shadow-sm">
                    <h3 class="fw-bold">Occupied Rooms</h3>
                    <p class="fs-30 fw-bold c-orange mt-10" id="occupied-rooms">Loading...</p>
                </div>
            </div>

            <!-- Row 4: Charts Section -->
            <div class="charts-section d-grid gap-20 mb-20 two-columns">
                <div class="bg-white p-20 rad-10 shadow-sm">
                    <h3 class="mb-20 fw-bold">Reports Over Time</h3>
                    <canvas id="reportsChart"></canvas>
                </div>
                <div class="bg-white p-20 rad-10 shadow-sm">
                    <h3 class="mb-20 fw-bold">Reports by Category</h3>
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- Row 5: Projects Table (static) -->
            <div class="projects p-20 bg-white rad-10 mb-20 shadow-sm">
                <h2 class="mt-0 mb-20 fw-bold">Dormitory Projects (change OR backend needed)</h2>
                <div class="responsive-table">
                    <table class="fs-15 w-full">
                        <thead>
                            <tr>
                                <td>Project Name</td>
                                <td>Finish Date</td>
                                <td>Supervisor</td>
                                <td>Budget</td>
                                <td>Team</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>WiFi Upgrade</td>
                                <td>15/10/2024</td>
                                <td>John Doe</td>
                                <td>$1,500</td>
                                <td>IT Dept</td>
                                <td><span class="bg-green c-white rad-6 p-5 fs-14">On Track</span></td>
                            </tr>
                            <tr>
                                <td>Security Cameras Installation</td>
                                <td>25/10/2024</td>
                                <td>Jane Smith</td>
                                <td>$2,000</td>
                                <td>Security Team</td>
                                <td><span class="bg-orange c-white rad-6 p-5 fs-14">Delayed</span></td>
                            </tr>
                            <tr>
                                <td>Garden Renovation</td>
                                <td>05/11/2024</td>
                                <td>Mark Wilson</td>
                                <td>$800</td>
                                <td>Volunteers</td>
                                <td><span class="bg-blue c-white rad-6 p-5 fs-14">Starting Soon</span></td>
                            </tr>
                            <tr>
                                <td>New Canteen Equipment</td>
                                <td>30/11/2024</td>
                                <td>Linda Brown</td>
                                <td>$2,500</td>
                                <td>Canteen Staff</td>
                                <td><span class="bg-green c-white rad-6 p-5 fs-14">On Track</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div> <!-- End .container -->
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/iQamaty_10/public/adminassets/js/admin.js"></script>
<script src="/iQamaty_10/public/adminassets/js/dashboard.js"></script>
</body>
</html>
