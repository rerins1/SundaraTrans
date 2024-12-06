<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Live Tracking GPS - Sundara Trans</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #map {
            width: 100%;
            height: 100vh;
            z-index: 1;
        }
        .map-container {
            position: relative;
            height: 100vh;
            width: 100%;
        }

        .header-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Pastikan di atas peta */
            background-color: white; /* Beri background putih */
        }

        .map-container {
            position: relative;
            height: calc(100vh - 100px); /* Kurangi tinggi untuk header */
            width: 100%;
            margin-top: 100px; /* Beri jarak dari header */
        }
    </style>
</head>
<body class="bg-gray-100">

    

    <div class="header-container">

        <x-navbar></x-navbar>
        
        <x-header>Live Tracking GPS - SDT001
            <p class="text-center text-lg mt-2">Rute bus atau posisi bus pada saat ini</p>
        </x-header>
    </div>

    <div class="map-container">
        <!-- Map Container -->
        <div id="map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Koordinat Terminal Cicaheum dan Terminal Senen
            const terminalCicaheum = [-6.902817, 107.656732];
            const terminalSenen = [-6.173617, 106.842073];

            // Inisialisasi peta - geser sedikit ke bawah dengan mengubah view center
            const map = L.map('map').setView([terminalCicaheum[0] - 0.5, terminalCicaheum[1]], 9);
                        
            // Tambahkan layer peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Ikon bus kustom
            const busIcon = L.divIcon({
                className: 'custom-bus-icon',
                html: `
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" viewBox="0 0 60 40">
                    <rect x="5" y="10" width="50" height="25" rx="5" ry="5" fill="#2C3E50" stroke="#000" stroke-width="2"/>
                    <rect x="10" y="12" width="10" height="10" rx="2" ry="2" fill="#3498DB"/>
                    <rect x="22" y="12" width="10" height="10" rx="2" ry="2" fill="#3498DB"/>
                    <rect x="34" y="12" width="10" height="10" rx="2" ry="2" fill="#3498DB"/>
                    <rect x="46" y="12" width="5" height="10" rx="2" ry="2" fill="#3498DB"/>
                    <circle cx="15" cy="35" r="5" fill="#34495E" stroke="#000" stroke-width="2"/>
                    <circle cx="45" cy="35" r="5" fill="#34495E" stroke="#000" stroke-width="2"/>
                    <circle cx="7" cy="20" r="3" fill="#F1C40F"/>
                </svg>
                `,
                iconSize: [30, 20],
                iconAnchor: [15, 20]
            });

           // Tambahkan marker untuk Terminal Cicaheum
            const cicaheumMarker = L.marker(terminalCicaheum, {icon: busIcon}).addTo(map)
                .bindPopup('<b>Terminal Bus Cicaheum</b><br>Bandung, Jawa Barat').openPopup();

            // Tambahkan marker untuk Terminal Senen - tanpa icon bus
            const senenMarker = L.marker(terminalSenen).addTo(map)
                .bindPopup('<b>Terminal Senen</b><br>Jakarta Pusat').openPopup();

            // Fungsi untuk mengambil rute menggunakan OSRM (Open Source Routing Machine)
            function fetchRoute(start, end) {
                const url = `https://router.project-osrm.org/route/v1/driving/${start[1]},${start[0]};${end[1]},${end[0]}?overview=full&geometries=geojson`;
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.routes && data.routes.length > 0) {
                            const routeCoordinates = data.routes[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
                            
                            // Tambahkan rute ke peta
                            const route = L.polyline(routeCoordinates, {
                                color: '#3498DB',  // Warna biru cerah
                                weight: 5,         // Ketebalan garis
                                opacity: 0.7       // Transparansi
                            }).addTo(map);

                            // Sesuaikan tampilan peta agar mencakup seluruh rute
                            map.fitBounds(route.getBounds());

                            // Tambahkan informasi jarak
                            const distance = (data.routes[0].distance / 1000).toFixed(1); // konversi ke kilometer
                            const duration = Math.round(data.routes[0].duration / 60); // konversi ke menit
                            route.bindPopup(`<b>Rute Perjalanan</b><br>Jarak: ${distance} km<br>Estimasi Waktu: ${duration} menit`).openPopup();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching route:', error);
                        alert('Gagal mengambil rute. Silakan coba lagi.');
                    });
            }

            // Panggil fungsi untuk menampilkan rute
            fetchRoute(terminalCicaheum, terminalSenen);

            // Resize map when window is resized
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
        });
    </script>

    
</body>
</html>