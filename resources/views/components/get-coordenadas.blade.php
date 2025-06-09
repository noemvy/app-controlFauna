<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);

                console.log('Latitud:', lat);
                console.log('Longitud:', lng);

                const latInput = document.getElementById('coordenada_y');
                const lngInput = document.getElementById('coordenada_x');

                if (latInput) {
                    latInput.value = lat;
                    latInput.dispatchEvent(new Event('input'));
                }

                if (lngInput) {
                    lngInput.value = lng;
                    lngInput.dispatchEvent(new Event('input')); 
                }

            }, function (error) {
                console.error('Error obteniendo coordenadas:', error.message);
            });
        } else {
            console.error("Geolocalización no es soportada por este navegador.");
        }
    });
</script>
