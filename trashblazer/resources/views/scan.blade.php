<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrashBlazer - Scan</title>
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
<body class="min-h-screen bg-[#EBF2B3]">
    <!-- Include Navbar Component -->
    @include('components.navbar')
    
    <div class="container mx-auto px-6 py-8">
        <!-- Toggle Switch -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center bg-white rounded-full p-1 shadow-lg">
                <!-- Scan Button -->
                <a href="{{ route('scan') }}"
                class="px-6 py-2 rounded-full text-lg font-medium transition-all duration-300 
                        {{ request()->routeIs('scan') ? 'bg-[#1E453E] text-white' : 'text-[#1E453E] hover:bg-gray-100' }}">
                    Scan
                </a>

                <!-- Toggle Icon (clickable) -->
                <a href="{{ route('upload') }}"
                class="mx-2 w-12 h-6 bg-[#1E453E] rounded-full relative group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E453E] transition-all duration-300">
                    <div class="w-5 h-5 bg-white rounded-full absolute top-0.5
                                {{ request()->routeIs('scan') ? 'left-0.5' : 'right-0.5' }}
                                transition-all duration-300 group-hover:scale-110">
                    </div>
                </a>

                <!-- Upload Button -->
                <a href="{{ route('upload') }}"
                class="px-6 py-2 rounded-full text-lg font-medium transition-all duration-300
                        {{ request()->routeIs('upload') ? 'bg-[#1E453E] text-white' : 'text-[#1E453E] hover:bg-gray-100' }}">
                    Upload
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <!-- Camera Preview Area -->
            <div class="bg-gray-200 border-2 border-gray-400 rounded-lg mb-8 aspect-video flex items-center justify-center relative overflow-hidden">
                <video id="video" autoplay class="w-full h-full object-cover"></video>
                
                <!-- Camera Icon (shown when video is not active) -->
                <div id="camera-icon" class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Instructions -->
            <h2 class="text-3xl font-bold text-center text-[#1E453E] mb-6">
                Put The Object In-front of The Camera
            </h2>
            
            <!-- Camera Selection -->
            <div class="flex justify-center mb-8">
                <select id="cameraSelect" class="px-4 py-2 border border-gray-300 rounded-lg bg-white text-[#1E453E] min-w-[200px]">
                    <option value="">Camera 1</option>
                </select>
            </div>
            
            <!-- Capture Button -->
            <div class="flex justify-center mb-8">
                <button id="capture" class="bg-[#1E453E] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Capture Image
                </button>
            </div>
            
            <!-- Hidden Form -->
            <form method="POST" action="{{ route('scan.process') }}" enctype="multipart/form-data" style="display:none;" id="uploadForm">
                @csrf
                <input type="file" name="image" id="imageInput">
            </form>
            
            <!-- Hidden Canvas -->
            <canvas id="canvas" style="display:none;"></canvas>
            
            <!-- Results -->
            @if(isset($data))
                <div class="bg-white rounded-lg shadow-lg p-6 mt-8">
                    <h3 class="text-2xl font-bold text-[#1E453E] mb-4">Prediction Results:</h3>
                    <div class="space-y-3">
                        @foreach($data as $result)
                            <div class="flex justify-between items-center p-3 bg-[#EBF2B3] rounded-lg">
                                <span class="text-[#1E453E] font-semibold text-lg">{{ $result['class'] }}</span>
                                <span class="bg-[#1E453E] text-white px-3 py-1 rounded-full text-sm font-medium">
                                    {{ number_format($result['confidence'] * 100, 1) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture');
        const imageInput = document.getElementById('imageInput');
        const uploadForm = document.getElementById('uploadForm');
        const cameraIcon = document.getElementById('camera-icon');
        
        // Start camera
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    } 
                });
                video.srcObject = stream;
                cameraIcon.style.display = 'none';
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Unable to access camera. Please make sure you have granted camera permissions.');
            }
        }
        
        // Initialize camera on page load
        startCamera();
        
        // Capture image
        captureBtn.addEventListener('click', () => {
            if (video.videoWidth === 0) {
                alert('Camera not ready. Please wait for the camera to initialize.');
                return;
            }
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            canvas.toBlob(blob => {
                const file = new File([blob], 'snapshot.jpg', { type: 'image/jpeg' });
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                imageInput.files = dataTransfer.files;
                
                uploadForm.submit();
            }, 'image/jpeg', 0.8);
        });
    </script>
</body>
</html>