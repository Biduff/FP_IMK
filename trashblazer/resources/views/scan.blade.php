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
    @include('components.navbar')

    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-center mb-8">
            <div class="flex items-center bg-white rounded-full p-1 shadow-lg">
                <a href="{{ route('scan') }}" class="px-6 py-2 rounded-full text-lg font-medium transition-all duration-300 {{ request()->routeIs('scan') ? 'bg-[#1E453E] text-white' : 'text-[#1E453E] hover:bg-gray-100' }}">Scan</a>
                <a href="{{ route('upload') }}" class="mx-2 w-12 h-6 bg-[#1E453E] rounded-full relative group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E453E] transition-all duration-300">
                    <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 {{ request()->routeIs('scan') ? 'left-0.5' : 'right-0.5' }} transition-all duration-300 group-hover:scale-110"></div>
                </a>
                <a href="{{ route('upload') }}" class="px-6 py-2 rounded-full text-lg font-medium transition-all duration-300 {{ request()->routeIs('upload') ? 'bg-[#1E453E] text-white' : 'text-[#1E453E] hover:bg-gray-100' }}">Upload</a>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            @if(!isset($data))
            <div class="bg-gray-200 border-2 border-gray-400 rounded-lg mb-8 aspect-video flex items-center justify-center relative overflow-hidden">
                <video id="video" autoplay class="w-full h-full object-cover"></video>
                <div id="camera-icon" class="absolute inset-0 flex items-center justify-center bg-gray-200">
                    <div class="text-center">
                        <svg class="w-24 h-24 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-gray-500 text-lg">Camera initializing...</p>
                    </div>
                </div>
            </div>
            @endif

            @if(!isset($data))
            <h2 class="text-3xl font-bold text-center text-[#1E453E] mb-6">
                Put The Object In-front of The Camera
            </h2>
            <div class="flex justify-center mb-8">
                <select id="cameraSelect" class="px-4 py-2 border border-gray-300 rounded-lg bg-white text-[#1E453E] min-w-[200px]"><option value="">Loading cameras...</option></select>
            </div>
            <div class="flex justify-center mb-8">
                <button id="capture" class="bg-[#1E453E] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Capture Image
                </button>
            </div>
            @endif

            <form method="POST" action="{{ route('scan.process') }}" enctype="multipart/form-data" style="display:none;" id="uploadForm">
                @csrf
                <input type="file" name="image" id="imageInput">
            </form>
            <canvas id="canvas" style="display:none;"></canvas>

            @if(isset($data) && isset($analyzer) && $analyzer->picture)
                <div class="bg-white rounded-lg shadow-lg p-6 mt-8">
                    <h3 class="text-2xl font-bold text-[#1E453E] mb-4 text-center">Scan Result</h3>
                    <div class="mb-6">
                        <canvas id="resultCanvas" class="w-full h-auto rounded-lg shadow-md"></canvas>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-[#1E453E] mb-3">Prediction Details:</h4>
                        <div class="space-y-3">
                            @forelse($data as $result)
                                <div class="flex justify-between items-center p-3 bg-[#EBF2B3] rounded-lg">
                                    <span class="text-[#1E453E] font-semibold text-lg">{{ $result['class'] }}</span>
                                    <span class="bg-[#1E453E] text-white px-3 py-1 rounded-full text-sm font-medium">
                                        {{ number_format($result['confidence'] * 100, 1) }}%
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500">No prediction results available.</p>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('scan') }}" class="bg-[#1E453E] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Scan Again
                        </a>
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
        // --- Camera handling script (no changes) ---
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture');
        const imageInput = document.getElementById('imageInput');
        const uploadForm = document.getElementById('uploadForm');
        const cameraIcon = document.getElementById('camera-icon');
        const cameraSelect = document.getElementById('cameraSelect');

        if (video) { // Only run camera script if video element exists
            let currentStream = null;
            let cameras = [];

            async function getCameras() {
                try {
                    const devices = await navigator.mediaDevices.enumerateDevices();
                    cameras = devices.filter(device => device.kind === 'videoinput');
                    cameraSelect.innerHTML = '';
                    if (cameras.length === 0) {
                        cameraSelect.innerHTML = '<option value="">No cameras found</option>';
                        return;
                    }
                    cameras.forEach((camera, index) => {
                        const option = document.createElement('option');
                        option.value = camera.deviceId;
                        option.textContent = camera.label || `Camera ${index + 1}`;
                        cameraSelect.appendChild(option);
                    });
                    if (cameras.length > 0) {
                        cameraSelect.value = cameras[0].deviceId;
                        startCamera(cameras[0].deviceId);
                    }
                } catch (error) { console.error('Error getting cameras:', error); }
            }

            async function startCamera(deviceId = null) {
                try {
                    if (currentStream) { currentStream.getTracks().forEach(track => track.stop()); }
                    const constraints = { video: { width: { ideal: 1280 }, height: { ideal: 720 } } };
                    if (deviceId) { constraints.video.deviceId = { exact: deviceId }; }
                    currentStream = await navigator.mediaDevices.getUserMedia(constraints);
                    video.srcObject = currentStream;
                    if(cameraIcon) cameraIcon.style.display = 'none';
                    if(captureBtn) captureBtn.disabled = false;
                } catch (error) {
                     console.error('Error accessing camera:', error);
                     if(cameraIcon) cameraIcon.style.display = 'flex';
                     if(captureBtn) captureBtn.disabled = true;
                }
            }

            if(cameraSelect) cameraSelect.addEventListener('change', (e) => e.target.value && startCamera(e.target.value));
            window.addEventListener('load', getCameras);
            if(captureBtn) captureBtn.addEventListener('click', () => {
                if (video.videoWidth === 0) return;
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
            window.addEventListener('beforeunload', () => {
                if (currentStream) { currentStream.getTracks().forEach(track => track.stop()); }
            });
        }


        // --- Script to draw bounding boxes on the result canvas (no changes) ---
        window.addEventListener('load', () => {
            const resultCanvas = document.getElementById('resultCanvas');
            // Check if the canvas and data exist
            @if(isset($data) && isset($analyzer) && $analyzer->picture)
                if (resultCanvas) {
                    const ctx = resultCanvas.getContext('2d');
                    const img = new Image();
                    const predictions = @json($data);

                    img.onload = () => {
                        // Set canvas dimensions to match the image
                        resultCanvas.width = img.naturalWidth;
                        resultCanvas.height = img.naturalHeight;
                        
                        // Draw the original image onto the canvas
                        ctx.drawImage(img, 0, 0);
                        
                        // Draw each bounding box and label
                        predictions.forEach(p => {
                            // Ensure the prediction has box data
                            if (p.box && p.box.length === 4) {
                                const [x, y, w, h] = p.box;
                                const label = `${p.class.toUpperCase()} ${p.confidence.toFixed(2)}`;
                                
                                // --- Style the Box ---
                                ctx.strokeStyle = '#00FF00'; // Green color for the box
                                ctx.lineWidth = 4; // Box line thickness
                                ctx.strokeRect(x, y, w, h);
                                
                                // --- Style the Label ---
                                ctx.fillStyle = '#00FF00'; // Green background for the text
                                ctx.font = '24px sans-serif'; // Text font size
                                const textWidth = ctx.measureText(label).width;
                                
                                // Draw background rectangle for the label
                                ctx.fillRect(x, y, textWidth + 10, 30);
                                
                                // Draw the text
                                ctx.fillStyle = '#000000'; // Black text
                                ctx.fillText(label, x + 5, y + 22);
                            }
                        });
                    };

                    // Load the image that was processed
                    img.src = "{{ asset('storage/' . $analyzer->picture) }}";
                }
            @endif
        });
    </script>
</body>
</html>