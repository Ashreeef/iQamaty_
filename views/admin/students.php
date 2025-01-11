<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Manage student records, room assignments, and track student-related dormitory services." />
    <meta name="keywords" content="student management, student records, room assignment, dormitory students, iQamaty" />
    <title>iQamaty - Students Admin</title>
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/all.min.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/framework.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/master.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/adminassets/css/students.css" />
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

        <h1 class="p-relative">Students</h1>
        <div class="projects p-20 bg-white rad-10 m-20">
            <div class="d-flex align-center justify-between mb-20">
                <div class="d-flex align-center gap-15">
                    <input 
                        type="text" 
                        id="search-bar" 
                        placeholder="Search by name..." 
                        class="form-input" 
                        style="max-width: 250px;" 
                    />
                    <button class="btn btn-primary addStudentbtn">Add Student</button>
                </div>
            </div>

            <div class="responsive-table" id="students-table">
                <table class="fs-15 w-full">
                    <thead>
                    <tr>
                        <td>StudentID</td>
                        <td>Firstname</td>
                        <td>Lastname</td>
                        <td>School</td>
                        <td>Room</td>
                        <td>Wilaya</td>
                        <td>Email</td>
                        <td>PhoneNumber</td>
                    </tr>
                    </thead>
                    <tbody id="student-table-body">
                        <!-- will be populated by js -->
                    </tbody>
                </table>
            </div>

            <!-- add Student Form (hidden at first) -->
            <div id="add-student-form" class="hidden modern-form-container">
                <h2 class="form-title">Add a New Student</h2>
                <form id="student-form">
                    <div class="input-group">
                        <label for="StudentID" class="form-label">Student ID</label>
                        <input type="number" id="StudentID" name="StudentID" class="form-input">
                    </div>

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
                        <label for="School" class="form-label">School</label>
                        <select id="School" name="School" class="form-input">
                            <option value="ENSIA">ENSIA</option>
                            <option value="NHSM">NHSM</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="Room" class="form-label">Room</label>
                        <input type="text" id="Room" name="Room" class="form-input">
                    </div>

                    <div class="input-group">
                        <label for="Wilaya" class="form-label">Wilaya</label>
                        <select id="Wilaya" name="Wilaya" class="form-input">
                            <option value="Adrar">Adrar</option>
                            <option value="Chlef">Chlef</option>
                            <option value="Laghouat">Laghouat</option>
                            <option value="Oum El Bouaghi">Oum El Bouaghi</option>
                            <option value="Batna">Batna</option>
                            <option value="Béjaïa">Béjaïa</option>
                            <option value="Biskra">Biskra</option>
                            <option value="Béchar">Béchar</option>
                            <option value="Blida">Blida</option>
                            <option value="Bouira">Bouira</option>
                            <option value="Tamanrasset">Tamanrasset</option>
                            <option value="Tébessa">Tébessa</option>
                            <option value="Tlemcen">Tlemcen</option>
                            <option value="Tiaret">Tiaret</option>
                            <option value="Tizi Ouzou">Tizi Ouzou</option>
                            <option value="Algiers">Algiers</option>
                            <option value="Djelfa">Djelfa</option>
                            <option value="Jijel">Jijel</option>
                            <option value="Sétif">Sétif</option>
                            <option value="Saïda">Saïda</option>
                            <option value="Skikda">Skikda</option>
                            <option value="Sidi Bel Abbès">Sidi Bel Abbès</option>
                            <option value="Annaba">Annaba</option>
                            <option value="Guelma">Guelma</option>
                            <option value="Constantine">Constantine</option>
                            <option value="Médéa">Médéa</option>
                            <option value="Mostaganem">Mostaganem</option>
                            <option value="M'Sila">M'Sila</option>
                            <option value="Mascara">Mascara</option>
                            <option value="Ouargla">Ouargla</option>
                            <option value="Oran">Oran</option>
                            <option value="El Bayadh">El Bayadh</option>
                            <option value="Illizi">Illizi</option>
                            <option value="Bordj Bou Arréridj">Bordj Bou Arréridj</option>
                            <option value="Boumerdès">Boumerdès</option>
                            <option value="El Tarf">El Tarf</option>
                            <option value="Tindouf">Tindouf</option>
                            <option value="Tissemsilt">Tissemsilt</option>
                            <option value="El Oued">El Oued</option>
                            <option value="Khenchela">Khenchela</option>
                            <option value="Souk Ahras">Souk Ahras</option>
                            <option value="Tipaza">Tipaza</option>
                            <option value="Mila">Mila</option>
                            <option value="Aïn Defla">Aïn Defla</option>
                            <option value="Naâma">Naâma</option>
                            <option value="Aïn Témouchent">Aïn Témouchent</option>
                            <option value="Ghardaïa">Ghardaïa</option>
                            <option value="Relizane">Relizane</option>
                            <option value="Timimoun">Timimoun</option>
                            <option value="Bordj Badji Mokhtar">Bordj Badji Mokhtar</option>
                            <option value="Ouled Djellal">Ouled Djellal</option>
                            <option value="Béni Abbès">Béni Abbès</option>
                            <option value="In Salah">In Salah</option>
                            <option value="In Guezzam">In Guezzam</option>
                            <option value="Touggourt">Touggourt</option>
                            <option value="Djanet">Djanet</option>
                            <option value="El M'Ghair">El M'Ghair</option>
                            <option value="El Menia">El Menia</option>
                        </select>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- To include SweetAlert2 library -->
<script src="/iQamaty_10/public/adminassets/js/students.js"></script>
</body>
</html>
