<?php 
    session_start();
    include('connection.php');
    
    $loginStatus = '';
    $user = null;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $query = "SELECT id, username, password FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if(empty($username) || empty($password)) {
            $loginStatus = 'nodata';
        }

        if($result) {
            $user = mysqli_fetch_assoc($result);

            if($user && $password === $user['password']) {
                $loginStatus = 'success';
                $_SESSION['id'] = $user['id'];
            } else {
                $loginStatus = 'failed';
            }
        } else {
            $loginStatus = 'failed';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="navbar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login - Sit-In</title>
    <style>
        .w3-modal-content {
            width: 30%;
            border-radius: 8px;
        }
        .close-btn {
            cursor: pointer;
        }
        .login-container {
            margin: auto;
            width: 40%;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <!-- Login Modal -->
    <div id="login" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card">
            <div class="w3-container w3-padding-16 w3-large w3-center w3-border-bottom">
                <img src="Images/CCS Logo.png" alt="CCS" style="width: 20%;"><br>
                Login Form
            </div>
            <form class="w3-container w3-padding-24" action="login.php" method="POST">
                <input class="w3-input w3-border-blue" style="margin-bottom: 20px;" type="text" id="username" name="username" placeholder="Username">
                <input class="w3-input w3-border-blue" type="password" id="password" name="password" placeholder="Password">
    
                <button class="w3-button w3-round w3-border w3-blue w3-block w3-margin-top" style="text-transform: uppercase; margin-bottom: 3%;">Login</button>
                <p class="register-link">Don't have an account yet? <a href="register.php" class="w3-text-blue">Register here.</a></p>
            </form>
        </div>
    </div>
    <script>
        window.onload = function() {
            document.getElementById('login').style.display = 'block';
        };      
    
        <?php if ($loginStatus): ?>
            if('<?php echo $loginStatus; ?>' === 'nodata') {
                Swal.fire({
                    title: 'Oops...',
                    text: 'Please fill in all fields.',
                    icon: 'error',
                    confirmBtnText: 'Try Again'
                });
            }

            if('<?php echo $loginStatus; ?>' === 'success') {
                window.onload = function() {
                    document.getElementById('login').style.display = 'none';
                };
                Swal.fire({
                    title: 'Logged In',
                    text: 'You have successfully logged in.',
                    icon: 'success',
                    focusConfirm: false,
                    confirmButtonText: 'OK',
                    
                    timerProgressBar: true,
                    didOpen: () => {
                        document.activeElement.blur();
                        const confirmButton = Swal.getConfirmButton();
                        confirmButton.style.borderRadius = '10px';
                    },
                    willClose: () => {
                        window.location.href = "homepage.php";
                    }
                });
            } else if('<?php echo $loginStatus; ?>' === 'failed') {
                Swal.fire({
                    title: 'Oops...',
                    text: 'Please check your credentials.',
                    icon: 'error',
                    confirmBtnText: 'Try Again'
                });
            }
        <?php endif; ?>
    </script>
</body>
</html>