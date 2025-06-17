<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TrashBlazer</title>
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
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-primary-green text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold">TrashBlazer Admin Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="bg-primary-yellow text-primary-green px-4 py-2 rounded-lg hover:bg-opacity-90 transition-all duration-200">
                        View Site
                    </a>
                    <a href="{{ route('admin.logout') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all duration-200">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New Tips & Tricks Button -->
        <div class="mb-8">
            <button onclick="openCreateModal()" class="bg-primary-green text-white px-6 py-3 rounded-lg hover:bg-secondary-green transition-all duration-200 font-semibold">
                + Add New Tips & Tricks
            </button>
        </div>

        <!-- Tips & Tricks List -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-primary-green text-white">
                <h2 class="text-xl font-semibold">Tips & Tricks Management</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tipsntricks as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-12 h-12 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button 
                                    class="text-indigo-600 hover:text-indigo-900 mr-3"
                                    onclick="handleEditClick(this)"
                                    data-id="{{ $item->id }}"
                                    data-judul="{{ $item->judul }}"
                                    data-alat="{{ htmlentities($item->alat_dan_bahan) }}"
                                    data-langkah="{{ htmlentities($item->langkah_langkah) }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Tips & Tricks</h3>
                </div>
                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" name="judul" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alat dan Bahan</label>
                            <textarea name="alat_dan_bahan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Langkah-langkah</label>
                            <textarea name="langkah_langkah" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-green text-white rounded-md hover:bg-secondary-green">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Tips & Tricks</h3>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" id="editJudul" name="judul" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (optional)</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alat dan Bahan</label>
                            <textarea id="editAlatBahan" name="alat_dan_bahan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Langkah-langkah</label>
                            <textarea id="editLangkah" name="langkah_langkah" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-green" required></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-green text-white rounded-md hover:bg-secondary-green">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function handleEditClick(button) {
            const id = button.dataset.id;
            const judul = button.dataset.judul;
            const alat = button.dataset.alat;
            const langkah = button.dataset.langkah;

            document.getElementById('editForm').action = `/admin/tipsntricks/${id}`;
            document.getElementById('editJudul').value = judul;
            document.getElementById('editAlatBahan').value = decodeHtml(alat);
            document.getElementById('editLangkah').value = decodeHtml(langkah);
            document.getElementById('editModal').classList.remove('hidden');
        }

        function decodeHtml(html) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = html;
            return textarea.value;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>