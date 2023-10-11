mapboxgl.accessToken =
  "pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg";
const map = new mapboxgl.Map({
  container: "map", // container ID
  // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
  style: "mapbox://styles/berryagt/cln2s1byp005601pmam10278g", // style URL
  center: [144.971, -37.509], // starting position
  zoom: 7, // starting zoom
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());

map.on("load", () => {
  var microhubFreatures = map.queryRenderedFeatures({
    layers: ["fuel"],
  });
  document.querySelector("#microhub-no").innerHTML = microhubFreatures.length;
  // Sort all microhubs by suburb
  microhubFreatures = microhubFreatures.sort(function (a, b) {
    let x = a.properties.SUBURB.toLowerCase();
    let y = b.properties.SUBURB.toLowerCase();
    if (x > y) { return 1; }
    if (x < y) { return -1; }
    return 0;
  });
  buildLocationList(microhubFreatures);

  var search_input = document.querySelector("#hub-search-input");
  search_input.addEventListener("input", function () {
    const listings = document.getElementById("listings");
    while (listings.firstChild) {
      listings.firstChild.remove();
    }
    var microhubFreaturesFiltered = microhubFreatures;
    var search_value = search_input.value.toLowerCase();
    if (search_value) {
      microhubFreaturesFiltered = microhubFreatures.filter(hub =>
        hub.properties.NAME.toLowerCase().indexOf(search_value) !== -1 || 
        hub.properties.ADDRESS.toLowerCase().indexOf(search_value) !== -1 || 
        hub.properties.SUBURB.toLowerCase().indexOf(search_value) !== -1);
    }
    buildLocationList(microhubFreaturesFiltered);

  });

});

//Labels for MicroHubs
map.on("click", (event) => {
  const features = map.queryRenderedFeatures(event.point, {
    layers: ["fuel"],
  });
  if (map.getLayer("fuel")) {
    if (!features.length) {
      return;
    }
    const feature = features[0];
    flyToHub(feature);
    createPopUp(feature);
  }

  const activeItem = document.getElementsByClassName("active");
  if (activeItem[0]) {
    activeItem[0].classList.remove("active");
  }
});

function buildLocationList(microhubFreatures) {
  for (const hub of microhubFreatures) {
    /* Add a new listing section to the sidebar. */
    const listings = document.getElementById("listings");
    const listing = listings.appendChild(document.createElement("div"));
    /* Assign a unique `id` to the listing. */
    listing.id = `listing-${hub.properties.OBJECTID}`;
    /* Assign the `item` class to each listing for styling. */
    listing.className = "item";

    /* Add the link to the individual listing created above. */
    const link = listing.appendChild(document.createElement("span"));
    link.className = "title text-info";
    link.id = `link-${hub.properties.OBJECTID}`;
    link.innerHTML = `${hub.properties.NAME}`;

    /* Add details to the individual listing. */
    const details = listing.appendChild(document.createElement("div"));
    details.className = "text-white";
    details.innerHTML = `${hub.properties.ADDRESS} · ${hub.properties.SUBURB}`;

    link.addEventListener("click", function () {
      for (const feature of microhubFreatures) {
        if (this.id === `link-${feature.properties.OBJECTID}`) {
          flyToHub(feature);
          createPopUp(feature);
        }
      }
      const activeItem = document.getElementsByClassName("active");
      if (activeItem[0]) {
        activeItem[0].classList.remove("active");
      }
      this.parentNode.classList.add("active");
    });
  }
}

function flyToHub(currentFeature) {
  map.flyTo({
    center: currentFeature.geometry.coordinates,
    zoom: 15,
  });
}

function createPopUp(feature) {
  const popUps = document.getElementsByClassName("mapboxgl-popup");
  /** Check if there is already a popup on the map and if so, remove it */
  if (popUps[0]) popUps[0].remove();

  const popup = new mapboxgl.Popup({
    offset: [0, -5],
  })
    .setLngLat(feature.geometry.coordinates)
    .setHTML(
      `<br><p><strong> MicroHub ID: </strong>${feature.properties.OBJECTID} </p>
        <p><strong> Name: </strong>${feature.properties.NAME}</p>
        <p><strong> Address: </strong>${feature.properties.ADDRESS}</p>
        <p><strong> Suburb:</strong> ${feature.properties.SUBURB}</p>`
    )
    .addTo(map);
}
