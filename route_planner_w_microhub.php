<?php
session_start();
if (!isset($_SESSION["customer_name"])) {
    header("location: index.php");
    exit();
}

$scenarioIDNormal = "cln2s1byp005601pmam10278g";
$scenarioIDFewer = "cln2s55te005601pyd7821hek";
$scenarioIDMore = "cln2s73u1005601rchiaj4ahe";

$scenario = (isset($_POST["scenario"])) ? $_POST["scenario"] : "All micro hubs (normal)";
switch ($scenario) {
    case "All micro hubs (normal)":
        $styleID = $scenarioIDNormal;
        break;
    case "Fewer micro hubs":
        $styleID =  $scenarioIDFewer;
        break;
    case "More micro hubs":
        $styleID =  $scenarioIDMore;
        break;
    default:
        $styleID =  $scenarioIDNormal;
        break;
}

$time = (isset($_POST["time"])) ? $_POST["time"] : "any";

$data = array(
    'styleID' => $styleID,
    'time' => $time
);
echo "<script>var data = " . json_encode($data) . ";</script>";
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
                        <div class="number text-primary" id="total-vkt">0.0 km</div>
                        <div class="text-danger" id="truck-vkt">0</div>
                        <div class="text-success" id="bike-vkt">0</div>
                    </div>
                    <i class="bx bxs-truck cart"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                        <div class="box-topic">Total Travel Time</div>
                        <div class="number text-primary" id="total-travel-time">0 hours</div>
                        <div class="text-danger" id="truck-time">0</div>
                        <div class="text-success" id="bike-time">0</div>
                    </div>
                    <i class="bx bxs-time cart"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                        <div class="box-topic">Transportation Cost</div>
                        <div class="number text-primary" id="total-cost">$0.0 </div>
                        <div class="text-danger" id="truck-cost">$0.0</div>
                        <div class="text-success" id="bike-cost">$0.0</div>
                    </div>
                    <i class="bx bxs-badge-dollar cart"></i>
                </div>

                <div class="box">
                    <div class="left-side">
                        <div class="box-topic">CO2 emissions
                            <span class="text-danger">from truck</span>
                        </div>
                        <div class="number text-warning" id="co2-emissions">0</div>
                        <br><br><br>
                    </div>
                    <i class="bx bxs-radiation cart"></i>
                </div>
            </div>
            <h3 class="m-3">Scenario: <?php echo $scenario ?> - Time: <?php echo $time ?></h3>
            <!-- Mapbox -->
            <div class="ratio ratio-16x9">
                <div class='map-scenario'>
                <h4>Map settings</h4>
                <form action="route_planner_w_microhub.php" method="post" class="required">

                    <p class="fw-bolder field-required">Select scenario:</p>
                    <div class="form-check"><input type="radio" name="scenario" value="All micro hubs (normal)" class="form-check-input" <?php if (!isset($_POST["scenario"]) || $_POST["scenario"] == "All micro hubs (normal)") echo ("checked='checked'"); ?> />
                        <label for="normal" class="form-check-label">All micro hubs (Normal)</label>
                    </div>
                    <div class="form-check"><input type="radio" name="scenario" value="Fewer micro hubs" class="form-check-input" <?php if (isset($_POST["scenario"]) && $_POST["scenario"] == "Fewer micro hubs") echo ("checked='checked'"); ?> />
                        <label for="fewer" class="form-check-label">Fewer micro hubs</label>
                    </div>
                    <div class="form-check mb-3"><input type="radio" name="scenario" value="More micro hubs" class="form-check-input" <?php if (isset($_POST["scenario"]) && $_POST["scenario"] == "More micro hubs") echo ("checked='checked'"); ?> />
                        <label for="more" class="form-check-label">More micro hubs</label>
                    </div>

                    <p><label for="time" class="fw-bolder field-required">Time:</label>
                        <select name="time" id="time" class="form-select">
                            <option value="any">Any</option>
                            <option value="05:00">05:00</option>
                            <option value="08:00">08:00</option>
                            <option value="13:00">13:00</option>
                            <option value="17:00">17:00</option>
                            <option value="20:00">20:00</option>
                            <option value="23:00">23:00</option>
                        </select>
                    </p>
                    <p>
                        <input type="submit" value="Apply" class="btn btn-primary" />
                    </p>
                </div>
                <div class='map-key'>
                    <h6><strong>Map keys</strong></h6>
                    <table>
                        <tr>
                            <td><img src="./assets/images/microhub.svg"></td>
                            <td>Micro hubs</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/warehouse_icon.svg"></td>
                            <td>Used micro hubs</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/location_icon_2.png"></td>
                            <td>Origins</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/location_icon.png"></td>
                            <td>Destinations</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/origin_truck_path.svg"></td>
                            <td>Truck paths <br>at origin hub</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/hub-to-hub_path.svg"></td>
                            <td>Truck paths <br>hub to hub</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/dest_truck_path.svg"></td>
                            <td>Truck paths <br>at destination hub</td>
                        </tr>
                        <tr>
                            <td><img src="./assets/images/dest_bike_path.svg"></td>
                            <td>Bike paths <br>at destination hub</td>
                        </tr>
                    </table>
                    
                </div>
                <div id='map' class="map-with-sidebar"></div>
                <script src="./scripts/route_planner.js" type="module"></script>

            </div>
        </div>

        <?php
        include_once("footer.inc");
        ?>
    </section>
</body>

</html>