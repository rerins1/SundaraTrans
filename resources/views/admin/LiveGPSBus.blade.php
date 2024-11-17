<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live GPS Bus - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places&callback=initMap" async defer></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1">
            <x-admin-header></x-admin-header>

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Lokasi Bus Secara Real-Time</h2>
                <!-- Map Container -->
                <div id="map" class="w-full h-[500px] rounded-lg shadow-lg"></div>

                <!-- Bus Information Section -->
                <div class="mt-6">
                    <h3 class="text-xl font-bold mb-4">Informasi Bus</h3>
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <ul class="space-y-3">
                            <li><strong>ID Bus:</strong> 101</li>
                            <li><strong>Nama Supir:</strong> John Doe</li>
                            <li><strong>Status Bus:</strong> Beroperasi</li>
                            <li><strong>Lokasi Saat Ini:</strong> Bandung</li>
                            <li><strong>Waktu Keberangkatan:</strong> 14:00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let map;
        let busMarker;
        
        // Initialize and add the map
        function initMap() {
            // Peta awal, lokasi Bandung
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -6.9175, lng: 107.6191 },  // Latitude and Longitude for Bandung
                zoom: 12,
            });

            // Marker untuk bus
            busMarker = new google.maps.Marker({
                position: { lat: -6.9175, lng: 107.6191 }, // Lokasi awal bus (Bandung)
                map: map,
                title: "Bus 101",
                icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png" // Ikon untuk bus
            });

            // Mengupdate posisi bus secara real-time (contoh dengan setTimeout)
            updateBusPosition();
        }

        // Simulasi update lokasi bus
        function updateBusPosition() {
            setInterval(() => {
                // Update posisi bus ke lokasi baru secara acak
                let newLat = -6.9175 + (Math.random() * 0.01);  // Pergerakan acak
                let newLng = 107.6191 + (Math.random() * 0.01);  // Pergerakan acak

                busMarker.setPosition({ lat: newLat, lng: newLng });

                // Update informasi lokasi bus
                document.querySelector('strong:contains("Lokasi Saat Ini")').nextSibling.textContent = `${newLat.toFixed(4)}, ${newLng.toFixed(4)}`;
            }, 5000);  // Update setiap 5 detik
        }
    </script>
</body>
</html>
