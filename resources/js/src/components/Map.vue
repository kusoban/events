<template>
<div class="map-wrapper">
    <div id="mapid"></div>
    <v-btn @click="sendLocation">Save</v-btn>
</div>
</template>

<script>
import "leaflet/dist/leaflet";
import "leaflet/dist/leaflet.css";
export default {
    name: "Map",
    props: ['propsMarker', 'allowCreateMarker'],
    data() {
        return {
            mymap: null,
            latlng: {
                lat: '',
                lng: ''
            },
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
        this.mymap = L.map("mapid").setView(this.propsMarker ? [this.propsMarker.lat, this.propsMarker.lng] : [46.966823,31.991351], 13);
        var token =
            "pk.eyJ1IjoiYnVnZmVsbGEiLCJhIjoiY2s1d2Z1dTBoMHpuODNrbzB1M2ZxN2NzdSJ9.o3Eyx8Hi0orU4nA385y28A";
        L.tileLayer(
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
            {
                attribution:
                    'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: "mapbox/streets-v11",
                accessToken: token
            }
        ).addTo(this.mymap);

        var marker;
        const onMapClick = (e) => {
            this.latlng = e.latlng;
            this.$emit('markerLocationChange', this.latlng);

            if (marker) {
                this.mymap.removeLayer(marker);
            }
            console.log(';;');
            marker = L.marker(e.latlng, {
                draggable: true,
                title: "Resource location",
                alt: "Resource Location",
                riseOnHover: true,
                icon: this.markerIcon
            })
                .addTo(this.mymap)
                .bindPopup(e.latlng.toString())
                .openPopup();

            // Update marker on changing it's position
            marker.on("dragend", function(ev) {
                var chagedPos = ev.target.getLatLng();
                this.bindPopup(chagedPos.toString()).openPopup();
            });
        }
        if(this.allowCreateMarker) {
            this.mymap.on("click", onMapClick);
        }
    },
    methods: {
        sendLocation() {

        }
    },
    watch: {
        propsMarker: {
            immediate: true,
            handler(v) {
                if(v) {
                    const marker = L.marker(v, {
                        draggable: true,
                        title: "Resource location",
                        alt: "Resource Location",
                        riseOnHover: true,
                        icon: this.markerIcon
                    }).addTo(this.mymap)
                        .bindPopup(`${v.lat}  ${v.lng}`)
                        .openPopup();

                } else {
                    console.log('no')
                }
            }
        }
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
    z-index: 6;
}
.map-wrapper {
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    
}
</style>