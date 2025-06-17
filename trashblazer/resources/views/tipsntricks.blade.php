<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips & Tricks - TrashBlazer</title>
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
        <h1 class="text-4xl md:text-5xl font-bold text-primary-green mb-12 text-center">Tips & Tricks</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
            @foreach($tipsntricks as $item)
            <div class="bg-yellow-400 rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 cursor-pointer"
                 onclick="window.location.href='{{ route('tipsntricks.show', $item->id) }}'">
                <h2 class="text-xl font-bold text-primary-green mb-4 text-center">{{ $item->judul }}</h2>
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $item->gambar) }}" 
                         alt="{{ $item->judul }}" 
                         class="w-full h-48 object-cover rounded-lg">
                </div>
            </div>
            @endforeach
        </div>

        @if($tipsntricks->isEmpty())
        <div class="text-center py-12">
            <p class="text-2xl text-primary-green font-medium">No tips & tricks available yet.</p>
            <p class="text-lg text-secondary-green mt-2">Check back later for amazing recycling tips!</p>
        </div>
        @endif
    </div>
</body>
</html>