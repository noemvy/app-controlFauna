@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const x = position.coords.latitude;
                const y = position.coords.longitude;

                console.log('Latitud:', x);
                console.log('Longitud:', y);

                document.getElementById('coordenada_x').value = x.toFixed(6);
                document.getElementById('coordenada_y').value = y.toFixed(6);

                document.getElementById('coordenada_x').dispatchEvent(new Event('input'));
                document.getElementById('coordenada_y').dispatchEvent(new Event('input'));
            }, (error) => {
                console.error("Error obteniendo ubicación:", error);
            });
        } else {
            alert("La geolocalización no está disponible en tu navegador.");
        }
    });
</script>
@endpush
