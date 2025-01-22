<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Tracking</title>
    <!-- Menghubungkan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

        <x-navbar class="header-container sticky top-0 z-10 bg-white shadow-md"></x-navbar>
        
        <x-header class="bg-blue-500 text-white text-center py-4">
            Live Tracking GPS - SDT001
            <p class="text-center text-lg mt-2">Rute bus atau posisi bus pada saat ini</p>
        </x-header>

    <!-- Wrapper kontainer utama -->
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <!-- Card untuk iframe -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden w-11/12 max-w-7xl h-auto">
            <div class="p-4 bg-blue-500 text-white text-lg font-semibold">
                Live Tracking
            </div>
            <!-- Iframe untuk Tracksolid Pro -->
            <iframe src="https://www.tracksolidpro.com/resource/dev/index.html#/monitorObject"
                    class="w-full h-[700px] border-0">
            </iframe>
            <!-- Tombol kembali -->
            <div class="p-4 flex justify-end bg-gray-50">
                <button onclick="window.location.href='/bus-code'"                         
                        class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">                     
                    Kembali                 
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const iframe = document.querySelector("iframe");

        iframe.onload = function() {
            console.log("Iframe telah dimuat!");
        };
    });
    </script>
</body>
</html>
