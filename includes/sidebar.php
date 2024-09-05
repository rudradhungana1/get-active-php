<?php include "header.php" ?>

<?php if ($_SESSION['user_type'] !== 'user'): ?>

    <style>
        html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
        .w3-sidebar {
            z-index: 3;
            width: 250px;
            top: 43px;
            bottom: 0;
            height: inherit;
        }
        .w3-bar-item:hover {
            cursor: pointer;
        }
        .dropdown-btn {
            font-size: 16px;
            border: none;
            background: none;
            padding: 10px 16px;
            width: 100%;
            text-align: left;
            outline: none;
        }
        .dropdown-container {
            display: none;
            padding-left: 16px;
        }
        .dropdown-container a {
            padding: 8px 16px;
            display: block;
        }
    </style>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar" style="background: #657d19;">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
            <i class="fa fa-remove"></i>
        </a>
        <h4 class="w3-bar-item"><b>Menu</b></h4>
        <a class="w3-bar-item w3-button w3-hover-black" href="../pages/dashboard.php">Dashboard</a>

        <?php if ($_SESSION['user_type'] == 'admin'): ?>
            <a class="w3-bar-item w3-button w3-hover-black" href="../pages/contact-list.php">Contact List</a>
            <a class="w3-bar-item w3-button w3-hover-black" href="../pages/membership_request_list.php">Membership Requests</a>
            <a class="w3-bar-item w3-button w3-hover-black" href="../pages/matches.php">Matches</a>
        <?php endif; ?>

        <?php if ($_SESSION['user_type'] == 'client'): ?>
            <!-- Facilities Dropdown -->
            <button class="w3-bar-item w3-button w3-hover-black dropdown-btn">Facilities
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="w3-bar-item w3-button w3-hover-black" href="../pages/facilities_list.php">View Facilities</a>
                <a class="w3-bar-item w3-button w3-hover-black" href="../pages/add-facilities.php">Add Facilities</a>
            </div>

            <!-- Events Dropdown -->
            <button class="w3-bar-item w3-button w3-hover-black dropdown-btn">Events
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a class="w3-bar-item w3-button w3-hover-black" href="../pages/events_list.php">View Events</a>
                <a class="w3-bar-item w3-button w3-hover-black" href="../pages/add-events.php">Add Events</a>
                <a class="w3-bar-item w3-button w3-hover-black" href="../pages/booked-events.php">View Booked Events</a>
            </div>
        <?php endif; ?>

        <a class="w3-bar-item w3-button w3-hover-black" href="../controllers/logoutController.php">Log out</a>
    </nav>

    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <div class="w3-main" style="margin-left:250px"></div>

    <script>
        // Dropdown toggle
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>

<?php endif; ?>
