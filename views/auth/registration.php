<?php
require '../../vendor/autoload.php';
session_start();
include('../auth/functions.php');

use Valitron\Validator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure values are safely retrieved from the POST array
    $data = [
        'FirstName' => isset($_POST['FirstName']) ? $_POST['FirstName'] : '',
        'LastName' => isset($_POST['LastName']) ? $_POST['LastName'] : '',
        'Email' => isset($_POST['Email']) ? $_POST['Email'] : '',
        'School' => isset($_POST['School']) ? $_POST['School'] : '',
        'phoneNumber' => isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '',
        'studentID' => isset($_POST['studentID']) ? $_POST['studentID'] : '',
        'roomNumber' => isset($_POST['roomNumber']) ? $_POST['roomNumber'] : '',
        'Wilaya' => isset($_POST['Wilaya']) ? $_POST['Wilaya'] : '',
        'Password' => isset($_POST['Password']) ? $_POST['Password'] : '',
        'ConfirmPassword' => isset($_POST['ConfirmPassword']) ? $_POST['ConfirmPassword'] : ''
    ];

    $v = new Validator($data);

    // Define validation rules
    $v->rules([
        'required' => ['FirstName', 'LastName', 'Email', 'School', 'phoneNumber', 'studentID', 'roomNumber', 'Wilaya', 'Password', 'ConfirmPassword'],
        'regex' => [
            ['FirstName', '/^[\p{L}]+$/u'],
            ['LastName', '/^[\p{L}]+$/u'],
            ['Email', '/^[a-zA-Z0-9._-]+@(ensia\.edu\.dz|nhsm\.edu\.dz)$/'],
            ['phoneNumber', '/^(05|06|07)\d{8}$/'],
            ['studentID', '/^\d{12}$/'],
            ['roomNumber', '/^[AaBbCcDdEe]{1}\d{1}[- ]\d{2}$/'],
            ['Password', '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/']
        ]
    ]);

    // Custom validation for email school matching
    $v->rule('callback', 'Email', function($field, $value, array $params, array $fields) {
        $school = $fields['School'];
        if (preg_match('/ensia\.edu\.dz$/', $value) && $school !== 'ENSIA') {
            return "Not an ENSIA student.";
        }
        if (preg_match('/nhsm\.edu\.dz$/', $value) && $school !== 'NHSM') {
            return "Not an NHSM student.";
        }
        return true;
    });

    // Custom validation for confirm password
    $v->rule('callback', 'ConfirmPassword', function($field, $value, array $params, array $fields) {
        if ($value !== $fields['Password']) {
            return "Passwords do not match.";
        }
        return true;
    });

    // Perform validation
    if ($v->validate()) {
        echo "Report submitted successfully.";
    } else {
        echo "<ul>";
        foreach ($v->errors() as $field => $errors) {
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
        }
        echo "</ul>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Submit issues or report concerns related to dormitory life at iQamaty. Our team is here to ensure a safe and comfortable environment for all residents.">
    <meta name="keywords" content="report issues, student support, dormitory maintenance, safety, iQamaty support, residence reporting, iQamaty">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/report.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/registration.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>iQamaty - Sign Up Registration</title>
  </head>
  <body>

    <section class="section__container report__form__container">
      <form id="report-form" class="form report__form" method="POST">

        <label class="input-wrapper" for="FirstName">
            <input id="FirstName" name="FirstName" required placeholder=" " type="text" class="input" />
            <span>First Name</span>
          </label>
        </div>

        <label class="input-wrapper" for="LastName">
            <input id="LastName" name="LastName" required placeholder=" " type="text" class="input" />
            <span>Last Name</span>
          </label>
        </div>

        <label class="input-wrapper" for="student-id">
            <input id="student-id" name="studentID" required placeholder=" " type="text" class="input" />
            <span>Student ID</span>
          </label>
        </div>

        <label class="input-wrapper" for="Email">
            <input id="Email" name="Email" required placeholder=" " type="text" class="input" />
            <span>Email</span>
          </label>
        </div>

        <label class="input-wrapper" for="Password">
          <div class="input-field">
              <input id="Password" name="Password" required placeholder=" " type="password" class="input" />
              <span>Password</span>
              <button type="button" id="toggle-password">
                  <i class="fas fa-eye"></i>
              </button>
          </div>
        </label>

        <label class="input-wrapper" for="ConfirmPassword">
            <input id="ConfirmPassword" name="ConfirmPassword" required placeholder=" " type="password" class="input" />
            <span>Confirm Password</span>
          </label>
        </div>

        <label class="input-wrapper" for="phone-number">
          <input id="phone-number" name="phoneNumber" required placeholder=" " type="tel" class="input" />
          <span>Phone Number</span>
        </label>

        <label class="input-wrapper" for="room-number">
          <input id="room-number" name="roomNumber" required placeholder=" " type="text" class="input" />
          <span>Room Number (eg, A1 23 or A1-23)</span>
        </label>

        <label class="input-wrapper" for="Wilaya">
          <select id="Wilaya" name="Wilaya" required class="input">
            <option value="" disabled selected hidden></option>
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
          <span>Wilaya</span>
        </label>

        <button class="submit" type="submit">Submit Report</button>
      </form>
    </section>

    <?php include '../partials/footer.php'; ?>

    <!-- JavaScript for Asynchronous Form Display -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--To include SweetAlert2 library-->
    <script src="../../public/js/report.js"> </script>
    <script src="iQamaty_10/views/public/js/registration.js"> </script>
  </body>
</html>
