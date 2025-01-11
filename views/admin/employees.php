<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>iQamaty - Employees Admin</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/employees.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
</head>
</head>
<body>
<div class="page d-flex">
    <?php include 'partials/sideBar.php'; ?>

    <div class="content w-full">
        
        <?php include 'partials/header.php'; ?>

        <h1 class="p-relative">Employees</h1>
        <div class="projects p-20 bg-white rad-10 m-20">

            <!-- Top Actions -->
            <div class="d-flex align-center justify-between mb-20">
                <div class="d-flex align-center gap-15">
                    <input 
                        type="text" 
                        id="search-bar" 
                        placeholder="Search by name..." 
                        class="form-input" 
                        style="max-width: 250px;" 
                    />
                    <button class="btn btn-primary addEmployeebtn">Add Employee</button>
                </div>
            </div>

            <!-- Add Employee Form -->
            <div id="add-employee-form" class="hidden modern-form-container">
                <h2 class="form-title">Add a New Employee</h2>
                <form id="employee-form">
                    <div class="input-group">
                        <label for="FirstName" class="form-label">First Name</label>
                        <input type="text" id="FirstName" name="FirstName" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="LastName" class="form-label">Last Name</label>
                        <input type="text" id="LastName" name="LastName" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" id="Email" name="Email" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" id="Password" name="Password" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" id="ConfirmPassword" name="ConfirmPassword" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="PhoneNumber" class="form-label">Phone Number</label>
                        <input type="text" id="PhoneNumber" name="PhoneNumber" class="form-input">
                    </div>
                    <div class="input-group">
                        <label for="ProfileImage" class="form-label">Image</label>
                        <input type="file" name="ProfileImage" id="ProfileImage" accept="image/*" class="form-input">
                    </div>
                    <div class="input-group">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                </form>
            </div>

            <!-- Employee Cards -->
            <div id="employee-cards" class="cards-container d-grid gap-20"></div>
        </div>
    </div>
</div>

<script src="/iQamaty_10/public/adminassets/js/admin.js"></script>
<script src="/iQamaty_10/public/adminassets/js/employee.js"></script>
</body>
</html>
