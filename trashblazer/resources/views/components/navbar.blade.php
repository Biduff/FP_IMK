<nav class="bg-[#1E453E] text-white px-6 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo and Brand -->
        <div class="flex items-center space-x-3">
            <img href="{{ route('home') }}" src="{{ asset('images/icon.png') }}" alt="TrashBlazer Logo" class="w-12 h-12 rounded-full object-cover">
            <a href="{{ route('home') }}" class="text-2xl font-bold">TrashBlazer</a>
        </div>
        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="#" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg font-medium">
                Education
            </a>
            <a href="{{ route('scan') }}" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg font-medium">
                Scan/Upload
            </a>
            <a href="{{ route('tipsntricks.index') }}" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg font-medium">
                Tips & Tricks
            </a>
        </div>
        
        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button id="mobile-menu-btn" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
        <div class="flex flex-col space-y-3">
            <a href="#" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg">
                Education
            </a>
            <a href="{{ route('scan') }}" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg">
                Scan/Upload
            </a>
            <a href="#" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg">
                Tips & Tricks
            </a>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>