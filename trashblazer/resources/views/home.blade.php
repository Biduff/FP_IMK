<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrashBlazer - Know Your Waste, Save The Planet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-yellow': '#EBF2B3',
                        'primary-green': '#1E453E'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen">
    <!-- Include Navbar Component -->
    @include('components.navbar')
    
    <!-- Hero Section -->
    <div class="relative min-h-screen">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/HomeBackground.jpg') }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#EBF2B3] bg-opacity-80"></div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen px-6">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Main Heading -->
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    <span class="text-white block mb-2">KNOW YOUR WASTE,</span>
                    <span class="text-[#1E453E] block">SAVE THE PLANET</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-[#1E453E] mb-8 font-medium">
                    "Scan it, Know it, Toss it right. TrashBlazer makes sorting waste as<br>
                    easy as snap and go!"
                </p>
                
                <!-- Learn More Button -->
                <button class="bg-[#EBF2B3] text-[#1E453E] px-8 py-4 rounded-full text-xl font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Learn More
                </button>
            </div>
        </div>
    </div>
</body>
</html>