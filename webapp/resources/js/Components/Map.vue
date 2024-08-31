<script>
import maplibregl from 'maplibre-gl';
import 'maplibre-gl/dist/maplibre-gl.css';

export default {
    mounted() {

        // Create a new map instance
        const map = new maplibregl.Map({
            container: 'map',
            style: 'https://demotiles.maplibre.org/style.json',
            center: [0, 0],
            zoom: 1,
            hash: "map", // Enable hash
        });

        // Add navigation control
        map.addControl(new maplibregl.NavigationControl());
    }
}
</script>

<template>
    <div class="w-full h-full" id="map"></div>
</template>