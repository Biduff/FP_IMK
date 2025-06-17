<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TrashBlazer</title>
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
<body class="min-h-screen bg-gradient-to-br from-primary-green to-secondary-green flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-green mb-2">Admin Login</h1>
            <p class="text-gray-600">Welcome back to TrashBlazer Admin Panel</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-primary-green text-sm font-semibold mb-2">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green focus:border-transparent transition-all duration-200"
                       placeholder="Enter your email"
                       required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-primary-green text-sm font-semibold mb-2">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-green focus:border-transparent transition-all duration-200"
                       placeholder="Enter your password"
                       required>
            </div>

            <button type="submit" 
                    class="w-full bg-primary-green text-white py-3 rounded-lg font-semibold hover:bg-secondary-green transition-all duration-200 transform hover:scale-105 shadow-lg">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-primary-green hover:text-secondary-green transition-colors duration-200">
                ← Back to TrashBlazer
            </a>
        </div>
    </div>
</body>
</html>