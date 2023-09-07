<?php
session_start();
if (!isset($_SESSION["customer_name"])) {
    // $_SESSION["customer_name"] = "John Smith";
    header("location: index.php");
    exit();
}
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
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="./styles/style.css" rel="stylesheet" />
    <script src='./scripts/sidebar.js'></script>
    <title>Dashboard Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
</head>

<body>

    <?php include_once("sidebar.inc"); ?>
    <section class="home-section">
        <?php include_once("navbar.inc"); ?>

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

        <?php
        include_once("footer.inc");
        ?>
    </section>
</body>


</html>