<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrashBlazer - Upload</title>
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
                <a href="{{ route('scan') }}" class="mx-2 w-12 h-6 bg-[#1E453E] rounded-full relative group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E453E] transition-all duration-300">
                    <div class="w-5 h-5 bg-white rounded-full absolute top-0.5 {{ request()->routeIs('upload') ? 'right-0.5' : 'left-0.5' }} transition-all duration-300 group-hover:scale-110"></div>
                </a>
                <a href="{{ route('upload') }}" class="px-6 py-2 rounded-full text-lg font-medium transition-all duration-300 {{ request()->routeIs('upload') ? 'bg-[#1E453E] text-white' : 'text-[#1E453E] hover:bg-gray-100' }}">Upload</a>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            @if(!isset($data))
                @if($analyzer && $analyzer->picture)
                    <div class="mb-8">
                        <div class="bg-gray-200 border-2 border-gray-400 rounded-lg aspect-video flex items-center justify-center relative overflow-hidden">
                            <img src="{{ asset('storage/' . $analyzer->picture) }}" alt="Uploaded Picture" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <form action="{{ route('upload.remove') }}" method="POST" class="mt-4 text-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all duration-300">Remove Picture</button>
                        </form>
                    </div>
                @else
                    <div id="dropZone" class="bg-gray-200 border-2 border-gray-400 rounded-lg mb-8 aspect-video flex items-center justify-center relative overflow-hidden">
                        <div id="uploadIcon" class="text-center">
                            <svg class="w-24 h-24 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-gray-500 text-lg">Drop image here or click to upload</p>
                        </div>
                        <img id="preview" class="hidden w-full h-full object-cover rounded-lg" alt="Preview">
                        <div id="dragOverlay" class="absolute inset-0 bg-[#1E453E] bg-opacity-20 border-4 border-dashed border-[#1E453E] rounded-lg hidden items-center justify-center">
                            <p class="text-[#1E453E] text-xl font-semibold">Drop image here</p>
                        </div>
                    </div>
                @endif

                @if(!($analyzer && $analyzer->picture))
                    <form method="POST" action="{{ route('upload.process') }}" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="flex justify-center mb-8">
                            <label for="imageUpload" class="bg-white border border-gray-300 text-[#1E453E] px-6 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-lg cursor-pointer flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span>Choose File</span>
                            </label>
                            <input type="file" name="image" id="imageUpload" accept="image/*" class="hidden" required>
                        </div>
                        
                        <div class="w-full max-w-xs mx-auto flex flex-col space-y-4">
                            <button type="button" id="removeBtn" class="bg-red-500 text-white w-full py-3 rounded-lg text-lg font-semibold hover:bg-red-600 transition-all duration-300 hidden">
                                Remove
                            </button>

                            <button type="submit" id="submitBtn" class="bg-[#1E453E] text-white w-full py-3 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Analyze Image
                            </button>
                        </div>
                        </form>
                @else
                    <form method="POST" action="{{ route('upload.process') }}" id="reAnalyzeForm">
                        @csrf
                        <input type="hidden" name="use_existing" value="1">
                        <div class="flex justify-center"><button type="submit" class="bg-[#1E453E] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">Re-analyze Image</button></div>
                    </form>
                @endif
            @endif

            @if(isset($data))
                <div class="bg-white rounded-lg shadow-lg p-6 mt-8">
                    <h3 class="text-2xl font-bold text-[#1E453E] mb-4 text-center">Analysis Result</h3>
                    <div class="mb-6"><canvas id="resultCanvas" class="w-full h-auto rounded-lg shadow-md"></canvas></div>
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold text-[#1E453E] mb-3">Prediction Details:</h4>
                        <div class="space-y-3">
                            @forelse($data as $result)
                                <div class="flex justify-between items-center p-3 bg-[#EBF2B3] rounded-lg">
                                    <span class="text-[#1E453E] font-semibold text-lg">{{ $result['class'] }}</span>
                                    <span class="bg-[#1E453E] text-white px-3 py-1 rounded-full text-sm font-medium">{{ number_format($result['confidence'] * 100, 1) }}%</span>
                                </div>
                            @empty
                                <p class="text-gray-500">No prediction results available.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="text-center">
                        <form action="{{ route('upload.new') }}" method="POST">@csrf<button type="submit" class="bg-[#1E453E] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 shadow-lg">Upload Another</button></form>
                    </div>
                </div>
            @endif

            @if($errors->any())<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
            @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mt-4">{{ session('success') }}</div>@endif
        </div>
    </div>

    <script>
        // No changes needed in the Javascript
        const dropZone = document.getElementById('dropZone');
        const dragOverlay = document.getElementById('dragOverlay');
        const imageUpload = document.getElementById('imageUpload');
        const preview = document.getElementById('preview');
        const submitBtn = document.getElementById('submitBtn');
        const uploadIcon = document.getElementById('uploadIcon');
        const uploadForm = document.getElementById('uploadForm');
        const removeBtn = document.getElementById('removeBtn');

        if (dropZone && imageUpload && uploadForm) {
            dropZone.addEventListener('click', () => imageUpload.click());
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dragOverlay.classList.remove('hidden'); dragOverlay.classList.add('flex'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); if (!dropZone.contains(e.relatedTarget)) { dragOverlay.classList.add('hidden'); dragOverlay.classList.remove('flex'); } });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dragOverlay.classList.add('hidden');
                dragOverlay.classList.remove('flex');
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type.startsWith('image/')) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    imageUpload.files = dataTransfer.files;
                    showPreview(files[0]);
                    if (submitBtn) { submitBtn.disabled = false; removeBtn.classList.remove('hidden'); }
                }
            });
            imageUpload.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    showPreview(e.target.files[0]);
                    if (submitBtn) { submitBtn.disabled = false; removeBtn.classList.remove('hidden'); }
                }
            });
            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    imageUpload.value = null;
                    preview.src = '';
                    preview.classList.add('hidden');
                    if (uploadIcon) { uploadIcon.classList.remove('hidden'); }
                    submitBtn.disabled = true;
                    removeBtn.classList.add('hidden');
                });
            }
            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = (e) => { preview.src = e.target.result; preview.classList.remove('hidden'); if (uploadIcon) { uploadIcon.classList.add('hidden'); } };
                reader.readAsDataURL(file);
            }
            uploadForm.addEventListener('submit', function(e) { if (!imageUpload.files || imageUpload.files.length === 0) { e.preventDefault(); alert('Please select an image file first.'); return false; } });
        }
        const reAnalyzeForm = document.getElementById('reAnalyzeForm');
        if (reAnalyzeForm) {
            reAnalyzeForm.addEventListener('submit', function(e) {
                const button = e.target.querySelector('button[type="submit"]');
                if (button) { button.disabled = true; button.textContent = 'Analyzing...'; }
            });
        }
        window.addEventListener('load', () => {
            const resultCanvas = document.getElementById('resultCanvas');
            @if(isset($data) && isset($analyzer) && $analyzer->picture)
                if (resultCanvas) {
                    const ctx = resultCanvas.getContext('2d'); const img = new Image(); const predictions = @json($data);
                    img.onload = () => {
                        resultCanvas.width = img.naturalWidth; resultCanvas.height = img.naturalHeight; ctx.drawImage(img, 0, 0);
                        predictions.forEach(p => {
                            if (p.box && p.box.length === 4) {
                                const [x, y, w, h] = p.box; const label = `${p.class.toUpperCase()} ${p.confidence.toFixed(2)}`;
                                ctx.strokeStyle = '#00FF00'; ctx.lineWidth = 4; ctx.strokeRect(x, y, w, h);
                                ctx.fillStyle = '#00FF00'; ctx.font = '24px sans-serif'; const textWidth = ctx.measureText(label).width;
                                ctx.fillRect(x, y, textWidth + 10, 30); ctx.fillStyle = '#000000'; ctx.fillText(label, x + 5, y + 22);
                            }
                        });
                    };
                    img.src = "{{ asset('storage/' . $analyzer->picture) }}";
                }
            @endif
        });
    </script>
</body>
</html>