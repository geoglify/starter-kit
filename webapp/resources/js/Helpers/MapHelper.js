import maplibregl from "maplibre-gl";
import cargos from "@/../data/cargos.json";

import {
    isMapboxURL,
    transformMapboxUrl,
} from "maplibregl-mapbox-request-transformer";

const mapboxKey = "pk.eyJ1IjoibGVvbmVsZGlhcyIsImEiOiJjbGV5ZjhiNXMxaHYwM3dta2phanp3ajhxIn0.XQtv4xNQ9x4H99AIcpJW7g";

const transformRequest = (url, resourceType) => {
    if (isMapboxURL(url)) {
        return transformMapboxUrl(url, resourceType, mapboxKey);
    }

    // Do any other transforms you want
    return { url };
};

export default {
    createMap(container, center = [0, 0], zoom = 1) {
        return new maplibregl.Map({
            container: container,
            style: "https://api.mapbox.com/styles/v1/leoneldias/cm2agqkby003h01pgb4gr0ei7?access_token=pk.eyJ1IjoibGVvbmVsZGlhcyIsImEiOiJjbGV5ZjhiNXMxaHYwM3dta2phanp3ajhxIn0.XQtv4xNQ9x4H99AIcpJW7g",
            center: center,
            zoom: zoom,
            hash: "map",
            transformRequest,
        });
    },

    addNavigationControl(map) {
        map.addControl(new maplibregl.NavigationControl());
    },

    addSource(map, id, data = { type: "FeatureCollection", features: [] }) {
        map.addSource(id, {
            type: "geojson",
            data: data,
        });
    },

    addLayer(
        map,
        id,
        source,
        type = "circle",
        layoutOptions = {},
        paintOptions = {}
    ) {
        const layerConfig = {
            id: id,
            source: source,
            type: type,
        };

        layerConfig.layout = layoutOptions; // Use custom layout options for symbols
        layerConfig.paint = paintOptions; // Use custom paint options for other types (like 'circle')

        map.addLayer(layerConfig);
    },

    updateSource(map, id, features) {
        const source = map.getSource(id);
        if (source) {
            source.setData({
                type: "FeatureCollection",
                features: features,
            });
        }
    },

    async addShipIcon(map, id, imageUrl) {
        try {
            // Load the image asynchronously and add it to the map
            const icon = await this.loadImage(imageUrl);
            if (icon) {
                console.log("Image loaded successfully");
                map.addImage(id, icon, { sdf: true });
            }
        } catch (error) {
            console.error("Error loading image:", error);
        }
    },

    loadImage(imageUrl) {
        return new Promise((resolve, reject) => {
            console.log("Attempting to load image:", imageUrl);
            const img = new Image(); // Create an Image object
            img.src = imageUrl;
            img.onload = () => {
                console.log("Image loaded successfully:", img);
                resolve(img);
            };
            img.onerror = (error) => {
                console.error("Image loading error:", error);
                reject(error);
            };
        });
    },

    // Create a match expression for the cargo types
    getCargoColors() {
        const matchExpression = ["match", ["get", "cargo"]];

        cargos.types.forEach((cargo) => {
            if (cargo.is_active) {
                matchExpression.push(cargo.code, cargo.color);
            }
        });

        matchExpression.push("#FF0000");

        return matchExpression;
    },

    addShipLayer(map, id, source) {
        const layoutOptions = {
            "icon-rotate": ["get", "hdg"],
            "icon-rotation-alignment": "map",
            "icon-image": "ship",
            "icon-size": 0.5,
            "icon-allow-overlap": true,
        };

        const paintOptions = {
            "icon-color": this.getCargoColors(),
        };

        this.addLayer(map, id, source, "symbol", layoutOptions, paintOptions);
    },
};
