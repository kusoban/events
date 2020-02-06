<template>
<div class="map-wrapper">
    <div id="mapid"></div>
</div>
</template>

<script>
import "leaflet/dist/leaflet";
import "leaflet/dist/leaflet.css";
export default {
    name: "Map",
    props: ['propsMarker', 'allowCreateMarker', 'draggable'],
    data() {
        return {
            map: null,
            marker: null,
            clickLatLng: {
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
        this.map = L.map("mapid").
            setView(this.propsMarker.location ? 
              [this.propsMarker.locaton.lat, this.propsMarker.location.lng]
            : [46.966823,31.991351]
            ,16);

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

       

      
        // Click works only in events/place Create/Edit components
        const onMapClick = (e) => {
            this.$emit('markerLocationChange', e.latlng);

            if (this.marker) {
                this.map.removeLayer(this.marker);
            }

            this.marker = L.marker(e.latlng, {
                draggable: true,
                title: "Resource location",
                alt: "Resource Location",
                riseOnHover: true,
                icon: this.markerIcon
            })
            .addTo(this.map)
            .bindPopup(e.latlng.toString())
            .openPopup();

            // Update marker on changing it's position
            this.marker.on("dragend", function(ev) {

                var chagedPos = ev.target.getLatLng();
                this.bindPopup(chagedPos.toString()).openPopup();
            });
        }
        if(this.allowCreateMarker) {
            this.map.on("click", onMapClick);
        }
         

        
    },
    methods: {
    },
    watch: {
        propsMarker: {
            // immediate: true,
            handler(propsMarker) {
                if(propsMarker.location) {
                    this.marker = 'kek';
                    // return console.log(this.marker)
                    this.marker = L.marker(propsMarker.location, {
                        title: "Resource location",
                        alt: "Resource Location",
                        riseOnHover: true,
                        icon: this.markerIcon,
                        draggable: propsMarker.draggable || false,
                    }).addTo(this.map)
                        .bindPopup(`${propsMarker.location.lat}  ${propsMarker.location.lng}`)
                        .openPopup();
                        
                    const latlngs = [this.marker.getLatLng()]
                    const markerBounds = L.latLngBounds(latlngs);
                    this.map.setView([propsMarker.location.lat, propsMarker.location.lng]);
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