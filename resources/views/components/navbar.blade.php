{{-- Navbar --}}
<nav class="sticky top-0 z-50 left-0 w-full bg-white shadow-md ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">Sundara Trans</span>
        </a>
        <button data-collapse-toggle="navbar-multi-level" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-multi-level" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="/"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-white md:dark:hover:text-red-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent {{ request()->is('/') ? 'text-red-500' : 'text-gray-900' }}"
                        aria-current="page">Beranda</a>
                </li>
                <li>
                    <a href="/bus-code"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-white md:dark:hover:text-red-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent {{ request()->is('bus-code') ? 'text-red-500' : 'text-gray-900' }}">Live
                        GPS Bus</a>
                </li>
                <li>
                    <button id="dropdownLayananLink" data-dropdown-toggle="dropdownLayanan"
                        class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-red-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent {{ request()->is('layanan*') ? 'text-red-500' : 'text-gray-900' }}">
                        Layanan
                        <svg class="w-3 h-3 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu Layanan -->
                    <div id="dropdownLayanan"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLayananLink">
                            <li>
                                <a href="/bus-info"
                                    class="block px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Antar kota Provinsi
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li>
                    <button id="dropdownKontakLink" data-dropdown-toggle="dropdownKontak"
                        class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-red-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent {{ request()->is('kontak*') ? 'text-red-500' : 'text-gray-900' }}">
                        Kontak
                        <svg class="w-3 h-3 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu Kontak -->
                    <div id="dropdownKontak"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownKontakLink">
                            <li>
                                <a href="/tentang-kami"
                                    class="block px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white border-b">Tentang
                                    Kami</a>
                            </li>
                            <li>
                                <a href="/hubungi-kami"
                                    class="block px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white border-b">Hubungi
                                    Kami</a>
                            </li>
                            <li>
                                <a href="/aturan"
                                    class="block px-4 py-2 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Aturan
                                    dan Ketentuan</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
            </ul>
        </div>

        <!-- Tombol Login dan Registrasi -->
        <div class="flex space-x-3">
            <button data-modal-target="loginModal" data-modal-toggle="loginModal"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            <button data-modal-target="registerModal" data-modal-toggle="registerModal"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Register</button>
        </div>
    </div>

    <!-- Modal for Login -->
    <form method="POST" action="{{ route('login') }}" class="max-w-sm mx-auto space-y-5">
        @csrf
        <div id="loginModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded shadow-lg max-w-md w-full">
                <h2 class="text-lg font-semibold mb-4">Login</h2>
                <div class="max-w-sm mx-auto space-y-5">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg id="eyeIcon" class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 4.5C7.305 4.5 3.25 8 2 12c1.25 4 5.305 7.5 10 7.5s8.75-3.5 10-7.5c-1.25-4-5.305-7.5-10-7.5z" />
                                    <path d="M12 9.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-start mt-2 mb-2">
                        <div class="flex items-center h-5">
                            <input id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                        </div>
                        <label for="remember" class="pl-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                    </div>
                </div>
                <div class="mt-4 text-center border-t pt-4">
                    <p class="text-sm text-gray-600">Belum terdaftar? <a href="#" onclick="openRegisterModal()" class="text-blue-600 hover:underline">Registrasi</a></p>
                    <p class="text-sm text-gray-600">Lupa Password? <a href="#" class="text-blue-600 hover:underline">Reset Password</a></p>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal for Register -->
    <form method="POST" action="{{ route('register') }}" class="max-w-md mx-auto">
        @csrf
        <div id="registerModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded shadow-lg max-w-md w-full"> <!-- Tambahkan max-w-md dan w-full -->
                <h2 class="text-lg font-semibold mb-4">Register</h2>
                <form class="max-w-md mx-auto">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email"  name="floating_email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="password" name="floating_password" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="password" name="repeat_password" id="floating_repeat_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Konfirmasi Password</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_first_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Lengkap</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone" id="floating_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nomor Handphone (+6281-1234-5678)</label>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </div>
    </form>
    
</nav>


<!-- Tambahkan Flowbite JS -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('registerModal').classList.add('hidden');
    }

    function openRegisterModal() {
        document.getElementById('registerModal').classList.remove('hidden');
        document.getElementById('loginModal').classList.add('hidden');
    }

    // Optional: close modal by clicking outside of it
    window.onclick = function(event) {
        const loginModal = document.getElementById('loginModal');
        const registerModal = document.getElementById('registerModal');
        if (event.target == loginModal) {
            loginModal.classList.add('hidden');
        } else if (event.target == registerModal) {
            registerModal.classList.add('hidden');
        }
    };

    function togglePassword() {
        const passwordField = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.setAttribute("d", "M12 4.5C7.305 4.5 3.25 8 2 12c1.25 4 5.305 7.5 10 7.5s8.75-3.5 10-7.5c-1.25-4-5.305-7.5-10-7.5z");
        } else {
            passwordField.type = "password";
            eyeIcon.setAttribute("d", "M12 9.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z");
        }
    }
</script>