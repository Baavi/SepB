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

                <div id='map' style='width: auto; height: 95vh; margin: 0'></div>

                <div id="menu" style='margin: 2rem;'>
                    <input id="cllzvh04100aj01qz0te38tjh" type="radio" name="rtoggle" value="cllzvh04100aj01qz0te38tjh" checked="checked">
                    <label for="cllzvh04100aj01qz0te38tjh">Micro Hubs and Destinations</label> <br>
                    <input id="clm81oq8f00mg01rc7wfv3meb" type="radio" name="rtoggle" value="clm81oq8f00mg01rc7wfv3meb">
                    <label for="clm81oq8f00mg01rc7wfv3meb">Destinations and Truck Routes</label> <br>
                    <input id="clmp1mtar01w601r881bbfgfx" type="radio" name="rtoggle" value="clmp1mtar01w601r881bbfgfx">
                    <label for="clmp1mtar01w601r881bbfgfx">Micro Hubs & Destinations and Truck Routes</label>
                </div>

                <script type="module">
                    mapboxgl.accessToken =
                        'pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg';
                    const map = new mapboxgl.Map({
                        container: 'map', // container ID
                        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
                        style: 'mapbox://styles/berryagt/cllzvh04100aj01qz0te38tjh', // style URL
                        center: [144.971, -37.809], // starting position
                        zoom: 12 // starting zoom
                    });

                    // Navigation style
                    import directionsTruckStyle from "./scripts/direction_bike_style.js";
                    var directions = new MapboxDirections({
                        styles: directionsTruckStyle,
                        accessToken: mapboxgl.accessToken,
                        unit: 'metric',
                        profile: 'mapbox/driving',
                        layer: 5,
                        container: 'directions',
                        interactive: true,
                        controls: {
                            inputs: true,
                            instructions: false,
                            profileSwitcher: true
                        }
                    });

                    // Add zoom and rotation controls to the map.
                    const layerList = document.getElementById('menu');
                    const inputs = layerList.getElementsByTagName('input');

                    for (const input of inputs) {
                        input.onclick = (layer) => {
                            map.removeControl(directions);
                            const layerId = layer.target.id;
                            map.setStyle('mapbox://styles/berryagt/' + layerId);
                        };
                    }

                    map.on('style.load', () => {    
                        map.addControl(directions, 'top-left');
                    });

                    //Labels for MicroHubs
                    map.on('click', (event) => {
                        if (map.getLayer("fuel")) {
                            const features = map.queryRenderedFeatures(event.point, {
                                layers: ['fuel']
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
                                    `<p><strong> MicroHub ID: ${feature.properties.Station_ID} </strong></p>
                            <p> Name: ${feature.properties.NAME}</p>
                            <p> Address: ${feature.properties.ADDRESS}</p>`
                                )
                                .addTo(map);
                        }
                    });
                    //Label for WH
                    map.on('click', (event) => {
                        const features = map.queryRenderedFeatures(event.point, {
                            layers: ['wh']
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
                                `<p> <strong>Warehouse ID: ${feature.properties.Station_ID} </strong></p>
                            <p> Name: ${feature.properties.NAME}</p>
                            <p> Address: ${feature.properties.ADDRESS}</p>`
                            )
                            .addTo(map);
                    });
                    //Labels for Destinations
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
                                `<p><strong>Destination ID: ${feature.properties.WH}</strong></p>`
                            )
                            .addTo(map);
                    });


                    directions.on('route', function(e) {
                        console.log(e.route); // Logs the current route shown in the interface.
                    });
                </script>
                <!-- Mapbox -->
            </div>
        </div>

        <?php
        include_once("footer.inc");
        ?>
    </section>
</body>

</html>