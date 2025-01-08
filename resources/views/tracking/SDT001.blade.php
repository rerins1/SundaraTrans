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
            height: calc(100vh - 100px);
            width: 100%;
            margin-top: 100px;
        }
        .header-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: white;
        }
        .info-box {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            min-width: 300px;
            max-width: 350px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            font-weight: bold;
            color: #2C3E50;
            border-bottom: 2px solid #3498DB;
            padding-bottom: 5px;
        }
        .info-item {
            margin: 8px 0;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .info-item strong {
            color: #34495E;
        }
        .info-value {
            background: #f8f9fa;
            padding: 2px 8px;
            border-radius: 4px;
            min-width: 100px;
            text-align: right;
        }
        .notification {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            display: none;
            font-size: 13px;
            border-left: 4px solid #dc3545;
        }
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .status-normal {
            background-color: #28a745;
        }
        .status-warning {
            background-color: #ffc107;
        }
        .status-danger {
            background-color: #dc3545;
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
        <div id="map"></div>
        <div class="info-box">
            <h3>Informasi Bus</h3>
            <div class="info-item">
                <strong>Kode Bus:</strong>
                <span class="info-value" id="busCode">SDT001</span>
            </div>
            <div class="info-item">
                <strong>Status:</strong>
                <span class="info-value">
                    <span class="status-indicator status-normal" id="statusIndicator"></span>
                    <span id="busStatus">Berjalan Normal</span>
                </span>
            </div>
            <div class="info-item">
                <strong>Kecepatan:</strong>
                <span class="info-value" id="speed">0 km/h</span>
            </div>
            <div class="info-item">
                <strong>Jurusan:</strong>
                <span class="info-value" id="route">Cicaheum - Giwangan</span>
            </div>
            <div class="info-item">
                <strong>Jarak Tersisa:</strong>
                <span class="info-value" id="remainingDistance">Menghitung...</span>
            </div>
            <div class="info-item">
                <strong>ETA:</strong>
                <span class="info-value" id="eta">Menghitung...</span>
            </div>
            <div class="notification" id="notification"></div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const terminalCicaheum = [-6.902817, 107.656732];
            const terminalGiwangan = [-7.834096, 110.392221];
            
            const map = L.map('map').setView([terminalCicaheum[0] - 0.5, terminalCicaheum[1]], 8);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

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

            const giwanganMarker = L.marker(terminalGiwangan)
                .addTo(map)
                .bindPopup('<b>Terminal Giwangan</b><br>Yogyakarta');

            let movingBus = L.marker(terminalCicaheum, {icon: busIcon}).addTo(map);
            let routeLine;
            let routeCoordinates = [];
            let currentSegment = 0;
            let lastPosition = null;
            let lastUpdateTime = Date.now();

            // Traffic conditions simulation
            const trafficConditions = [
                { location: [-7.3, 109], condition: 'heavy', message: 'Kemacetan padat di daerah Purwokerto' },
                { location: [-7.5, 109.5], condition: 'medium', message: 'Lalu lintas sedang di daerah Kebumen' },
                { location: [-7.7, 110], condition: 'accident', message: 'Terjadi kecelakaan di jalur utama' }
            ];

            function updateStatus(status, message) {
                const statusIndicator = document.getElementById('statusIndicator');
                const busStatus = document.getElementById('busStatus');
                
                statusIndicator.className = 'status-indicator';
                switch(status) {
                    case 'normal':
                        statusIndicator.classList.add('status-normal');
                        busStatus.textContent = 'Berjalan Normal';
                        break;
                    case 'warning':
                        statusIndicator.classList.add('status-warning');
                        busStatus.textContent = 'Terhambat';
                        break;
                    case 'danger':
                        statusIndicator.classList.add('status-danger');
                        busStatus.textContent = 'Terhenti';
                        break;
                }

                if (message) {
                    showNotification(message);
                }
            }

            function calculateSpeed(startPos, endPos, timeElapsed) {
                if (!startPos || !endPos || !timeElapsed) return 60; // Default 60 km/h
                
                const distance = map.distance(startPos, endPos); // meters
                const timeHours = timeElapsed / 3600000; // convert ms to hours
                
                // Batasi kecepatan antara 40-80 km/h untuk mensimulasikan kondisi jalan raya
                let speed = Math.round((distance / 1000) / timeHours);
                speed = Math.max(40, Math.min(80, speed));
                
                return speed;
            }

            function showNotification(message) {
                const notification = document.getElementById('notification');
                notification.textContent = message;
                notification.style.display = 'block';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 8000);
            }

            function checkTrafficConditions(position) {
                trafficConditions.forEach(condition => {
                    const distance = map.distance(position, condition.location);
                    if (distance < 5000) { // Within 5km
                        switch(condition.condition) {
                            case 'heavy':
                                updateStatus('danger', condition.message);
                                break;
                            case 'medium':
                                updateStatus('warning', condition.message);
                                break;
                            case 'accident':
                                updateStatus('danger', condition.message);
                                break;
                        }
                    }
                });
            }

            // Fungsi untuk memformat waktu
            function formatTime(hours, minutes) {
                const formattedHours = Math.floor(hours);
                const formattedMinutes = Math.floor(minutes);
                return `${formattedHours}j ${formattedMinutes}m`;
            }

            function updateBusInfo(position, speed, remainingDistance) {
                document.getElementById('speed').textContent = `${speed} km/h`;
                document.getElementById('remainingDistance').textContent = 
                    `${Math.round(remainingDistance)} km`;

                // Konstanta untuk perhitungan ETA
                const targetTravelTimeHours = 8.5; // Target waktu perjalanan 8 jam 30 menit
                const totalDistance = 450; // Perkiraan jarak total dalam km
                
                // Hitung estimasi waktu berdasarkan proporsi jarak yang tersisa
                const proportionRemaining = remainingDistance / totalDistance;
                const remainingTimeHours = targetTravelTimeHours * proportionRemaining;
                
                // Konversi ke jam dan menit
                const hours = Math.floor(remainingTimeHours);
                const minutes = Math.floor((remainingTimeHours - hours) * 60);
                
                document.getElementById('eta').textContent = formatTime(hours, minutes);
                
                checkTrafficConditions(position);
            }

            function animateBus(coordinates) {
                if (currentSegment >= coordinates.length - 1) {
                    showNotification('Bus telah sampai di Terminal Giwangan');
                    updateStatus('normal', 'Perjalanan selesai');
                    return;
                }

                const start = coordinates[currentSegment];
                const end = coordinates[currentSegment + 1];
                const startLatLng = L.latLng(start[1], start[0]);
                const endLatLng = L.latLng(end[1], end[0]);
                
                const now = Date.now();
                if (lastPosition) {
                    const speed = calculateSpeed(lastPosition, [start[1], start[0]], now - lastUpdateTime);
                    const remainingCoords = coordinates.slice(currentSegment);
                    const remainingDistance = remainingCoords.reduce((total, coord, index) => {
                        if (index === 0) return 0;
                        const prev = remainingCoords[index - 1];
                        return total + map.distance([prev[1], prev[0]], [coord[1], coord[0]]) / 1000;
                    }, 0);

                    updateBusInfo([start[1], start[0]], speed, remainingDistance);
                }
                
                lastPosition = [end[1], end[0]];
                lastUpdateTime = now;

                const duration = 2000;
                const startTime = Date.now();
                
                function animate() {
                    const elapsed = Date.now() - startTime;
                    const progress = elapsed / duration;

                    if (progress > 1) {
                        if (routeLine) {
                            const remainingCoords = coordinates.slice(currentSegment + 1)
                                .map(coord => [coord[1], coord[0]]);
                            routeLine.setLatLngs(remainingCoords);
                        }
                        
                        currentSegment++;
                        animateBus(coordinates);
                        return;
                    }

                    const lat = startLatLng.lat + (endLatLng.lat - startLatLng.lat) * progress;
                    const lng = startLatLng.lng + (endLatLng.lng - startLatLng.lng) * progress;
                    movingBus.setLatLng([lat, lng]);

                    requestAnimationFrame(animate);
                }

                animate();
            }

            function fetchRoute() {
                const url = `https://router.project-osrm.org/route/v1/driving/${terminalCicaheum[1]},${terminalCicaheum[0]};${terminalGiwangan[1]},${terminalGiwangan[0]}?overview=full&geometries=geojson`;
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.routes && data.routes.length > 0) {
                            routeCoordinates = data.routes[0].geometry.coordinates;
                            const routeLatLngs = routeCoordinates.map(coord => [coord[1], coord[0]]);
                            
                            routeLine = L.polyline(routeLatLngs, {
                                color: '#3498DB',
                                weight: 5,
                                opacity: 0.7
                            }).addTo(map);

                            map.fitBounds(routeLine.getBounds());
                            updateStatus('normal', 'Bus mulai bergerak');
                            animateBus(routeCoordinates);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching route:', error);
                        updateStatus('danger', 'Gagal mengambil rute. Silakan coba lagi.');
                    });
            }

            fetchRoute();

            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
            
        });
    </script>
</body>
</html>