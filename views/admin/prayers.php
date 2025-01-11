<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="Manage daily prayer times for students in the dormitory."
    />
    <meta
        name="keywords"
        content="prayer times management, dormitory services, iQamaty"
    />
    <title>iQamaty - Prayer Times Admin</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/prayertimes.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap"
        rel="stylesheet"
    />
</head>
<body>
<div class="page d-flex">

    <?php include 'partials/sideBar.php'; ?>

    <div class="content w-full">
        
        <?php include 'partials/header.php'; ?>

        <h1 id="week-title" class="p-relative">Prayer Times Management</h1>

        <!-- Start Prayer Times Form -->
        <div class="prayer-times-form bg-white p-20 rad-10 m-20">
            <form id="prayer-times-form">
                <table class="fs-15 w-full" id="prayer-times-table">
                    <thead>
                    <tr>
                        <td>Day</td>
                        <td>Date</td>
                        <td>Fajr</td>
                        <td>Dhuhr</td>
                        <td>Asr</td>
                        <td>Maghrib</td>
                        <td>Isha</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- rows will be inserted by JavaScript -->
                    </tbody>
                </table>
                <button type="submit" class="save-btn full-width mt-20">Save All</button>
            </form>
        </div>
        <!-- End Prayer Times Form -->
    </div>
</div>

<!-- Notification Container -->
<div id="notification-container"></div>

<script src="/iQamaty_10/public/adminassets/js/prayertimes.js"></script>
</body>
</html>
