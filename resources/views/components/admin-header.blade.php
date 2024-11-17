<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <!-- Judul Halaman -->
    <h2 class="text-xl font-bold">Admin Panel</h2>
    
    <!-- Profile Area -->
    <div class="flex items-center">
        <!-- Gambar Admin -->
        <img src="{{ asset('img/admin.png') }}" alt="Admin" class="w-10 h-10 rounded-full mr-3">
        
        <!-- Welcome Message & Dropdown Container -->
        <div class="relative">
            <!-- Welcome Message with Dropdown Toggle -->
            <button 
                id="settings-button" 
                class="flex items-center space-x-2"
                onclick="event.stopPropagation()"
            >
                <div class="text-left">
                    <span class="block font-semibold">Welcome,</span>
                    <span class="block text-sm">{{ Auth::user()->name }}</span>
                </div>
                <i class="fas fa-chevron-down ml-2"></i>
            </button>

            <!-- Dropdown Menu -->
            <div 
                id="dropdown-menu" 
                class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg hidden z-10"
            >
                <ul class="divide-y divide-gray-200">
                    <!-- Dashboard -->
                    <li>
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg"
                        >
                            Dashboard
                        </a>
                    </li>
                    <!-- Logout -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit" 
                                class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left rounded-b-lg"
                            >
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const settingsButton = document.getElementById('settings-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Toggle Dropdown
    settingsButton.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking anywhere else on the page
    document.addEventListener('click', () => {
        if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('hidden');
        }
    });

    // Prevent dropdown from closing when clicking inside it
    dropdownMenu.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});
</script>