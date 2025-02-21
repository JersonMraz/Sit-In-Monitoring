<?php
    include("connection.php");

    $registerStatus = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idno = isset($_POST["idno"]) ? mysqli_real_escape_string($conn, $_POST["idno"]) : '';
        $lastname = isset($_POST["lastname"]) ? mysqli_real_escape_string($conn, $_POST["lastname"]) : '';
        $firstname = isset($_POST["firstname"]) ? mysqli_real_escape_string($conn, $_POST["firstname"]) : '';
        $middlename = isset($_POST["middlename"]) ? mysqli_real_escape_string($conn, $_POST["middlename"]) : '';
        $email = isset($_POST["email"]) ? mysqli_real_escape_string($conn, $_POST["email"]) : '';
        $course = isset($_POST["course"]) ? mysqli_real_escape_string($conn, $_POST["course"]) : '';
        $yearLvl = isset($_POST["year"]) ? mysqli_real_escape_string($conn, $_POST["year"]) : '';
        $username = isset($_POST["username"]) ? mysqli_real_escape_string($conn, $_POST["username"]) : '';
        $password = isset($_POST["password"]) ? mysqli_real_escape_string($conn, $_POST["password"]) : '';
        $confirmpass = isset($_POST["confirmPass"]) ? mysqli_real_escape_string($conn, $_POST["confirmPass"]) : '';

        $query = "INSERT INTO users(idno, lastname, firstname, midname, email, course, yearlvl, username, password) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if (empty($lastname) || empty($firstname) || empty($email) || empty($course) || empty($yearLvl) || empty($username) || empty($password) || empty($confirmpass)) {
            $registerStatus = 'NoData';
        }
        elseif($password <> $confirmpass) {
            $registerStatus = 'error';
        }
        elseif($conn->connect_error){
            die('Connection failed : ' .$conn->connect_error);
        }
        else {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssssiss", $idno, $lastname, $firstname, $middlename, $email, $course, $yearLvl, $username, $confirmpass);
            $stmt->execute();
            $registerStatus = 'success';
            $stmt->close();
            $conn->close();
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="w3.css">
        <link rel="stylesheet" href="fonts.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Registration</title>
        <style>
            .login-container {
                margin: auto;
                width: 40%;
                margin-top: 100px;
            }
            .register-link {
                margin-top: 15px;
                font-size: 14px;
            }
            .logo {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .logo-context {
                text-align: center;
            }
            form .persIn {
                margin-top: -20px;
                margin-bottom: 20px;
            }
            form .courseYrlvl {
                margin-top: -10px;
                margin-bottom: 20px;
            }
            form .accnt {
                margin-top: -10px;
                margin-bottom: 20px;
            }
            form .personal-information input {
                width: 90%;
                margin-bottom: 10px;
            }
            form .userpass input {
                width: 90%;
                margin-bottom: 16px;
            }
        </style>
    </head>
    <body>
        <div class="w3-card-4 login-container w3-round-large">
            <div class="w3-container w3-padding-16 w3-large w3-center w3-border-bottom" style="font-family: Poppins-Medium;">
                <img src="Images/CCS Logo.png" alt="CCS" style="width: 20%;"><br>
                Registration Form
            </div>
            <form class="w3-container w3-padding-large" action="register.php" method="POST">
                <div class="w3-container personal-information w3-padding-16 w3-border-bottom">
                    <p class="w3-large persIn">Personal Information</p>
                    <div class="w3-half">
                        <input class="w3-input w3-border-blue" type="text" id="idno" name="idno" style="font-family: 'Poppins-Light';" placeholder="IDNO">
                        <input class="w3-input w3-border-blue" type="text" id="firstname" name="firstname" style="font-family: 'Poppins-Light';" placeholder="Firstname">
                    </div>
                    <div class="w3-half">
                        <input class="w3-input w3-border-blue" type="text" id="lastname" name="lastname" style="font-family: 'Poppins-Light';" placeholder="Lastname">
                        <input class="w3-input w3-border-blue" type="text" id="middlename" name="middlename" style="font-family: 'Poppins-Light';" placeholder="Middlename">
                    </div>
                </div>

                <div class="w3-container w3-border-bottom w3-padding-16 CourseYearLvl">
                    <p class="w3-large courseYrlvl">Course & Year Level</p>
                    <div class="w3-half">
                        <select class="w3-select w3-border-blue" id="course" name="course" style="width: 90%; font-size: 14px; font-family: 'Poppins-Light';" name="Course">
                            <option value="" disabled selected>Course</option>
                            <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                            <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                            <option value="Bachelor of Science in Information System">Bachelor of Science in Information System</option>
                            <option value="Bachelor of Science in Accountancy">Bachelor of Science in Accountancy</option>
                            <option value="Bachelor of Science in Custom Administration">Bachelor of Science in Custom Administration</option>
                        </select>
                    </div>
                    <div class="w3-half">
                        <select class="w3-select w3-border-blue" id="year" name="year" style="width: 90%; font-size: 14px; font-family: 'Poppins-Light';" name="Course">
                            <option value="" disabled selected>School year</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>

                <div class="w3-container w3-border-bottom w3-padding-16 userpass">
                    <p class="w3-large accnt">Account Information</p>
                    <div class="w3-half">
                        <input class="w3-input w3-border-blue" type="text" id="username" name="username" style="font-family: 'Poppins-Light';" placeholder="Username">
                        <input class="w3-input w3-border-blue" type="password" id="password" name="password" style="font-family: 'Poppins-Light';" placeholder="Password">
                    </div>
                    <div class="w3-half">
                        <input class="w3-input w3-border-blue" type="email" id="email" name="email" style="font-family: 'Poppins-Light';" placeholder="Email Address">
                        <input class="w3-input w3-border-blue" style="margin-bottom: 11px;" type="password" id="confirmPass" name="confirmPass" style="font-family: 'Poppins-Light';" placeholder="Confirm Password">
                    </div>
                    
                </div>
                
                <button type="submit" name="submit" class="w3-button w3-round w3-blue w3-block w3-margin-top" style="font-family: Poppins-Medium;">Register</button>
                <p class="register-link">Already have an account yet? <a href="login.php" class="w3-text-blue">Login here.</a></p>
            </form>
        </div>
        <script>
            <?php if ($registerStatus): ?>
                if('<?php echo $registerStatus; ?>' === 'success') {
                    Swal.fire({
                        title: 'Perfect!',
                        text: 'You registered successfully',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    });
                } else if('<?php echo $registerStatus; ?>' === 'error') {
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Password does not match!',
                        icon: 'error',
                        confirmBtnText: 'Try Again'
                    });
                } else if('<?php echo $registerStatus; ?>' === 'NoData') {
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Please fill in all fields.',
                        icon: 'error',
                        confirmBtnText: 'Okay'
                    });
                }
            <?php endif; ?>  
        </script>
    </body>
</html>