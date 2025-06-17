<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tipntrick->judul }} - TrashBlazer</title>
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
<body class="min-h-screen bg-primary-yellow">
    @include('components.navbar')
    
    <div class="container mx-auto px-6 py-12">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('tipsntricks.index') }}" 
               class="inline-flex items-center text-primary-green hover:text-secondary-green transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Tips & Tricks
            </a>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-yellow-400 rounded-2xl p-8 shadow-xl">
                <h1 class="text-3xl md:text-4xl font-bold text-primary-green mb-8 text-center">{{ $tipntrick->judul }}</h1>
                
                <!-- Image -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('storage/' . $tipntrick->gambar) }}" 
                         alt="{{ $tipntrick->judul }}" 
                         class="w-full max-w-md h-auto rounded-xl shadow-lg">
                </div>

                <!-- Alat dan Bahan -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-primary-green mb-4">Alat dan bahan:</h2>
                    <div class="text-primary-green text-lg leading-relaxed">
                        {!! nl2br(e($tipntrick->alat_dan_bahan)) !!}
                    </div>
                </div>

                <!-- Langkah-langkah -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-primary-green mb-4">Cara membuat:</h2>
                    <div class="text-primary-green text-lg leading-relaxed">
                        {!! nl2br(e($tipntrick->langkah_langkah)) !!}
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="text-center mt-12">
                    <p class="text-xl text-primary-green font-medium mb-4">
                        Selamat mencoba! Mari bersama-sama menjaga lingkungan dengan mendaur ulang sampah.
                    </p>
                    <a href="{{ route('tipsntricks.index') }}" 
                       class="inline-block bg-primary-green text-primary-yellow px-8 py-3 rounded-full text-lg font-semibold hover:bg-secondary-green transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Lihat Tips Lainnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>