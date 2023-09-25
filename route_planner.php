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
    <title>Dashboard Page</title>
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

        <!-- Mapbox -->
        <div class="ratio ratio-16x9">
            <div id='map' style='width: auto; height: 1000px; margin: 2rem;'></div>

            <script>
                let truckLocation = [144.9640, -37.8130];
                const lastAtRestaurant = 0;
                let keepTrack = [];
                const pointHopper = {};

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

                //Labels for MicroHubs
                map.on('click', (event) => {
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
                            `<br><p> MicroHub ID: ${feature.properties.Station_ID} </p><p> Name: ${feature.properties.NAME}</p><p> Address: ${feature.properties.ADDRESS}</p>`
                        )
                        .addTo(map);
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
                            `<br><p> Warehouse ID: ${feature.properties.Station_ID} </p><p> Name: ${feature.properties.NAME}</p><p> Address: ${feature.properties.ADDRESS}</p>`
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
                            `<br><p>Destination ID: ${feature.properties.WH}</p>`
                        )
                        .addTo(map);
                });


                // Create a GeoJSON feature collection for the warehouse
                const warehouse = turf.featureCollection([turf.point(truckLocation)]);

                // Create an empty GeoJSON feature collection for drop-off locations
                const dropoffs = turf.featureCollection([]);

                // Create an empty GeoJSON feature collection, which will be used as the data source for the route before users add any new data
                const nothing = turf.featureCollection([]);

                // Add truck marker
                map.on('load', async () => {
                    const marker = document.createElement('i');
                    marker.classList = 'truck bx bxs-truck';

                    // Create a new marker
                    const truckMarker = new mapboxgl.Marker(marker, {
                        draggable: true
                    }).setLngLat(truckLocation).addTo(map);

                    truckMarker.on('dragend', () => {
                        const lngLat = truckMarker.getLngLat();
                        truckLocation = [lngLat.lng, lngLat.lat];
                    });

                    map.addSource('route', {
                        type: 'geojson',
                        data: nothing
                    });

                    map.loadImage(
                        './assets/images/location_icon.png',
                        (error, image) => {
                            if (error) throw error;

                            // Add the image to the map style.
                            map.addImage('marker-15', image);
                        });

                    map.addLayer({
                            id: 'routeline-active',
                            type: 'line',
                            source: 'route',
                            layout: {
                                'line-join': 'round',
                                'line-cap': 'round'
                            },
                            paint: {
                                'line-color': '#F78643',
                                'line-width': ['interpolate', ['linear'],
                                    ['zoom'], 15, 3, 22, 15
                                ]
                            }
                        },
                        'waterway-label'
                    );

                    map.addLayer({
                        id: 'dropoffs-symbol',
                        type: 'symbol',
                        source: {
                            data: dropoffs,
                            type: 'geojson'
                        },
                        layout: {
                            'icon-allow-overlap': true,
                            'icon-ignore-placement': true,
                            'icon-image': 'marker-15'
                        }
                    });

                    map.addLayer({
                            id: 'routearrows',
                            type: 'symbol',
                            source: 'route',
                            layout: {
                                'symbol-placement': 'line',
                                'text-field': '▶',
                                'text-size': ['interpolate', ['linear'],
                                    ['zoom'], 12, 24, 22, 60
                                ],
                                'symbol-spacing': ['interpolate', ['linear'],
                                    ['zoom'], 12, 30, 22, 160
                                ],
                                'text-keep-upright': false
                            },
                            paint: {
                                'text-color': '#3887be',
                                'text-halo-color': 'hsl(55, 11%, 96%)',
                                'text-halo-width': 3
                            }
                        },
                        'waterway-label'
                    );

                    // Listen for a click on the map
                    await map.on('click', addWaypoints);
                });

                async function addWaypoints(event) {
                    // When the map is clicked, add a new drop off point
                    // and update the `dropoffs-symbol` layer
                    await newDropoff(map.unproject(event.point));
                    updateDropoffs(dropoffs);
                }

                async function newDropoff(coordinates) {
                    // Store the clicked point as a new GeoJSON feature with
                    // two properties: `orderTime` and `key`
                    const pt = turf.point([coordinates.lng, coordinates.lat], {
                        orderTime: Date.now(),
                        key: Math.random()
                    });
                    dropoffs.features.push(pt);
                    pointHopper[pt.properties.key] = pt;

                    // Make a request to the Optimization API
                    const query = await fetch(assembleQueryURL(), {
                        method: 'GET'
                    });
                    const response = await query.json();

                    console.log(response.trips);

                    // Create an alert for any requests that return an error
                    if (response.code !== 'Ok') {
                        const handleMessage =
                            response.code === 'InvalidInput' ?
                            'Refresh to start a new route. For more information: https://docs.mapbox.com/api/navigation/optimization/#optimization-api-errors' :
                            'Try a different point.';
                        alert(`${response.code} - ${response.message}\n\n${handleMessage}`);
                        // Remove invalid point
                        dropoffs.features.pop();
                        delete pointHopper[pt.properties.key];
                        return;
                    }

                    // Create a GeoJSON feature collection
                    const routeGeoJSON = turf.featureCollection([
                        turf.feature(response.trips[0].geometry)
                    ]);

                    // Update the `route` source by getting the route source
                    // and setting the data equal to routeGeoJSON
                    map.getSource('route').setData(routeGeoJSON);
                }

                function updateDropoffs(geojson) {
                    map.getSource('dropoffs-symbol').setData(geojson);
                }

                // Here you'll specify all the parameters necessary for requesting a response from the Optimization API
                function assembleQueryURL() {
                    // Store the location of the truck in a constant called coordinates
                    const coordinates = [];
                    const distributions = [];
                    let restaurantIndex;
                    keepTrack = [truckLocation];

                    // Create an array of GeoJSON feature collections for each point
                    const restJobs = Object.keys(pointHopper).map((key) => pointHopper[key]);

                    // If there are any orders from this restaurant
                    if (restJobs.length > 0) {
                        // Check to see if the request was made after visiting the restaurant
                        const needToPickUp =
                            restJobs.filter((d) => {
                                return d.properties.orderTime > lastAtRestaurant;
                            }).length > 0;

                        // If the request was made after picking up from the restaurant,
                        // Add the restaurant as an additional stop
                        if (needToPickUp) {
                            restaurantIndex = coordinates.length;
                            // Add the restaurant as a coordinate
                            coordinates.push(truckLocation);
                            // push the restaurant itself into the array
                            // keepTrack.push(pointHopper.warehouse);
                        }

                        for (const job of restJobs) {
                            // Add dropoff to list
                            keepTrack.push(job);
                            coordinates.push(job.geometry.coordinates);
                            // if order not yet picked up, add a reroute
                            if (needToPickUp && job.properties.orderTime > lastAtRestaurant) {
                                distributions.push(`${restaurantIndex},${coordinates.length - 1}`);
                            }
                        }
                    }

                    // Set the profile to `driving`
                    // Coordinates will include the current location of the truck,
                    return `https://api.mapbox.com/optimized-trips/v1/mapbox/driving/${coordinates.join(
                            ';'
                        )}?distributions=${distributions.join(
                            ';'
                        )}&overview=full&steps=true&geometries=geojson&source=first&access_token=${mapboxgl.accessToken
                    }`;
                }
            </script>
            <!-- Mapbox -->

        </div>

        <?php
        include_once("footer.inc");
        ?>
    </section>
</body>

</html>