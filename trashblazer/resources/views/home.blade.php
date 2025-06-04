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
    @include('components.navbar')
    
    <div class="relative min-h-screen">
        <div class="absolute inset-0">
            <img src="{{ asset('images/HomeBackground.jpg') }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#EBF2B3] bg-opacity-80"></div>
        </div>
        
        <div class="relative z-10 flex items-center justify-center min-h-screen px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    <span class="text-white block mb-2">KNOW YOUR WASTE,</span>
                    <span class="text-[#1E453E] block">SAVE THE PLANET</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-[#1E453E] mb-8 font-medium">
                    "Scan it, Know it, Toss it right. TrashBlazer makes sorting waste as<br>
                    easy as snap and go!"
                </p>
                
                <button class="bg-[#EBF2B3] text-[#1E453E] px-8 py-4 rounded-full text-xl font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Learn More
                </button>
            </div>
        </div>
    </div>

    <div class="bg-primary-green text-white py-16 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold mb-6">About Us</h2>
                <p class="mb-4 text-lg leading-relaxed">
                    Masalah pengelolaan sampah merupakan isu yang semakin mendesak,
                    sering dengan meningkatnya jumlah populasi dan konsumsi masyarakat.
                    Salah satu tantangan utama dalam pengelolaan sampah adalah kurangnya
                    kesadaran dan pemahaman masyarakat mengenai pentingnya memilah sampah
                    sejak dari sumbernya. Sampah yang tidak dipilah dengan baik
                    dapat menyebabkan pencemaran lingkungan, menghambat proses
                    daur ulang, serta menambah beban pada tempat pembuangan
                    akhir.
                </p>
                <p class="text-lg leading-relaxed">
                    Di sinilah saat ini, teknologi dapat menjadi solusi yang efektif
                    untuk mengatasi masalah tersebut. Aplikasi TrashBlazer hadir
                    sebagai inovasi yang memanfaatkan teknologi pemindaian secara
                    real-time (real-time scan) untuk membantu pengguna dalam
                    mengidentifikasi jenis sampah dengan cepat dan akurat. Dengan
                    demikian, diharapkan aplikasi ini dapat meningkatkan kesadaran
                    lingkungan dan mendorong perilaku pemilahan sampah yang
                    berkelanjutan.
                </p>
            </div>

            <div class="flex flex-col items-center">
                <img src="{{ asset('images/AboutUs.jpg') }}" alt="People cleaning" class="w-full h-auto rounded-lg shadow-lg mb-8">
                <div class="text-center">
                    <h3 class="text-3xl font-bold mb-4">Pemindaian Sampah Real-Time</h3>
                    <p class="text-xl mb-6">
                        Pindai sampahmu sekarang, kenali jenisnya, dan buang dengan benar.
                        Satu langkah kecilmu, dampak besar bagi bumi!
                    </p>
                    <button class="bg-primary-yellow text-primary-green px-8 py-4 rounded-full text-xl font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Scan Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>