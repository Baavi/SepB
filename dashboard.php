<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="SepB" />
    <meta name="keywords" content="Web,programming" />
    <meta name="author" content="Group 19" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./styles/style.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Dashboard Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
</head>

<body>

    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="#">CityLogistics</a>
    </div>
  </nav> -->
    <div class="sidebar bg-primary">
        <div class="logo-details">
            <i class="bx bx-sitemap"></i>
            <span class="logo_name">CityLogistics</span>
        </div>
        <ul class="nav-links">
            <li class="bg-primary">
                <a href="dashboard.php" class="active">
                    <i class="bx bxs-dashboard"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-truck"></i>
                    <span class="links_name">Search by truck</span>
                </a>
            </li>
            <li>
                <a href="microhubs.php">
                    <i class="bx bx-package"></i>
                    <span class="links_name">Search by micro hubs</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-message-rounded-dots'></i>
                    <span class="links_name">Contact</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="links_name">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">Dashboard</span>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search..." />
                <i class="bx bx-search"></i>
            </div>
            <div class="profile-details">
                <img src="./assets/images/ava2.png" alt="" />
                <span class="admin_name"><?php
    $customer_name = $_SESSION["customer_name"];

    echo $customer_name;
?></span>
                
            </div>
        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Average Order Value</div>
                        <div class="number">$306.20</div>
                        <div class="indicator">
                            <i class="bx bx-down-arrow-alt down"></i>
                            <span class="text">1.3% down from last month</span>
                        </div>
                    </div>
                    <i class="bx bx-cart-alt cart"></i>
                </div>

                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Number of trucks on road</div>
                        <div class="number">150</div>
                        <div class="indicator">
                            <i class="bx bx-down-arrow-alt down"></i>
                            <span class="text">1.2% down from last month</span>
                        </div>
                    </div>
                    <i class="bx bxs-truck cart"></i>
                </div>

                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Number of micro hubs</div>
                        <div class="number">505</div>
                        <div class="indicator">
                            <i class="bx bx bx-up-arrow-alt"></i>
                            <span class="text">2.3% up from last month</span>
                        </div>
                    </div>
                    <i class="bx bx-package cart"></i>
                </div>
            </div>
        </div>
    </section>
    <?php
  include_once("footer.inc");
  ?>
    <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    };
    </script>
</body>


</html>