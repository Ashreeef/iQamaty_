<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage dormitory menu items and meal schedules for students and staff." />
    <meta name="keywords" content="menu management, dormitory meals, meal schedule, student meals, iQamaty" />
    <title>iQamaty - Menu Management Admin</title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/weeklymenu.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
</head>
<body>
<div class="page d-flex">
    <?php include 'partials/sideBar.php'; ?>

    <div class="content w-full">
        <?php include 'partials/header.php'; ?>

        <h1 class="p-relative">Menu Management</h1>

        <!-- Start New Dish Form -->
        <div class="menu-section bg-white p-30 rad-15 m-20 shadow-lg">
            <h3 class="form-title">Add New Dish</h3>
            <form id="new-dish-form" class="form">
                <div class="input-group">
                    <label for="dish-name" class="form-label">Dish Name</label>
                    <input type="text" id="dish-name" name="dish-name" class="form-input" placeholder="Enter dish name" required>
                </div>

                <label class="form-label">Dish Type</label>
                <div class="radio-group">
                    <label><input type="radio" name="dish-type" value="main dish" required> Main Dish</label>
                    <label><input type="radio" name="dish-type" value="secondary dish"> Secondary Dish</label>
                    <label><input type="radio" name="dish-type" value="dessert"> Dessert</label>
                </div>

                <button type="submit" class="save-btn full-width mt-20">Add Dish</button>
            </form>
        </div>
        <!-- End New Dish Form -->

        <!-- Start Weekly Menu -->
        <div class="menu-section bg-white p-30 rad-15 m-20 shadow-lg">
            <h3 class="form-title">Create a Weekly Menu</h3>
            <form id="new-menu-form" class="form">
                <!-- Day Selection -->
                <div class="input-group">
                    <label for="days" class="form-label">Choose a Day</label>
                    <select id="days" name="days" class="form-input">
                        <option value="saturday">Saturday</option>
                        <option value="sunday">Sunday</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                    </select>
                </div>

                <!-- Meal Sections -->
                <div id="meal-section" class="meal-section">
                    <h3>Meals for Selected Day</h3>

                    <div class="meal-type">
                        <h4>Breakfast</h4>
                        <label for="breakfast-main" class="form-label">Main Dish</label>
                        <select id="breakfast-main" name="breakfast-main" class="menu-select" data-dish-type="main dish">
                            
                        </select>

                        <label for="breakfast-secondary" class="form-label">Secondary Dish</label>
                        <select id="breakfast-secondary" name="breakfast-secondary" class="menu-select" data-dish-type="secondary dish">
                            
                        </select>

                        <label for="breakfast-dessert" class="form-label">Dessert</label>
                        <select id="breakfast-dessert" name="breakfast-dessert" class="menu-select" data-dish-type="dessert">
                            
                        </select>
                    </div>

                    <div class="meal-type">
                        <h4>Lunch</h4>
                        <label for="lunch-main" class="form-label">Main Dish</label>
                        <select id="lunch-main" name="lunch-main" class="menu-select" data-dish-type="main dish">
                            
                        </select>

                        <label for="lunch-secondary" class="form-label">Secondary Dish</label>
                        <select id="lunch-secondary" name="lunch-secondary" class="menu-select" data-dish-type="secondary dish">
                            
                        </select>

                        <label for="lunch-dessert" class="form-label">Dessert</label>
                        <select id="lunch-dessert" name="lunch-dessert" class="menu-select" data-dish-type="dessert">
                            
                        </select>
                    </div>

                    <div class="meal-type">
                        <h4>Dinner</h4>
                        <label for="dinner-main" class="form-label">Main Dish</label>
                        <select id="dinner-main" name="dinner-main" class="menu-select" data-dish-type="main dish">
                            
                        </select>

                        <label for="dinner-secondary" class="form-label">Secondary Dish</label>
                        <select id="dinner-secondary" name="dinner-secondary" class="menu-select" data-dish-type="secondary dish">
                            
                        </select>

                        <label for="dinner-dessert" class="form-label">Dessert</label>
                        <select id="dinner-dessert" name="dinner-dessert" class="menu-select" data-dish-type="dessert">
                            
                        </select>
                    </div>
                </div>

                <button type="submit" class="save-btn full-width mt-20">Save Menu</button>
            </form>
        </div>
        <!-- End Weekly Menu -->

        <!-- Start Existing Dishes Table -->
        <div class="existing-menus bg-white p-20 rad-15 m-20 shadow-md">
            <h2>Existing Dishes</h2>
            <div class="responsive-table">
                <table class="fs-15 w-full">
                    <thead>
                        <tr>
                            <th>Dish ID</th>
                            <th>Dish Name</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dishes will be dynamically populated -->
                        <tr>
                            <td>1</td>
                            <td>Spaghetti</td>
                            <td>Main Dish</td>
                            <td>
                                <a href="#" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Caesar Salad</td>
                            <td>Secondary Dish</td>
                            <td>
                                <a href="#" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Chocolate Cake</td>
                            <td>Dessert</td>
                            <td>
                                <a href="#" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Existing Dishes Table -->

        <!-- Begin of current menu table-->
<div class="existing-menus current-table">
    <h2>Current Weekly Menu</h2>
    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>Meal</th>
                <th>Main</th>
                <th>Secondary</th>
                <th>Dessert</th>
            </tr>
        </thead>
        <tbody>
            <!-- Days Rows -->
            <tr>
                <td rowspan="3">Saturday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td rowspan="3">Sunday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td rowspan="3">Monday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="3">Tuesday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="3">Wednsday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="3">Thursday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="3">Friday</td>
                <td>Breakfast</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lunch</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Dinner</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

        <!-- End of current menu table-->
    </div>
</div>

<script src="/iQamaty_10/public/adminassets/js/weeklymenu.js"></script>
</body>
</html>
