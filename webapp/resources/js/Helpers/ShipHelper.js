export default {
    updateShipPosition(features, ship) {
        // Find the ship in the features
        const feature = features.find((f) => f.properties.mmsi === ship.mmsi);

        if (!feature) {
            // Add the ship if not found
            features.push({
                type: "Feature",
                geometry: JSON.parse(ship.geojson),
                properties: {
                    mmsi: ship.mmsi,
                    cargo: ship.cargo,
                    hdg: ship.hdg, // Update bearing for rotation
                },
            });
        } else {
            // Update the existing ship position and bearing
            feature.geometry = JSON.parse(ship.geojson);
            feature.properties.hdg = ship.hdg ?? 0;
            feature.properties.cargo = ship.cargo;
        }
    },

    createShipFeatures(ships) {
        return ships.map((ship) => {
            return {
                type: "Feature",
                geometry: JSON.parse(ship.geojson),
                properties: {
                    mmsi: ship.mmsi,
                    cargo: ship.cargo,
                    hdg: ship.hdg ?? 0, // Include other properties like bearing if needed
                },
            };
        });
    },
};
