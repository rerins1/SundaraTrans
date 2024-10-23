<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Hubungi Kami - Sundara Trans</title>
</head>

<body class="min-h-screen bg-gray-100 flex flex-col">

    <x-navbar></x-navbar>

    <x-header>Hubungi Kami
        <p class="text-center text-lg mt-2">Tetap terhubung dengan kami, dimana pun anda berada</p>
    </x-header>

    <!-- Main Content -->
    <div class="pt-24 flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-6xl bg-white rounded-lg shadow-lg p-8 grid grid-cols-1 lg:grid-cols-2 gap-8 relative z-10">
            <!-- Form -->
            <div>
                <h2 class="text-2xl font-bold mb-2">Hubungi Kami</h2>
                <p class='mb-6 text-sm'>Hubungi Kami jika ada kendala, error, ataupun masalah lainnya. Kami akan segera merespon.</p>
                <form class="space-y-4">
                    <div>
                        <label class="block text-gray-700">Nama</label>
                        <input
                            type="text"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300"
                            placeholder="Nama Anda"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-700">Email</label>
                        <input
                            type="email"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300"
                            placeholder="Email Anda"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-700">Subjek</label>
                        <input
                            type="text"
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300"
                            placeholder="Subjek Pesan"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-700">Pesan</label>
                        <textarea
                            class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:ring-indigo-300"
                            rows="4"
                            placeholder="Tulis pesan Anda"
                        ></textarea>
                    </div>
                    <div>
                        <button
                            type="submit"
                            class="w-full p-3 bg-blue-700 text-white rounded-md hover:bg-blue-600"
                        >
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Maps -->
            <div class="flex items-center justify-center">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d416.3018909039374!2d107.6892167799499!3d-6.943857796468624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c2be4e6ec9b3%3A0xe6c20e72c0ae86a7!2sPT%20Mekar%20Cargo!5e0!3m2!1sid!2sid!4v1725546697250!5m2!1sid!2sid"
                    width="600"
                    height="450"
                    style="border: 0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="rounded-lg"
                ></iframe>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        // Scroll to top on page load
        window.addEventListener('load', function () {
            window.scrollTo(0, 0);
        });
    </script>
</body>

</html>
