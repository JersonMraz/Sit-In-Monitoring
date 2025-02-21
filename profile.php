<?php
    session_start();
    include("connection.php");

    if(!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }

    $id = $_SESSION["id"];

    $query = "SELECT idno, firstname, midname, lastname, password, CONCAT(lastname, ' ', midname, ' ', firstname) AS fullname, CONCAT(firstname, ' ', lastname) AS shortname, username, yearlvl, course, email, session FROM users WHERE id = ?";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('No Users Found.')</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="style.css">
    <title>Edit Profile</title>
    <style>
        .profile-container {
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            margin: auto;
            gap: 20px;
            padding: 20px;
            width: 60%;
            height: auto;
            background-color: transparent;
        }
        .profile-container .profile-menu {
            width: 400px;
            height: 70vh;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            background-color: whitesmoke;
        }
        .profile-container .profile-menu .menu {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 10%;
        }
        .profile-container .profile-menu .menu a {
            text-decoration: none;
            padding: 10px 0;
        }

        .profile-container .personal-information {
            width: 700px;
            height: 70vh;
            background-color: whitesmoke;
        }
    </style>
</head>
<body>
    <nav>
        <div class="burger" onclick="toggleSidebar()" style="color: white;">
            &#9776; <!-- Burger icon -->
        </div>
        <div class="w3-container profile">
            <a href="profile.php" style="text-decoration: none;">
                <img src="Images/profilepic.jpg" alt="ProfilePicture" style="max-height: 10rem; max-width: 10rem; height: 40px; width: 40px;" class="w3-circle w3-center">
                <div class="w3-container profile-info">
                    <p style="font-family: 'Poppins-Medium'; font-size: 15px; color: aliceblue;"><?php echo htmlspecialchars($user['shortname']) ?></p>
                    <p style="font-family: 'Poppins-Regular'; font-size: 13px; color: aliceblue;"><?php echo htmlspecialchars($user['email']) ?></p>
                </div>
            </a>
        </div>
    </nav>
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
        <a href="homepage.php" style="margin-top: 20px;" class="active"><i class="fa-solid fa-house" style="padding-right: 5px;"></i> Home</a>
        <a href="#" onclick="openAnnouncement()"><i class="fa-solid fa-bullhorn" style="padding-right: 5px;"></i> Announcement</a>
        <a href="#" onclick="openRules()"><i class="fa-solid fa-scroll" style="padding-right: 5px;"></i> Sit-In Lab Rules</a>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            if (sidebar.style.width === "250px") {
                sidebar.style.width = "0";
            } else {
                sidebar.style.width = "250px";
            }
        }
    </script>
    <div class="w3-container profile-container w3-round-large">
        <div class="w3-card profile-menu w3-round-xxlarge w3-white">
            <img src="./Images/profilepic.jpg" alt="Profile" style="width: 120px; height: 120px; margin-top: 10%;" class="w3-circle">
            <p style="margin-top: 20px;">Jerson Sullano</p>
            <p>Student</p>
            <div class="w3-container menu">
                <a href="">Personal Information</a>
                <a href="">Account Security</a>
            </div>
        </div>
        <div class="w3-card personal-information w3-round-xxlarge w3-white">
            <h4>My Profile</h3>
            <div class="w3-container myprofile">
                <img src="./Images/profilepic.jpg" alt="Profile" style="width: 120px; height: 120px;" class="w3-circle">
            </div>
        </div>
    </div>
</body>
</html>