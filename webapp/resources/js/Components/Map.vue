<script>
import MapHelper from "@/Helpers/MapHelper";
import ShipHelper from "@/Helpers/ShipHelper";
import "maplibre-gl/dist/maplibre-gl.css";

export default {
    data: () => ({
        map: null,
        ships: [],
    }),

    mounted() {
        this.map = MapHelper.createMap("map"); // Create the map
        MapHelper.addNavigationControl(this.map); // Add navigation control

        this.map.on("load", async () => {

            // Add wmts source (https://api.mapbox.com/styles/v1/leoneldias/cm2agqkby003h01pgb4gr0ei7/wmts?access_token=pk.eyJ1IjoibGVvbmVsZGlhcyIsImEiOiJjbGV5ZjhiNXMxaHYwM3dta2phanp3ajhxIn0.XQtv4xNQ9x4H99AIcpJW7g

            


            // Add ship icon (load custom icon before adding layer)
            await MapHelper.addShipIcon(this.map, "ship", "/images/boat.png");
            await MapHelper.addShipIcon(this.map, "circle", "/images/circle.png");

            // Create the source for ships
            MapHelper.addSource(this.map, "ships");

            // Add the ships layer using the same source ID
            MapHelper.addShipLayer(this.map, "ships", "ships");

            // First get ships from the server
            fetch("ship-realtime-positions/list", {
                method: "post",
                body: JSON.stringify({}),
            })
                .then((response) => {
                    // Parse the response
                    return response.json();
                })
                .then((data) => {
                    // Store ships data
                    this.ships = data;
                })
                .catch(() => {
                    // Failed to fetch data from the server
                    this.ships = [];
                })
                .finally(() => {

                    // Create ship features using this.ships
                    const features = ShipHelper.createShipFeatures(this.ships);
                    MapHelper.updateSource(this.map, "ships", features);

                    // Init listener for realtime ship updates
                    /*window.Echo.channel("realtime_ships").listen(
                        "BroadcastShipPositionUpdate",
                        (ship) => {
                            const source = this.map.getSource("ships");
                            if (!source) return;

                            const features = source._data.features;
                            ShipHelper.updateShipPosition(features, ship);

                            this.ships.push(ship);
                            MapHelper.updateSource(this.map, "ships", features);
                        }
                    );**/
                });
        });
    },
};
</script>

<template>
    <div id="map"></div>
</template>

<style>
#map {
    height: 100%;
    width: 100%;
}

html,
body {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.map-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 10px;
    height: 300px;
    z-index: 1;
}
</style>
