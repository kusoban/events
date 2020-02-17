<template>
<div class="map-wrapper">
    <div id="mapid"></div>
</div>
</template>

<script>
import "leaflet/dist/leaflet";
import "leaflet/dist/leaflet.css";
export default {
    name: "PlacesMap",
    props: {
        places: Array,
    },
    data() {
        return {
            map: null,
            markerIcon: L.icon({
                iconUrl: "http://events.api/images/leaf-green.png",
                shadowUrl: "http://events.api/images/leaf-shadow.png",

                iconSize: [38, 95], // size of the icon
                shadowSize: [50, 64], // size of the shadow
                iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                shadowAnchor: [4, 62], // the same for the shadow
                popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
            }),
        }
    },
    mounted() {
        this.initMap();
        this.renderMarkers();
    },
    methods: {
        initMap() {
            this.map = L.map("mapid").setView([46.966823,31.991351], 15);
            var token =
                "pk.eyJ1IjoiYnVnZmVsbGEiLCJhIjoiY2s1d2Z1dTBoMHpuODNrbzB1M2ZxN2NzdSJ9.o3Eyx8Hi0orU4nA385y28A";
            L.tileLayer(
                "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
                {
                    attribution:
                        'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 20,
                    id: "mapbox/streets-v11",
                    accessToken: token
                }
            ).addTo(this.map);
        },
        renderMarkers() {
             this.places.forEach(place => {
                if(!place.location) return;
                
                const latlng = new L.LatLng(place.location.lat, place.location.lng);
                const marker = L.marker(latlng, {
                    title: place.name,
                    icon: this.markerIcon,
                })
                marker.addTo(this.map)
                    .bindPopup(`<a href="/#/places/${place.id}"><strong>${place.name}</strong></a>
                `)
            })
        }
    },
    watch: {
        places: {
            handler (places) {
               this.renderMarkers();
            }
        },
    }
};
</script>

<style>
#mapid {
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: 4;
}
.map-wrapper {
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    
}
</style>