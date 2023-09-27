let nearestOrgHub, nearestDestHub;

let vktTruck = 0, vktBike = 0;
let truckTime = 0, bikeTime = 0;
const originCoordinates = [
    [144.96200, -37.80500],
    [144.96501, -37.81000],
    [144.98501, -37.80300],
    [145.01200, -37.82401],
    [144.97801, -37.82701],
    [144.96099, -37.81801],
    [144.94600, -37.80900],
    [144.95600, -37.82601],
    [144.96900, -37.83201]
];

const destCoordinates = [
    [145.04301, -37.81901],
    [145.07101, -37.81000],
    [145.06300, -37.81901],
    [145.04601, -37.86200],
    [145.07300, -37.86899],
    [145.07101, -37.89401],
    [145.01400, -37.86599],
    [145.11101, -37.79700],
    [145.05399, -37.83700]
];

mapboxgl.accessToken =
    'pk.eyJ1IjoiYmVycnlhZ3QiLCJhIjoiY2xseXRjNDBjMmVjZTNkbGlhcmQ4Y2w3ZSJ9.nQoSvkaX9K01PcQD73JxDg';
const map = new mapboxgl.Map({
    container: 'map', // container ID
    // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
    style: 'mapbox://styles/berryagt/cln0hsv9u027w01rfei7wdo5j', // style URL
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


// Create an empty GeoJSON feature collection, which will be used as the data source for the route before users add any new data
const nothing = turf.featureCollection([]);

map.on('load', async (event) => {

    map.addSource('org-route', {
        type: 'geojson',
        data: nothing
    });

    map.addSource('hub-to-hub-route', {
        type: 'geojson',
        data: nothing
    });

    map.addSource('dest-truck-route', {
        type: 'geojson',
        data: nothing
    });

    map.addSource('dest-bike-route', {
        type: 'geojson',
        data: nothing
    });

    map.loadImage(
        './assets/images/location_icon_2.png',
        (error, image) => {
            if (error) throw error;

            // Add the image to the map style.
            map.addImage('origin_icon_marker', image);
        });

    map.loadImage(
        './assets/images/location_icon.png',
        (error, image) => {
            if (error) throw error;

            // Add the image to the map style.
            map.addImage('dest_icon_marker', image);
        });

    // Layer to display all origins on the map
    map.addLayer({
        id: 'origins',
        type: 'symbol',
        source: {
            type: 'geojson',
            data: {
                "type": "FeatureCollection",
                "features": [{
                    "type": "Feature",
                    "properties": {},
                    "geometry": {
                        "type": "MultiPoint",
                        "coordinates": originCoordinates
                    }
                }]
            }
        },
        layout: {
            'icon-image': 'origin_icon_marker',
            'icon-size': 1
        }
    });

    map.addLayer({
        id: 'destinations',
        type: 'symbol',
        source: {
            type: 'geojson',
            data: {
                "type": "FeatureCollection",
                "features": [{
                    "type": "Feature",
                    "properties": {},
                    "geometry": {
                        "type": "MultiPoint",
                        "coordinates": destCoordinates
                    }
                }]
            }
        },
        layout: {
            'icon-image': 'dest_icon_marker',
            'icon-size': 1
        }
    });

    map.loadImage(
        './assets/images/warehouse_icon.png',
        (error, image) => {
            if (error) throw error;

            // Add the image to the map style.
            map.addImage('warehouse', image);
        });

    map.addLayer({
        id: 'originsPolygon',
        type: 'fill',
        source: {
            type: 'geojson',
            data: {
                'type': 'Feature',
                'geometry': {
                    'type': 'Polygon',
                    'coordinates': [originCoordinates]
                }
            }
        },
        layout: {},
        paint: {
            'fill-color': '#f00',
            'fill-opacity': 0
        }
    });

    map.addLayer({
        id: 'destPolygon',
        type: 'fill',
        source: {
            type: 'geojson',
            data: {
                'type': 'Feature',
                'geometry': {
                    'type': 'Polygon',
                    'coordinates': [destCoordinates]
                }
            }
        },
        layout: {},
        paint: {
            'fill-color': '#fff',
            'fill-opacity': 0
        }
    });

    const fuelFeatures = map.queryRenderedFeatures(event.point, {
        layers: ['fuel']
    });
    if (!fuelFeatures.length) {
        return;
    }

    const fuelFeatureCollection = turf.featureCollection(fuelFeatures);

    // Finding the nearest hub to the centroid of all origins/destinations
    nearestOrgHub = getNearestHubFromCoordinates(originCoordinates, fuelFeatureCollection);
    nearestDestHub = getNearestHubFromCoordinates(destCoordinates, fuelFeatureCollection);


    // Create a circle layer
    map.addLayer({
        id: 'warehouse',
        type: 'circle',
        source: {
            data: nearestOrgHub,
            type: 'geojson'
        },
        paint: {
            'circle-radius': 20,
            'circle-color': '#8aecff',
            'circle-stroke-color': '#000',
            'circle-stroke-width': 2
        }
    });

    map.addLayer({
        id: 'org-warehouse-symbol',
        type: 'symbol',
        source: {
            data: nearestOrgHub,
            type: 'geojson'
        },
        layout: {
            'icon-image': 'warehouse',
            'icon-size': 1.5
        }
    });

    // Create a circle layer
    map.addLayer({
        id: 'warehouse2',
        type: 'circle',
        source: {
            data: nearestDestHub,
            type: 'geojson'
        },
        paint: {
            'circle-radius': 20,
            'circle-color': '#8aecff',
            'circle-stroke-color': '#000',
            'circle-stroke-width': 2
        }
    });

    map.addLayer({
        id: 'dest-warehouse-symbol',
        type: 'symbol',
        source: {
            data: nearestDestHub,
            type: 'geojson'
        },
        layout: {
            'icon-image': 'warehouse',
            'icon-size': 1.5
        }
    });

    // Make a request to the Optimization API
    const query = await fetch(assembleQueryURLAroundHub(nearestOrgHub, originCoordinates, 'driving'), {
        method: 'GET'
    });
    const response = await query.json();

    // console.log(response.trips);

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

    // Make a request to the Direction API
    const query2 = await fetch(assembleQueryURLHubToHub(), {
        method: 'GET'
    });
    const response2 = await query2.json();
    // console.log(response2.routes[0]);

    // Assign truck or bike to finish delivery
    let truckDestCoordinates = [], bikeDestCoordinates = [];

    destCoordinates.forEach((point) => {
        var distance = turf.distance(nearestDestHub, point);
        // Assign a bike if distance within 2 km or truck if > 2km
        (distance <= 2) ? bikeDestCoordinates.push(point) : truckDestCoordinates.push(point);
    })

    // Make a request to the Optimization API
    const query3 = await fetch(assembleQueryURLAroundHub(nearestDestHub, truckDestCoordinates, 'driving'), {
        method: 'GET'
    });
    const response3 = await query3.json();

    // Query for bike
    const query4 = await fetch(assembleQueryURLAroundHub(nearestDestHub, bikeDestCoordinates, 'cycling'), {
        method: 'GET'
    });
    const response4 = await query4.json();

    // Create a GeoJSON feature collection
    const routeGeoJSON = turf.featureCollection([
        turf.feature(response.trips[0].geometry)
    ]);
    const routeGeoJSON2 = turf.featureCollection([
        turf.feature(response2.routes[0].geometry)
    ]);
    const routeGeoJSON3 = turf.featureCollection([
        turf.feature(response3.trips[0].geometry)
    ]);
    const routeGeoJSON4 = turf.featureCollection([
        turf.feature(response4.trips[0].geometry)
    ]);

    vktTruck += response.trips[0].distance;
    vktTruck += response2.routes[0].distance;
    vktTruck += response3.trips[0].distance;
    vktBike += response4.trips[0].distance;

    truckTime += response.trips[0].duration;
    truckTime += response2.routes[0].duration;
    truckTime += response3.trips[0].duration;
    bikeTime += response4.trips[0].duration;

    // Update the `route` source by getting the route source
    // and setting the data equal to routeGeoJSON
    map.getSource('org-route').setData(routeGeoJSON);

    map.addLayer({
        id: 'routeline-active',
        type: 'line',
        source: 'org-route',
        layout: {
            'line-join': 'round',
            'line-cap': 'round'
        },
        paint: {
            'line-color': '#007bff',
            'line-width': ['interpolate', ['linear'],
                ['zoom'], 15, 5, 22, 15
            ]
        }
    },
        'waterway-label'
    );

    map.addLayer({
        id: 'routearrows',
        type: 'symbol',
        source: 'org-route',
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
            'text-color': '#E08E00',
            'text-halo-color': 'hsl(55, 11%, 96%)',
            'text-halo-width': 3
        }
    },
        'waterway-label'
    );

    map.getSource('hub-to-hub-route').setData(routeGeoJSON2);

    map.addLayer({
        id: 'routeline2-active',
        type: 'line',
        source: 'hub-to-hub-route',
        layout: {
            'line-join': 'round',
            'line-cap': 'round'
        },
        paint: {
            'line-color': '#B86812',
            'line-width': ['interpolate', ['linear'],
                ['zoom'], 15, 5, 22, 15
            ]
        }
    },
        'waterway-label'
    );

    map.addLayer({
        id: 'routearrows2',
        type: 'symbol',
        source: 'hub-to-hub-route',
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
            'text-color': '#E08E00',
            'text-halo-color': 'hsl(55, 11%, 96%)',
            'text-halo-width': 3
        }
    },
        'waterway-label'
    );

    // Update the `route` source by getting the route source
    // and setting the data equal to routeGeoJSON
    map.getSource('dest-truck-route').setData(routeGeoJSON3);

    map.addLayer({
        id: 'routeline3-active',
        type: 'line',
        source: 'dest-truck-route',
        layout: {
            'line-join': 'round',
            'line-cap': 'round'
        },
        paint: {
            'line-color': '#bb3dcc',
            'line-width': ['interpolate', ['linear'],
                ['zoom'], 15, 5, 22, 15
            ]
        }
    },
        'waterway-label'
    );

    map.addLayer({
        id: 'routearrows3',
        type: 'symbol',
        source: 'dest-truck-route',
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
            'text-color': '#E08E00',
            'text-halo-color': 'hsl(55, 11%, 96%)',
            'text-halo-width': 3
        }
    },
        'waterway-label'
    );

    // Update the `route` source by getting the route source
    // and setting the data equal to routeGeoJSON
    map.getSource('dest-bike-route').setData(routeGeoJSON4);

    map.addLayer({
        id: 'routeline4-active',
        type: 'line',
        source: 'dest-bike-route',
        layout: {
            'line-join': 'round',
            'line-cap': 'round'
        },
        paint: {
            'line-color': '#1fd655',
            'line-width': ['interpolate', ['linear'],
                ['zoom'], 15, 5, 22, 15
            ]
        }
    },
        'waterway-label'
    );

    map.addLayer({
        id: 'routearrows4',
        type: 'symbol',
        source: 'dest-bike-route',
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
            'text-color': '#E08E00',
            'text-halo-color': 'hsl(55, 11%, 96%)',
            'text-halo-width': 3
        }
    },
        'waterway-label'
    );

    updateData();
});

// Toggle display
const layerList = document.getElementById('menu');
const inputs = layerList.getElementsByTagName('input');

for (const input of inputs) {
    input.onclick = (layer) => {
        const layerId = layer.target.id;
        map.setStyle('mapbox://styles/berryagt/' + layerId);
    };
}

function getNearestHubFromCoordinates(coordinates, hubFeatureCollection) {
    var polygon = turf.polygon([coordinates.concat([coordinates[0]])]); // 1st and last coordinate has to be the same
    var centroid = turf.centroid(polygon);
    // Create a GeoJSON feature collection for the warehouse
    var point = turf.point(centroid.geometry.coordinates);
    return turf.nearest(point, hubFeatureCollection);
}

// Here you'll specify all the parameters necessary for requesting a response from the Optimization API
function assembleQueryURLAroundHub(hub, coordinatesArray, travelMethod) {
    // Set the profile to `driving`
    // Coordinates will include the current location of the truck,
    const coordinates = [hub.geometry.coordinates].concat(coordinatesArray);
    // console.log(coordinates);
    return `https://api.mapbox.com/optimized-trips/v1/mapbox/${travelMethod}/${coordinates.join(
        ';'
    )}?overview=full&steps=true&geometries=geojson&source=first&access_token=${mapboxgl.accessToken
        }`;
}

function assembleQueryURLHubToHub() {
    // Set the profile to `driving`
    // Coordinates will include the current location of the truck,
    const coordinates = [nearestOrgHub.geometry.coordinates].concat([nearestDestHub.geometry.coordinates]);
    // console.log(coordinates);
    return `https://api.mapbox.com/directions/v5/mapbox/driving/${coordinates.join(
        ';'
    )}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken
        }`;
}

function updateData() {
    // Display VKT data
    document.querySelector("#total-vkt").innerHTML = ((vktTruck + vktBike) / 1000).toFixed(2) + " km";
    document.querySelector("#truck-vkt").innerHTML = "Truck: " + (vktTruck / 1000).toFixed(2) + " km";
    document.querySelector("#bike-vkt").innerHTML = "Bike: " + (vktBike / 1000).toFixed(2) + " km";

    document.querySelector("#total-travel-time").innerHTML = ((truckTime + bikeTime) / 3600).toFixed(2) + " hours";
    document.querySelector("#truck-time").innerHTML = "Truck: " + (truckTime / 3600).toFixed(2) + " hours";
    document.querySelector("#bike-time").innerHTML = "Bike: " + (bikeTime / 3600).toFixed(2) + " hours";

    //  Truck travelling for 1KM carrying 1 ton emits 105g of CO2 
    document.querySelector("#co2-emissions").innerHTML = (vktTruck / 1000 * 105).toFixed(2) + " g";

}