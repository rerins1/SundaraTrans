{{-- Navbar --}}
<nav class="sticky top-0 z-50 left-0 w-full bg-white shadow-md">
    <!-- Alert Container - Pindah ke tengah atas -->
    @if(session('success'))
    <div id="success-alert" class="fixed left-1/2 transform -translate-x-1/2 top-4 z-50 flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800 min-w-[320px] max-w-[90%] shadow-lg" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
        <div class="ms-3 text-sm font-medium">
            {{ session('success') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" onclick="closeAlert('success-alert')">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="error-alert" class="fixed left-1/2 transform -translate-x-1/2 top-4 z-50 flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800 min-w-[320px] max-w-[90%] shadow-lg" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
        <div class="ms-3 text-sm font-medium">
            {{ session('error') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" onclick="closeAlert('error-alert')">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif

    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">Sundara Trans</span>
        </a>
        <button data-collapse-toggle="navbar-multi-level" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-multi-level" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
            <ul class="flex flex-col md:flex-row items-center font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu Layanan -->
                    <div id="dropdownLayanan"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownLayananLink">
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu Kontak -->
                    <div id="dropdownKontak"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownKontakLink">
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
                <!-- Authentication Buttons -->
                <li class="md:flex md:items-center md:space-x-3">
                    @guest
                        <button data-modal-target="loginModal" data-modal-toggle="loginModal"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                        <button data-modal-target="registerModal" data-modal-toggle="registerModal"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Register</button>
                    @else
                        <div class="relative">
                            <button id="dropdownUserButton" data-dropdown-toggle="dropdownUser"
                                class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                                <span class="mr-2">Wellcome, {{ Auth::user()->name }}</span>
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownUser"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownUserButton">
                                    <li>
                                        <a href="/profile"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                    </li>
                                    <li>
                                        <a href="/"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Home</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-400">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endguest
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal for Login -->
    <form action="{{ route('login.submit') }}" method="post">
        @csrf
        <div id="loginModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded shadow-lg max-w-md w-full">
                <h2 class="text-lg font-semibold mb-4">Login</h2>
                <div class="max-w-sm mx-auto space-y-5">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" required />
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
                    <!-- Error Message Section -->
                    @if(session('Gagal'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('Gagal') }}</span>
                        </div>
                    @endif
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
    <form action="{{ route('registrasi.submit') }}" method="post">
        @csrf
        <div id="registerModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded shadow-lg max-w-md w-full"> <!-- Tambahkan max-w-md dan w-full -->
                <h2 class="text-lg font-semibold mb-4">Register</h2>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Lengkap</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email"  name="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <div class="relative">
                            <input type="password" name="password" id="register-password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <button type="button" onclick="toggleRegisterPassword('register-password', 'register-password-eye')" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg id="register-password-eye" class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 4.5C7.305 4.5 3.25 8 2 12c1.25 4 5.305 7.5 10 7.5s8.75-3.5 10-7.5c-1.25-4-5.305-7.5-10-7.5z" />
                                    <path d="M12 9.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" />
                                </svg>
                            </button>
                        </div>
                        <label for="register-password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="register-password-confirmation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <button type="button" onclick="toggleRegisterPassword('register-password-confirmation', 'register-password-confirmation-eye')" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg id="register-password-confirmation-eye" class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 4.5C7.305 4.5 3.25 8 2 12c1.25 4 5.305 7.5 10 7.5s8.75-3.5 10-7.5c-1.25-4-5.305-7.5-10-7.5z" />
                                    <path d="M12 9.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" />
                                </svg>
                            </button>
                        </div>
                        <label for="register-password-confirmation" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Konfirmasi Password</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="tel" pattern="^08[0-9]{8,11}$" name="phone" id="phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nomor Handphone (081-234-567-890)</label>
                    </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">DAFTAR</button>
            </div>
        </div>    
    </form>
    

    <!-- Tambahkan Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <!-- Script section -->
    <script>
        // Sembunyikan otomatis peringatan setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const successAlert = document.getElementById('success-alert');
                const errorAlert = document.getElementById('error-alert');
                
                if (successAlert) {
                    successAlert.style.opacity = '0';
                    successAlert.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => successAlert.style.display = 'none', 300);
                }
                if (errorAlert) {
                    errorAlert.style.opacity = '0';
                    errorAlert.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => errorAlert.style.display = 'none', 300);
                }
            }, 5000);
        });

        // Berfungsi untuk menutup peringatan secara manual
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            alert.style.opacity = '0';
            alert.style.transform = 'translate(-50%, -20px)';
            setTimeout(() => alert.style.display = 'none', 300);
        }


        // Periksa apakah ada pesan kesalahan dan tampilkan modal
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('Gagal'))
                openLoginModal();
            @endif
        });

        // Tutup modal saat mengklik di luar
        document.addEventListener('click', function (event) {
            if (event.target.id === 'loginModal' || event.target.id === 'registerModal') {
                document.getElementById('loginModal').classList.add('hidden');
                document.getElementById('registerModal').classList.add('hidden');
            }
        });

        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
            document.getElementById('loginModal').classList.add('hidden');
        }

       // Mencegah modal ditutup saat mengklik di dalam formulir
        document.querySelector('#loginModal .bg-white').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Tutup modal hanya ketika mengklik di luar
        window.onclick = function(event) {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            if (event.target == loginModal) {
                loginModal.classList.add('hidden');
            } else if (event.target == registerModal) {
                registerModal.classList.add('hidden');
            }
        };

        function toggleRegisterPassword(inputId, eyeIconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            // Toggle icon mata
            eyeIcon.setAttribute(
                'd',
                isPassword
                    ? 'M12 4.5C7.305 4.5 3.25 8 2 12c1.25 4 5.305 7.5 10 7.5s8.75-3.5 10-7.5c-1.25-4-5.305-7.5-10-7.5z M12 9.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z'
                    : 'M12 4.5c4.695 0 8.75 3.5 10 7.5-1.25 4-5.305 7.5-10 7.5S3.25 16 2 12c1.25-4 5.305-7.5 10-7.5zm0 2.5a2.5 2.5 0 100 5 2.5 2.5 0 000-5z'
            );
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            // Toggle icon mata
            eyeIcon.setAttribute(
                'd',
                isPassword
                    ? 'M3.98 8.223A10.255 10.255 0 0012 4.5c4.756 0 8.873 3.555 10.02 8.223a1 1 0 010 .554c-1.147 4.668-5.264 8.223-10.02 8.223-4.756 0-8.873-3.555-10.02-8.223a1 1 0 010-.554A10.255 10.255 0 003.98 8.223zm7.02 1.777a2 2 0 11-4 0 2 2 0 014 0z'
                    : 'M2.038 6.962a.75.75 0 111.06-1.06l8.94 8.939a.75.75 0 11-1.061 1.06l-8.94-8.939zm13.424.011a.75.75 0 10-1.061 1.06l8.94 8.94a.75.75 0 101.06-1.061l-8.94-8.94zM5.904 9.134a.75.75 0 10-1.498.15l.324 3.2a.75.75 0 101.498-.15l-.324-3.2z M18.246 10.136a.75.75 0 10-1.486-.192l-.257 2a.75.75 0 101.486.192l.257-2z M2 4.75l.004.09A.75.75 0 003.5 4.5v-1a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-1.5 1.907v1.171a3.5 3.5 0 001.5-2.878v-8A3.5 3.5 0 0017.5.5h-12A3.5 3.5 0 002 4v.75zm6.5 9a2 2 0 114 0 2 2 0 01-4 0z'
            );
        }
    </script>
    <style>
        #success-alert, #error-alert {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
    </style>

</nav>