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
                        'primary-green': '#1E453E',
                        'secondary-green': '#455B55'
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
            <div class="absolute inset-0 bg-primary-yellow bg-opacity-80"></div>
        </div>

        <div class="relative z-10 flex items-center justify-center min-h-screen px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    <span class="text-white block mb-2">KNOW YOUR WASTE,</span>
                    <span class="text-primary-green block">SAVE THE PLANET</span>
                </h1>

                <p class="text-xl md:text-2xl text-primary-green mb-8 font-medium">
                    "Scan it, Know it, Toss it right. TrashBlazer makes sorting waste as<br>
                    easy as snap and go!"
                </p>

                <button 
                    onclick="document.getElementById('about-section').scrollIntoView({ behavior: 'smooth' });"
                    class="bg-primary-yellow text-primary-green px-8 py-4 rounded-full text-xl font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg"
                >
                    Learn More
                </button>
            </div>
        </div>
    </div>


    <div id="about-section" class="min-h-screen flex flex-col md:flex-row">
        <div class="w-full md:w-2/5 bg-secondary-green py-20 px-10 flex flex-col justify-center">
            <div class="max-w-xl mx-auto">
                <h2 class="text-5xl font-bold mb-8 text-primary-yellow">About Us</h2>
                <p class="mb-6 text-xl leading-relaxed text-white">
                    Masalah pengelolaan sampah merupakan isu yang semakin mendesak,
                    sering dengan meningkatnya jumlah populasi dan konsumsi masyarakat.
                    Salah satu tantangan utama dalam pengelolaan sampah adalah kurangnya
                    kesadaran dan pemahaman masyarakat mengenai pentingnya memilah sampah
                    sejak dari sumbernya. Sampah yang tidak dipilah dengan baik
                    dapat menyebabkan pencemaran lingkungan, menghambat proses
                    daur ulang, serta menambah beban pada tempat pembuangan
                    akhir.
                </p>
                <p class="text-xl leading-relaxed text-white">
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
        </div>

        <div class="w-full md:w-3/5 bg-primary-green text-white py-20 px-10 flex flex-col justify-center items-center">
            <div class="max-w-2xl text-center">
                <img src="{{ asset('images/AboutUs.jpg') }}" alt="People cleaning"
                    class="w-full h-auto rounded-2xl shadow-2xl mb-10">
                <h3 class="text-4xl font-bold mb-4">Pemindaian Sampah Real-Time</h3>
                <p class="text-2xl mb-6">
                    Pindai sampahmu sekarang, kenali jenisnya, dan buang dengan benar.
                    Satu langkah kecilmu, dampak besar bagi bumi!
                </p>
                <a href="{{ route('scan') }}">
                    <button class="bg-primary-yellow text-primary-green px-10 py-5 rounded-full text-2xl font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Scan Now
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>