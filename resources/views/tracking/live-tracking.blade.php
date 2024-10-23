<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Live Tracking GPS - Sundara Trans</title>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap"></script>
    <style>
        #map {
            width: 100%;
            height: 500px;
        }
    </style>
    <script>
        function initMap() {
            const center = { lat: -6.917464, lng: 107.619123 }; // Koordinat awal
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: center,
            });
            new google.maps.Marker({
                position: center,
                map: map,
            });
        }
    </script>
</head>
<body class="bg-gray-100">

    <x-navbar></x-navbar>

    <x-header>Live Tracking GPS -
        <p class="text-center text-lg mt-2">Rute bus atau posisi bus pada saat ini</p>
    </x-header>

    <div class="min-h-screen mb-20">
        <!-- Map Container -->
        <div id="map"></div>
    </div>

    <x-footer></x-footer>

</body>
</html>
