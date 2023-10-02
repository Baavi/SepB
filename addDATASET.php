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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

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
        <div style="margin-top: 90px; margin-left: 40px;position:absolute; width: 80%;">
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
            <br>
            <button class="btn btn-success add_item_btn" id="update"> Update Dataset</button>
            <button class="btn btn-danger add_item_btn" id="delete"> Delete Dataset</button>
            <!-- <pre id="result"></pre> -->
        </div>
    </section>


    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg';
        const geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            types: 'country,region,place,postcode,locality,neighborhood'
        });

        geocoder.addTo('#geocoder');

        // Get the geocoder results container.
        // const results = document.getElementById('result');

        var coord = [];
        var count = 0;

        function prefill_form() {

            if (localStorage.getItem("sescoord") != undefined) {
                //Get session array data If exist
                var retrievedData = localStorage.getItem("sescoord");
                console.log("retrievedData", retrievedData);
                let loc = JSON.parse(retrievedData);
                // console.log("LOC", loc);
                // results.innerText = loc;
                //Get session Array len
                var arraylen = Object.keys(loc).length;
                // console.log(arraylen)

                //Delete Button
                var deleteButton = document.createElement("button");
                deleteButton.innerText = "Delete";
                deleteButton.classList.add("btn");
                deleteButton.classList.add("btn-warning");
                deleteButton.addEventListener('click', function() {
                    newRow.parentElement.removeChild(newRow);
                });

                var table = document.getElementById("locTable").getElementsByTagName('tbody')[0];
                var key = 0;
                //Prefill the table
                while (key < arraylen) {
                    var newRow = table.insertRow();
                    // Insert a cell at the end of the row
                    var newCell1 = newRow.insertCell();
                    var newCell2 = newRow.insertCell();
                    var newCell3 = newRow.insertCell();
                    var newCell4 = newRow.insertCell();
                    var newCell5 = newRow.insertCell();

                    //row counter
                    count++;
                    var cell1 = document.createTextNode(count);
                    newCell1.appendChild(cell1);
                    var cell2 = document.createTextNode(loc[key]);
                    newCell2.appendChild(cell2);
                    key++;
                    var cell3 = document.createTextNode(loc[key]);
                    newCell3.appendChild(cell3);
                    key++;
                    var cell4 = document.createTextNode(loc[key]);
                    newCell4.appendChild(cell4);
                    key++;
                    newCell5.appendChild(deleteButton);
                }
            }
        }

        // Add geocoder result to container.
        geocoder.on('result', (e) => {
            //coordinate type 
            var radios = document.getElementsByName('type');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    var type = radios[i].value;
                    break;
                }
            }

            //Delete Button
            var deleteButton = document.createElement("button");
            deleteButton.innerText = "Delete";
            deleteButton.classList.add("btn");
            deleteButton.classList.add("btn-warning");
            deleteButton.addEventListener('click', function() {
                newRow.parentElement.removeChild(newRow);
            });
            var table = document.getElementById("locTable").getElementsByTagName('tbody')[0];;
            var newRow = table.insertRow();
            // Insert a cell at the end of the row
            var newCell1 = newRow.insertCell();
            var newCell2 = newRow.insertCell();
            var newCell3 = newRow.insertCell();
            var newCell4 = newRow.insertCell();
            var newCell5 = newRow.insertCell();

            //row counter
            count++;
            var cell1 = document.createTextNode(count);
            newCell1.appendChild(cell1);
            var cell2 = document.createTextNode(e.result.place_name);
            newCell2.appendChild(cell2);
            var cell3 = document.createTextNode(e.result.geometry.coordinates);
            newCell3.appendChild(cell3);
            var cell4 = document.createTextNode(type);
            newCell4.appendChild(cell4);
            newCell5.appendChild(deleteButton);

            //update to session
            var updateButton = document.getElementById("update");
            updateButton.onclick = function() {
                var coord = [];
                sessionStorage.clear();
                localStorage.clear();
                var tabled = document.getElementById("locTable");
                var Dest = 0;
                var Origin = 0;
                for (var i = 1, row; row = tabled.rows[i]; i++) {
                    //iterate through rows
                    // console.log("Col1: ", row.cells[1].innerText);
                    // console.log("Col2: ", row.cells[2].innerText);
                    // console.log("Col3: ", row.cells[3].innerText);
                    if (row.cells[3].innerText == "Destination") {
                        Dest++;
                        if (Dest <= 4) {
                            console.log("Destination: ", Dest);
                            coord.push(row.cells[1].innerText, row.cells[2].innerText, row.cells[3].innerText);
                        }
                    } else {
                        Origin++;
                        if (Origin <= 4) {
                            console.log("Origin: ", Origin);
                            coord.push(row.cells[1].innerText, row.cells[2].innerText, row.cells[3].innerText);
                        }
                    }
                }
                if (Origin > 4) {
                    var typeerror = document.getElementById("origintypeerror");
                    typeerror.style.display = "inline-block";
                } else {
                    var typeerror = document.getElementById("origintypeerror");
                    typeerror.style.display = "none";
                }
                if (Dest > 4) {
                    var typeerror = document.getElementById("desitypeerror");
                    typeerror.style.display = "inline-block";
                } else {
                    var typeerror = document.getElementById("desitypeerror");
                    typeerror.style.display = "none";
                }
                localStorage.setItem("sescoord", JSON.stringify(coord, null, 2));
                var retrievedData = localStorage.getItem("sescoord");
                console.log("retrievedUpdate", retrievedData);
                let loc = JSON.parse(retrievedData);
                // console.log("LOC", loc);
                // results.innerText = loc;

                //Redirect to route_planner page
                window.location.href = "route_planner_w_microhub.php";
            };

            //delete session
            var deleteButton = document.getElementById("delete");
            deleteButton.addEventListener('click', function() {
                //console.log("deleteButton");
                sessionStorage.clear();
                localStorage.clear();
                var retrievedData = localStorage.getItem("sescoord");
                console.log("retrievedDelete", retrievedData);
                let loc = JSON.parse(retrievedData);
                console.log("LOC", loc);
                location.reload();
            });
        });



        function init() {
            prefill_form();
        }


        window.addEventListener("load", init);
    </script>

</body>

</html>