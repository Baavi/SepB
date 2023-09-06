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

    <title>Dashboard Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
    <!-- Mapbox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Mapbox -->
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
                <a href="truckpaths.php">
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
                    <i class="bx bx-log-out"></i>
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
            <!-- Mapbox -->
            <div class="ratio ratio-16x9">
                <div id='map' style='width: auto; height: 1000px; margin: 2rem;'></div>

                <div id="menu" style='margin: 2rem;'>
                    <input id="cllzvh04100aj01qz0te38tjh" type="radio" name="rtoggle" value="cllzvh04100aj01qz0te38tjh" checked="checked">
                    <label for="cllzvh04100aj01qz0te38tjh">Micro Hubs</label>
                    <input id="clm81oq8f00mg01rc7wfv3meb" type="radio" name="rtoggle" value="clm81oq8f00mg01rc7wfv3meb">
                    <label for="clm81oq8f00mg01rc7wfv3meb">Micro Hubs and Truck Routes</label>
                </div>

                <script>
                    mapboxgl.accessToken =
                        'pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg';
                    const map = new mapboxgl.Map({
                        container: 'map', // container ID
                        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
                        style: 'mapbox://styles/berryagt/cllzvh04100aj01qz0te38tjh', // style URL
                        center: [144.971, -37.809], // starting position
                        zoom: 12 // starting zoom
                    });

                    // Add zoom and rotation controls to the map.
                    map.addControl(new mapboxgl.NavigationControl());
                    const layerList = document.getElementById('menu');
                    const inputs = layerList.getElementsByTagName('input');

                    for (const input of inputs) {
                        input.onclick = (layer) => {
                            const layerId = layer.target.id;
                            map.setStyle('mapbox://styles/berryagt/' + layerId);
                        };
                    }
                    map.on('click', (event) => {
                        const features = map.queryRenderedFeatures(event.point, {
                            layers: ['rogue']
                        });
                        if (!features.length) {
                            return;
                        }
                        const feature = features[0];

                        const popup = new mapboxgl.Popup({
                                offset: [0, -5]
                            })
                            .setLngLat(feature.geometry.coordinates)
                            .setHTML(
                                `<br><p>WH ID: ${feature.properties.WH}</p>`
                            )
                            .addTo(map);
                    });
                </script>
                <!-- Mapbox -->
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