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
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    <link href="./styles/style.css" rel="stylesheet" />
    <script src='./scripts/sidebar.js'></script>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
    <title>Add Dataset Page</title>
    <!-- Mapbox -->
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <!-- Mapbox -->
</head>

<body>
    <?php include_once("sidebar.inc"); ?>
    <section class="home-section">
        <?php include_once("navbar.inc"); ?>
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js">
        </script>
        <link rel="stylesheet"
            href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css"
            type="text/css">

        <style>
        #geocoder {
            z-index: 1;
            margin: 20px;
        }

        .mapboxgl-ctrl-geocoder {
            min-width: 100%;
        }
        </style>
        <!-- Mapbox -->
        <div style="padding-top: 90px; margin-left: 50px; width: 90%;">
            <div id="geocoder"></div>
            <div class="form-check ">
                <input class="form-check-input" type="radio" name="type" id="Origin" value="Origin" checked>
                <label class="form-check-label" for="Origin">
                    Origin
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="Destination" value="Destination">
                <label class="form-check-label" for="Destination">
                    Destination
                </label>
            </div>
            <br>
            <table id="locTable" class="table">
                <thead>
                    <tr>
                        <th scope="col"> # </th>
                        <th scope="col">Location Name </th>
                        <th scope="col">Coordinates</th>
                        <th scope="col">Type </th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <br>
            <div class="alert alert-warning" id="origintypeerror" ole="alert" style="display:none;">
                Number of Origins should be between 3-12
            </div>
            <div class="alert alert-warning" id="desitypeerror" ole="alert" style="display:none;">
                Number of Destinations should be between 3-12
            </div>
            <button class="btn btn-success add_item_btn" id="update"> Update Dataset</button>
            <button class="btn btn-danger add_item_btn" id="delete"> Delete Dataset</button>
            <br><br>
            <div class="alert alert-primary" role="alert">
                Upon Updating the Dataset, the user will be redirected to Route Planner Page
            </div>
            <!-- <pre id="result"></pre> -->
        </div>

        <script src="./scripts/addDataset.js"></script>
        <?php
        include_once("footer.inc");
        ?>
    </section>




</body>

</html>