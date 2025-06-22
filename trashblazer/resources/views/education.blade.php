<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education - TrashBlazer</title>
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
<body class="min-h-screen bg-primary-yellow">
    <!-- Navigation Bar -->
    @include('components.navbar')

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
        <div class="flex flex-col space-y-3">
            <a href="#" class="text-primary-yellow font-semibold text-lg">Education</a>
            <a href="#" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg">Scan</a>
            <a href="#" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg">Upload</a>
            <a href="#" class="text-white hover:text-[#EBF2B3] transition-colors duration-200 text-lg">Tips & Tricks</a>
        </div>
    </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Main Education Card -->
            <div class="bg-yellow-400 rounded-lg p-8 md:p-12 border-4 border-gray-800 shadow-xl">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    
                    <!-- Image / Icon -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/trash_can.png') }}" 
                            alt="Trash Can Icon" 
                            style="width: 350px;"
                            class="h-auto h-auto object-contain">
                    </div>

                    <!-- Text content -->
                    <div class="flex-1 text-gray-800">
                        <p class="text-lg md:text-xl leading-relaxed mb-6 font-medium">
                            Pengelolaan sampah yang baik dimulai dari rumah. 
                            Dengan memilah dan mengolah sampah dengan benar, kita bisa menjaga kebersihan lingkungan dan mengurangi pencemaran.
                        </p>

                        <h3 class="text-2xl font-bold mb-4">Jenis-Jenis Sampah:</h3>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-green-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-lg"><strong>Organik:</strong> Mudah terurai (sisa makanan, daun).</span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-lg"><strong>Anorganik:</strong> Sulit terurai, bisa didaur ulang (plastik, kaca).</span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-2 h-2 bg-red-600 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-lg"><strong>B3:</strong> Berbahaya, perlu penanganan khusus (baterai, obat).</span>
                            </li>
                        </ul>

                        <h3 class="text-2xl font-bold mb-4">Ayo Mulai!</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">👆</span>
                                <span class="text-lg font-medium">Pilah sampah sebelum dibuang.</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">♻️</span>
                                <span class="text-lg font-medium">Gunakan tempat sampah terpisah.</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🌍</span>
                                <span class="text-lg font-medium">Jadilah bagian dari perubahan untuk bumi yang lebih bersih!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Educational Sections -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Organic Waste Card -->
                <div class="bg-green-100 rounded-lg p-6 border-2 border-green-300 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4 text-center">🥬</div>
                    <h3 class="text-xl font-bold text-green-800 mb-3">Sampah Organik</h3>
                    <p class="text-green-700 mb-4">Sampah yang mudah terurai secara alami oleh mikroorganisme.</p>
                    <ul class="text-sm text-green-600 space-y-1">
                        <li>• Sisa makanan</li>
                        <li>• Daun dan ranting</li>
                        <li>• Kulit buah</li>
                        <li>• Dapat dijadikan kompos</li>
                    </ul>
                </div>

                <!-- Inorganic Waste Card -->
                <div class="bg-blue-100 rounded-lg p-6 border-2 border-blue-300 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4 text-center">♻️</div>
                    <h3 class="text-xl font-bold text-blue-800 mb-3">Sampah Anorganik</h3>
                    <p class="text-blue-700 mb-4">Sampah yang sulit terurai namun dapat didaur ulang.</p>
                    <ul class="text-sm text-blue-600 space-y-1">
                        <li>• Plastik</li>
                        <li>• Kaca</li>
                        <li>• Kaleng</li>
                        <li>• Kertas</li>
                    </ul>
                </div>

                <!-- Hazardous Waste Card -->
                <div class="bg-red-100 rounded-lg p-6 border-2 border-red-300 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4 text-center">⚠️</div>
                    <h3 class="text-xl font-bold text-red-800 mb-3">Sampah B3</h3>
                    <p class="text-red-700 mb-4">Sampah berbahaya yang memerlukan penanganan khusus.</p>
                    <ul class="text-sm text-red-600 space-y-1">
                        <li>• Baterai</li>
                        <li>• Obat kadaluarsa</li>
                        <li>• Lampu neon</li>
                        <li>• Cat dan pelarut</li>
                    </ul>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 text-center">
                <div class="bg-primary-green text-white rounded-lg p-8">
                    <h2 class="text-3xl font-bold mb-4">Siap Memulai Pemilahan Sampah?</h2>
                    <p class="text-xl mb-6">Gunakan fitur scan TrashBlazer untuk mengidentifikasi jenis sampahmu!</p>
                    <a href="{{ route('scan') }}" class="inline-block bg-primary-yellow text-primary-green px-8 py-4 rounded-full text-xl font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Mulai Scan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
