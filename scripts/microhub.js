
mapboxgl.accessToken =
    'pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg';
const map = new mapboxgl.Map({
    container: 'map', // container ID
    // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
    style: 'mapbox://styles/berryagt/cln2s1byp005601pmam10278g', // style URL
    center: [144.971, -37.509], // starting position
    zoom: 7 // starting zoom
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());

map.on("load", () => {
    var microhubFreatures = map.queryRenderedFeatures({
        layers: ['fuel']
    });
    document.querySelector("#microhub-no").innerHTML = microhubFreatures.length;
})

//Labels for MicroHubs
map.on('click', (event) => {
    const features = map.queryRenderedFeatures(event.point, {
        layers: ['fuel']
    });
    if (map.getLayer("fuel")) {
        if (!features.length) {
            return;
        }
        const feature = features[0];

        const popup = new mapboxgl.Popup({
            offset: [0, -5]
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
});