<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage lost and found items reported in the dormitory." />
    <meta name="keywords" content="lost and found management, dormitory items, iQamaty" />
    <title>iQamaty - Lost/Found Management Admin</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/lostfound.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
</head>
<body>
<div class="page d-flex">
    <?php include 'partials/sideBar.php'; ?>

    <div class="content w-full">
        <?php include 'partials/header.php'; ?>

        <h1 id="lostfound-title" class="p-relative">Lost/Found Management</h1>

        <!-- Start Lost Item Form -->
        <div class="lostfound-form bg-white p-30 rad-15 m-20 shadow-lg">
            <h3 class="form-title">Report Lost Item</h3>
            <form id="lostfound-form" enctype="multipart/form-data">
                <!-- Item Name -->
                <div class="input-group">
                    <label for="item-name" class="form-label">Item Name</label>
                    <input type="text" id="item-name" name="item-name" class="form-input" placeholder="Enter item name" required>
                </div>

                <!-- Item Details -->
                <div class="form-group flex-wrap">
                    <!-- Item Picture -->
                    <div class="input-group">
                        <label for="item-picture" class="form-label">Item Picture</label>
                        <div class="file-input-wrapper">
                            <input type="file" id="item-picture" name="item-picture" class="form-input" accept="image/*">
                            <div class="file-input-label">
                                <i class="fas fa-upload"></i> Choose Image
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="input-group">
                        <label for="item-date" class="form-label">Date Lost</label>
                        <input type="date" id="item-date" name="item-date" class="form-input" required>
                    </div>

                    <!-- Location -->
                    <div class="input-group">
                        <label for="item-location" class="form-label">Location</label>
                        <input type="text" id="item-location" name="item-location" class="form-input" placeholder="Enter location" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="input-group">
                    <label for="item-description" class="form-label">Description</label>
                    <textarea id="item-description" name="item-description" class="form-input" placeholder="Enter description" rows="4" required></textarea>
                </div>

                <button type="submit" class="save-btn full-width mt-20">Report Item</button>
            </form>
        </div>
        <!-- End Lost Item Form -->

        <!-- Start Existing Lost/Found Items -->
        <div class="existing-lostfound bg-white p-20 rad-10 m-20 shadow-md">
            <h2>Reported Items</h2>
            <div class="responsive-table">
                <table class="fs-15 w-full">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Items will be populated dynamically using JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Existing Lost/Found Items -->
    </div>
</div>

<div id="notification-container"></div>

<!-- SweetAlert2 for alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/iQamaty_10/public/adminassets/js/lostfound.js"></script>
</body>
</html>
