// Description: Helper functions to process the data and configurations.

export default {

    // Get the drawstyles
    getMapDrawStyles() {
        return [
            {
                id: "highlight-active-points",
                type: "circle",
                filter: ["all", ["==", "$type", "Point"], ["==", "meta", "feature"], ["==", "active", "true"]],
                paint: {
                    "circle-radius": 0,
                    "circle-stroke-color": "#FFF",
                    "circle-stroke-width": 2,
                    "circle-color": "#C62828",
                },
            },
            {
                id: "points-are-blue",
                type: "circle",
                filter: ["all", ["==", "$type", "Point"], ["==", "meta", "feature"], ["==", "active", "false"]],
                paint: {
                    "circle-radius": 0,
                    "circle-color": "#C62828",
                },
            },
            {
                id: "gl-draw-line",
                type: "line",
                filter: ["all", ["==", "$type", "LineString"], ["!=", "mode", "static"]],
                layout: {
                    "line-cap": "round",
                    "line-join": "round",
                },
                paint: {
                    "line-color": "#C62828",
                    "line-width": 4,
                },
            },
            // polygon fill
            {
                id: "gl-draw-polygon-fill",
                type: "fill",
                filter: ["all", ["==", "$type", "Polygon"], ["!=", "mode", "static"]],
                paint: {
                    "fill-color": "#C62828",
                    "fill-outline-color": "#C62828",
                    "fill-opacity": 0.1,
                },
            },
            // polygon mid points
            {
                id: "gl-draw-polygon-midpoint",
                type: "circle",
                filter: ["all", ["==", "$type", "Point"], ["==", "meta", "midpoint"]],
                paint: {
                    "circle-radius": 0,
                    "circle-stroke-color": "#FFF",
                    "circle-stroke-width": 0,
                    "circle-color": "#C62828",
                },
            },
            // polygon outline stroke
            // This doesn't style the first edge of the polygon, which uses the line stroke styling instead
            {
                id: "gl-draw-polygon-stroke-active",
                type: "line",
                filter: ["all", ["==", "$type", "Polygon"], ["!=", "mode", "static"]],
                layout: {
                    "line-cap": "round",
                    "line-join": "round",
                },
                paint: {
                    "line-color": "#C62828",
                    "line-width": 5,
                },
            },
            // vertex point halos
            {
                id: "gl-draw-polygon-and-line-vertex-halo-active",
                type: "circle",
                filter: ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
                paint: {
                    "circle-radius": 0,
                    "circle-stroke-color": "#FFF",
                    "circle-stroke-width": 2,
                    "circle-color": "#C62828",
                },
            },
            // vertex points
            {
                id: "gl-draw-polygon-and-line-vertex-active",
                type: "circle",
                filter: ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
                paint: {
                    "circle-radius": 0,
                    "circle-stroke-color": "#FFF",
                    "circle-stroke-width": 2,
                    "circle-color": "#C62828",
                },
            },

            // INACTIVE (static, already drawn)
            // line stroke
            {
                id: "gl-draw-line-static",
                type: "line",
                filter: ["all", ["==", "$type", "LineString"], ["==", "mode", "static"]],
                layout: {
                    "line-cap": "round",
                    "line-join": "round",
                },
                paint: {
                    "line-color": "#000",
                    "line-width": 5,
                },
            },
            // polygon fill
            {
                id: "gl-draw-polygon-fill-static",
                type: "fill",
                filter: ["all", ["==", "$type", "Polygon"], ["==", "mode", "static"]],
                paint: {
                    "fill-color": "#000",
                    "fill-outline-color": "#000",
                    "fill-opacity": 0.1,
                },
            },
            // polygon outline
            {
                id: "gl-draw-polygon-stroke-static",
                type: "line",
                filter: ["all", ["==", "$type", "Polygon"], ["==", "mode", "static"]],
                layout: {
                    "line-cap": "round",
                    "line-join": "round",
                },
                paint: {
                    "line-color": "#000",
                    "line-width": 5,
                },
            },
        ];
    },

};