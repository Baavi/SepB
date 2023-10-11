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
    <title>Microhubs Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
    <!-- Mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js">
    </script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">
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
                        <div class="box-topic">Number of micro hubs</div>
                        <div class="number text-primary" id="microhub-no"></div>
                    </div>
                    <i class="bx bx-package cart"></i>
                </div>
            </div>
            <!-- Mapbox -->
            <div class="ratio ratio-16x9">
                <div class='map-sidebar'>
                    <div class='heading'>
                        <h3>Microhubs locations</h3>
                    </div>
                    <div class="search-box">
                        <input type="text" placeholder="Search..." class="w-100 form-control py-2" id="hub-search-input"/>
                        <i class="bx bx-search"></i>
                    </div>
                    <div id='listings' class='listings'></div>
                </div>
                <div id="map" class="map-with-sidebar"></div>

                <script src="scripts/microhub.js" type="module"></script>
                <!-- Mapbox -->
            </div>
        </div>

        <?php
        include_once("footer.inc");
        ?>
    </section>
</body>

</html>