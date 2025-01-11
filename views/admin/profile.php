<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="View and edit your profile details. Manage account settings for students and staff." />
    <meta name="keywords" content="profile management, account settings, dormitory profile, iQamaty" />
    <title>iQamaty - Profile Admin</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
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

        <h1 class="p-relative">Profile</h1>
        <div class="profile-page m-20">
            <!-- Start Overview -->
            <div class="overview bg-white rad-10 d-flex align-center">
                <div class="avatar-box txt-c p-20">
                    <img class="rad-half mb-10" src="/iQamaty_10/public/adminassets/imgs/avatar.png" alt="" />
                    <h3 class="m-0">Administration</h3>
                    <div class="level rad-6 bg-eee p-relative">
                    </div>
                </div>
                <div class="info-box w-full txt-c-mobile">
                    <!-- Start Information Row -->
                    <div class="box p-20 d-flex align-center">
                        <h4 class="c-grey fs-15 m-0 w-full">General Information</h4>
                        <div class="fs-14">
                            <span class="c-grey">Full Name</span>
                            <span>Mohammed Youcef</span>
                        </div>
                        <div class="fs-14">
                            <span class="c-grey">Gender:</span>
                            <span>Male</span>
                        </div>
                        <div class="fs-14">
                            <span class="c-grey">Country:</span>
                            <span>Algeria</span>
                        </div>
                    </div>
                    <!-- End Information Row -->
                    <!-- Start Information Row -->
                    <div class="box p-20 d-flex align-center">
                        <h4 class="c-grey w-full fs-15 m-0">Personal Information</h4>
                        <div class="fs-14">
                            <span class="c-grey">Email:</span>
                            <span>md.youcef@dou.algouest.dz</span>
                        </div>
                        <div class="fs-14">
                            <span class="c-grey">Phone:</span>
                            <span>077452398</span>
                        </div>
                        <div class="fs-14">
                            <span class="c-grey">Date Of Birth:</span>
                            <span>25/10/1982</span>
                        </div>
                    </div>
                    <!-- End Information Row -->
                    <!-- Start Information Row -->
                    <div class="box p-20 d-flex align-center">
                        <h4 class="c-grey w-full fs-15 m-0">Job Information</h4>
                        <div class="fs-14">
                            <span class="c-grey">Title:</span>
                            <span>Campus Admin</span>
                        </div>
                        <div class="fs-14">
                            <span class="c-grey">Location:</span>
                            <span>Mahelma 3</span>
                        </div>
                        <div class="fs-14">
                            <span class="c-grey">Years Of Experience:</span>
                            <span>15+</span>
                        </div>
                        <!-- End Information Row -->
                    </div>
                </div>
                <!-- End Overview -->
                <!-- Start Other Data -->


                <!-- End Other Data -->
            </div>
        </div>
    </div>
    <script src="/iQamaty_10/public/adminassets/js/admin.js"></script>
</body>
</html>
