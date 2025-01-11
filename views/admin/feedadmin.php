<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>iQamaty - Feed Management</title>

    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/feedadmin.css" />
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

        <h1 id="feed-title" class="p-relative">Feed Management</h1>

        <!-- Start Feed Form -->
        <div class="feed-form bg-white p-30 rad-15 m-20 shadow-lg">
            <h3 class="form-title">Add New Announcement</h3>
            <form id="feed-form" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="feed-title-input" class="form-label">Announcement Title</label>
                    <input
                        type="text"
                        id="feed-title-input"
                        name="feed-title"
                        class="form-input"
                        placeholder="Enter announcement title"
                        required
                    />
                </div>

                <div class="input-group">
                    <label for="feed-admin-name" class="form-label">Admin Name</label>
                    <input
                        type="text"
                        id="feed-admin-name"
                        name="feed-admin"
                        class="form-input"
                        placeholder="Enter admin name"
                        required
                    />
                </div>

                <div class="form-group flex-wrap">
                    <div class="input-group">
                        <label for="feed-image" class="form-label">Announcement Image (optional)</label>
                        <div class="file-input-wrapper">
                            <input
                                type="file"
                                id="feed-image"
                                name="feed-image"
                                class="form-input"
                                accept="image/*"
                            />
                            <div class="file-input-label">
                                <i class="fas fa-upload"></i> Choose Image
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label for="feed-description" class="form-label">Description</label>
                    <textarea
                        id="feed-description"
                        name="feed-description"
                        class="form-input"
                        placeholder="Enter announcement details"
                        rows="4"
                        required
                    ></textarea>
                </div>

                <button type="submit" class="save-btn full-width mt-20">
                    Publish Announcement
                </button>
            </form>
        </div>
        <!-- End Feed Form -->

        <!-- Start Existing Feed Items -->
        <div class="existing-feed bg-white p-20 rad-10 m-20 shadow-md">
            <h2>Existing Announcements</h2>
            <div class="responsive-table">
                <table class="fs-15 w-full">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Admin</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- items will be populated dynamically using JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Existing Feed Items -->
    </div>
</div>

<div id="notification-container"></div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/iQamaty_10/public/adminassets/js/feedadmin.js"></script>
</body>
</html>
