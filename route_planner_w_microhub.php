<?php
session_start();
if (!isset($_SESSION["customer_name"])) {
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
    <link href="./styles/style.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src='./scripts/sidebar.js'></script>
    <title>Route Planner</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
    <!-- Mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">
    <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
    <!-- Mapbox -->
</head>

<body>

    <?php include_once("sidebar.inc"); ?>

    <section class="home-section">
        <?php include_once("navbar.inc"); ?>
        <div class="home-content">
            <div class="overview-boxes">

                <div class="box">
                    <div class="left-side">
                        <div class="box-topic">Vehicle kms travelled (VKT)</div>
                        <div class="number" id="total-vkt">306.20 km</div>
                        <!-- <div class="indicator">
                            <i class="bx bx-down-arrow-alt down"></i>
                            <span class="text">1.3% down from last month</span>
                        </div> -->
                    </div>
                    <i class="bx bxs-truck cart"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                        <div class="box-topic">Total Travel Time</div>
                        <div class="number" id="total-travel-time">2 hours</div>
                        <!-- <div class="indicator">
                            <i class="bx bx-down-arrow-alt down"></i>
                            <span class="text">1.3% down from last month</span>
                        </div> -->
                    </div>
                    <i class="bx bxs-time cart"></i>
                </div>

                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">CO2 emissions</div>
                        <div class="number" id="co2-emissions">150</div>
                        <!-- <div class="indicator">
                            <i class="bx bx-down-arrow-alt down"></i>
                            <span class="text">1.2% down from last month</span>
                        </div> -->
                    </div>
                    <i class="bx bxs-radiation cart"></i>
                </div>
            </div>
            <!-- Mapbox -->
            <div class="ratio ratio-16x9">
                <div id='map' style='width: auto; height: 1000px; margin: 2rem;'></div>
                <script src="./scripts/route_planner.js"></script>

            </div>
        </div>

        <?php
        include_once("footer.inc");
        ?>
    </section>
</body>

</html>