<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphHopper Route Example with OpenStreetMap</title>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0-alpha.1"></script>
    
    <!-- Leaflet CSS untuk OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <!-- GraphHopper API Client -->
    <script src="https://cdn.jsdelivr.net/npm/graphhopper-js-api-client@1.0.0"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-4xl text-center text-gray-800 mb-8">GraphHopper Route with OpenStreetMap</h1>
        
        <!-- Form Input untuk Lokasi Awal dan Tujuan -->
        <div class="mb-6">
        <label class="block text-lg text-gray-600" for="from">Starting Location:</label>
        <input type="text" id="from" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Enter starting location">
        </div>
        <div class="mb-6">
        <label class="block text-lg text-gray-600" for="to">Destination Location:</label>
        <input type="text" id="to" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Enter destination location">
        </div>
        
        <div class="text-center">
        <button id="getRouteBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Get Route</button>
        </div>
        
        <!-- Peta OpenStreetMap -->
        <div id="map" class="h-96 mt-6"></div>
    </div>

    <script>
        let map;
        let routeLayer;

        // Inisialisasi peta OpenStreetMap menggunakan Leaflet
        function initMap() {
        map = L.map('map').setView([51.505, -0.09], 13); // Set default location (London, UK)
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        routeLayer = L.layerGroup().addTo(map);
        }

        // Ambil data rute dan tampilkan pada peta
        document.getElementById('getRouteBtn').addEventListener('click', async function () {
        const from = document.getElementById('from').value;
        const to = document.getElementById('to').value;

        if (from && to) {
            const apiKey = '03330647-fa2c-41e7-b462-7fcb2e4e2a95';  // Masukkan API key GraphHopper Anda
            const url = `https://graphhopper.com/api/1/route?point=${from}&point=${to}&vehicle=car&key=${apiKey}`;
            
            // Permintaan API GraphHopper
            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.paths && data.paths.length > 0) {
                const route = data.paths[0].points;
                
                // Bersihkan layer peta sebelumnya
                routeLayer.clearLayers();

                // Konversi rute GraphHopper ke format Leaflet dan tambahkan ke peta
                const latLngs = route.map(point => [point[1], point[0]]);
                const polyline = L.polyline(latLngs, { color: 'blue' }).addTo(routeLayer);

                // Menyesuaikan zoom dan center peta ke rute
                map.fitBounds(polyline.getBounds());
                }
            })
            .catch(error => console.error('Error fetching GraphHopper API:', error));
        }
        });

        // Inisialisasi peta saat halaman dimuat
        window.onload = initMap;
    </script>
</body>
</html>
