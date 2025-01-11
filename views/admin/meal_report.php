<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="View and manage meal reports submitted by students." />
    <meta name="keywords" content="admin reports, meal issues, dormitory management, iQamaty" />
    <title>iQamaty - Meal Reports Admin</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/meal_report.css" />
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

        <h1 class="p-relative">Meal Reports</h1>

        <!-- Reports List -->
        <div class="reports-page d-grid m-20 gap-20">
            <!-- Reports will be injected here dynamically -->
        </div>
    </div>
</div>

<!-- Modal for view details btn -->
<div id="report-modal" class="modal">
    <div class="modal-content">
        <button class="close-btn" id="close-modal">&times;</button>
        <h2 id="modal-title"></h2>
        <p><strong>Submitted by:</strong> <span id="modal-fullname"></span></p>
        <p><strong>Date:</strong> <span id="modal-date"></span></p>
        <p><strong>Description:</strong></p>
        <p id="modal-description"></p>
        <div id="modal-image-container">
            <p><strong>Uploaded Image:</strong></p>
            <img id="modal-image" src="" alt="Uploaded Report Image" />
        </div>
    </div>
</div>

<!-- SweetAlert2 for alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/iQamaty_10/public/adminassets/js/meal_report.js"></script>
</body>
</html>