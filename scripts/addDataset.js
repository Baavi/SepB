mapboxgl.accessToken =
  "pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg";
const geocoder = new MapboxGeocoder({
  accessToken: mapboxgl.accessToken,
  mapboxgl: mapboxgl,
  country: "AU",
  language: "en",
  proximity: [144.96706, -37.81827]
});

geocoder.addTo("#geocoder");

// Get the geocoder results container.
// const results = document.getElementById('result');

var coord = [];
var count = 0;

function update_form() {
  var orgCoord = [],
    destCoord = [],
    coord = [];
  sessionStorage.clear();
  localStorage.clear();
  var tabled = document.getElementById("locTable");
  var Dest = 0;
  var Origin = 0;
  for (var i = 1, row; (row = tabled.rows[i]); i++) {
    //iterate through rows
    // console.log("Col1: ", row.cells[1].innerText);
    // console.log("Col2: ", row.cells[2].innerText);
    // console.log("Col3: ", row.cells[3].innerText);
    if (row.cells[3].innerText == "Destination") {
      Dest++;
      if (Dest <= 12) {
        console.log("Destination: ", Dest);
        coord.push(
          row.cells[1].innerText,
          row.cells[2].innerText,
          row.cells[3].innerText
        );
        destCoord.push(row.cells[2].innerText.split(",").map(Number));
      }
    } else {
      Origin++;
      if (Origin <= 12) {
        // console.log("Origin: ", Origin);
        coord.push(
          row.cells[1].innerText,
          row.cells[2].innerText,
          row.cells[3].innerText
        );
        orgCoord.push(row.cells[2].innerText.split(",").map(Number));
      }
    }
  }
  if (Origin > 12) {
    var typeerror = document.getElementById("origintypeerror");
    typeerror.style.display = "inline-block";
  } else {
    var typeerror = document.getElementById("origintypeerror");
    typeerror.style.display = "none";
  }
  if (Dest > 12) {
    var typeerror = document.getElementById("desitypeerror");
    typeerror.style.display = "inline-block";
  } else {
    var typeerror = document.getElementById("desitypeerror");
    typeerror.style.display = "none";
  }
  localStorage.setItem("orgCoord", JSON.stringify(orgCoord, null, 2));
  localStorage.setItem("destCoord", JSON.stringify(destCoord, null, 2));
  localStorage.setItem("sescoord", JSON.stringify(coord, null, 2));
  var retrievedData = localStorage.getItem("sescoord");
  // console.log("retrievedUpdate", retrievedData);
  let loc = JSON.parse(retrievedData);
  // console.log("retrievedUpdate", retrievedData);
  // // console.log("LOC", loc);
  // results.innerText = loc;
}

function prefill_form() {
  if (localStorage.getItem("sescoord") != undefined) {
    //Get session array data If exist
    var retrievedData = localStorage.getItem("sescoord");
    // console.log("retrievedData", retrievedData);
    let loc = JSON.parse(retrievedData);
    // console.log("LOC", loc);
    // results.innerText = loc;
    //Get session Array len
    var arraylen = Object.keys(loc).length;
    // console.log(arraylen)

    var table = document
      .getElementById("locTable")
      .getElementsByTagName("tbody")[0];
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

      //Delete Button
      var deleteButton = document.createElement("button");
      deleteButton.innerText = "Delete";
      deleteButton.classList.add("btn");
      deleteButton.classList.add("btn-warning");
      deleteButton.onclick = function (e) {
        let clickedButton = e.target;
        clickedButton.closest("tr").remove();
        update_form();
      };

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
geocoder.on("result", (e) => {
  //coordinate type
  var radios = document.getElementsByName("type");
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
  deleteButton.onclick = function (e) {
    let clickedButton = e.target;
    clickedButton.closest("tr").remove();
    update_form();
  };

  var table = document
    .getElementById("locTable")
    .getElementsByTagName("tbody")[0];
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
  updateButton.onclick = function () {
    update_form();

    //Redirect to route_planner page
    window.location.href = "route_planner_w_microhub.php";
  };

  //delete session
  var deleteButtoned = document.getElementById("delete");
  deleteButtoned.addEventListener("click", function () {
    //console.log("deleteButton");
    sessionStorage.clear();
    localStorage.clear();
    var retrievedData = localStorage.getItem("sescoord");
    // console.log("retrievedDelete", retrievedData);
    let loc = JSON.parse(retrievedData);
    // console.log("LOC", loc);
    location.reload();
  });
});

function init() {
  prefill_form();
}

window.addEventListener("load", init);
