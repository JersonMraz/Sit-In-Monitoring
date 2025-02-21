<?php
    session_start();
    include("connection.php");

    if(!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }

    $idno = $_SESSION['id'];

    $query = "SELECT idno, firstname, midname, lastname, CONCAT(lastname, ' ', midname, ' ', firstname) AS fullname, CONCAT(firstname, ' ', lastname) AS shortname, yearlvl, course, email, session FROM users WHERE id = ?";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("i", $idno);
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
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="fonts.css">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard - CCS Sit-In</title>
    <style>
        .card-container {
            width: 100%;
            padding-top: 0;
            margin-top: 25px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            gap: 50px;
        }
        .card-container .card-1 {
            width: 25%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-container .card-1 header {
            border-radius: 15px 15px 0px 0px;
        }
        .card-container .card-1 #information-container {
            padding: 0;
        }
        .card-container .card-1 #information-container p {
            width: 100%;
            margin: 8px 0px 8px 50px;
            padding: 0;
            text-align: left;
        }
        .card-container .card-2 {
            width: 25%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-container .card-2 header {
            border-radius: 15px 15px 0px 0px;
        }
        .card-container .card-3 {
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-container .card-3 header {
            border-radius: 15px 15px 0px 0px;
        }
        .card-container .card-3 #rules-regulation {
            overflow-y: auto;
            max-height: 620px;
        }
        .card-container .card-3 #rules-regulation p {
            margin-bottom: 1rem;
            text-align: left;
        }
        .card-container .card-3 #rules-regulation ul {
            margin-left: 3em;
            margin-bottom: 1rem;
            text-align: left;
        }
        .card-container .card-3 #announcement {
            overflow-y: auto;
            max-height: 620px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="burger" onclick="toggleSidebar()" style="color: white;">
            &#9776;
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
    <div id="sidebar" class="sidebar w3-top">
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
    <div class="w3-container w3-padding-16 card-container">
        <div class="w3-container w3-card-4 card-3" id="rules" style="display: none;">
            <header class="w3-container w3-blue w3-center">
                <h4 style="font-family: 'Poppins-Medium';"><i class="fa-solid fa-shield"></i> Rules and Regulation</h4>
            </header>
            <div class="w3-container w3-padding-16 w3-center" id="rules-regulation">
                <h5 class="w3-center" style="text-transform: uppercase; font-family: 'Poppins-Medium';"><strong>University of Cebu</strong></h5>
                <p class="w3-center" style="text-transform: uppercase; font-size: .9em; font-family: 'Poppins-Medium';"><strong>College of Information & Computer Studies</strong></p>
                <br>
                <p class="w3-left" style="text-transform: uppercase; font-family: 'Poppins-Medium';"><strong>Laboratory Rules and Regulations</strong></p>
                <hr>
                <p>To avoid embarrassment and maintain camaraderie with your friends and superiors at our laboratories, please observe the following:</p>
                <p>1. Maintain silence, proper decorum, and discipline inside the laboratory. Mobile phones, walkmans and other personal pieces of equipment must be switched off.</p>
                <p>2. Games are not allowed inside the lab. This includes computer-related games, card games and other games that may disturb the operation of the lab.</p>
                <p>3. Surfing the Internet is allowed only with the permission of the instructor. Downloading and installing of software are strictly prohibited.</p>
                <p>4. Getting access to other websites not related to the course (especially pornographic and illicit sites) is strictly prohibited.</p>
                <p>5. Deleting computer files and changing the set-up of the computer is a major offense.</p>
                <p>6. Observe computer time usage carefully. A fifteen-minute allowance is given for each use. Otherwise, the unit will be given to those who wish to "sit-in".</p>
                <p>7. Observe proper decorum while inside the laboratory.</p>
                <ul>
                    <li>Do not get inside the lab unless the instructor is present.</li>
                    <li>All bags, knapsacks, and the likes must be deposited at the counter.</li>
                    <li>Follow the seating arrangement of your instructor.</li>
                    <li>At the end of class, all software programs must be closed.</li>
                    <li>Return all chairs to their proper places after using.</li>
                </ul>
                <p>8. Chewing gum, eating, drinking, smoking, and other forms of vandalism are prohibited inside the lab.</p>
                <p>9. Anyone causing a continual disturbance will be asked to leave the lab. Acts or gestures offensive to the members of the community, including public display of physical intimacy, are not tolerated.</p>
                <p>10. Persons exhibiting hostile or threatening behavior such as yelling, swearing, or disregarding requests made by lab personnel will be asked to leave the lab.</p>
                <p>11. For serious offense, the lab personnel may call the Civil Security Office (CSU) for assistance.</p>
                <p>12. Any technical problem or difficulty must be addressed to the laboratory supervisor, student assistant or instructor immediately.</p>
                <hr>
                <p style="text-transform: uppercase;"><strong>DISCIPLINARY ACTION</strong></p>
                <ul>
                    <li>First Offense - The Head or the Dean or OIC recommends to the Guidance Center for a suspension from classes for each offender.</li>
                    <li>Second and Subsequent Offenses - A recommendation for a heavier sanction will be endorsed to the Guidance Center.</li>
                </ul>
            </div>
        </div>
        <div class="w3-container w3-card-4 card-2" id="announcement" style="display: none;">
            <header class="w3-container w3-blue w3-center">
                <h4><i class="fa-solid fa-bullhorn"></i> Announcement</h4>
            </header>
            <div class="w3-container w3-padding-16" id="announcement">
                <p class="title" style="margin-top: 1rem; margin-bottom: 1rem;"><strong>CCS Admin | 2025-Feb-03</strong></p>
                <div class="w3-container w3-bottombar w3-padding-16">
                    <p>The College of Computer Studies will open the registration of students for the Sit-in privilege starting tomorrow. Thank you! Lab Supervisor</p>
                </div>
                <p class="title" style="margin-top: 1rem; margin-bottom: 1rem;"><strong>CCS Admin | 2024-May-08</strong></p>
                <div class="w3-container w3-bottombar w3-padding-16">
                    <p>Important Announcement We are excited to announce the launch of our new website! 🎉 Explore our latest products and services now!</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openAnnouncement() {
            const rules = document.getElementById("rules");
            const announcement = document.getElementById("announcement");
            announcement.style.display = "block";
            rules.style.display = "none";
        }
        function openRules() {
            const rules = document.getElementById("rules");
            const announcement = document.getElementById("announcement");
            announcement.style.display = "none";
            rules.style.display = "block";
        }
    </script>
</body>
</html>