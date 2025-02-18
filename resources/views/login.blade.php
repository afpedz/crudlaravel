<x-layout>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-md rounded-xl">
        <h2 class="text-2xl font-bold text-center text-gray-700">{{ $title }}</h2>
        <form class="space-y-3" action="{{ route('login') }}" method="post">
            @csrf
            <div>
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" placeholder="Enter your email">
                @error('email')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror"  placeholder="Enter your password">
                @error('password')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                @enderror
                @if (session('status'))
                    <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center mt-2">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">{{ $title }}</button>
        </form>
        <p class="text-sm text-center text-gray-600">Don't have an account? <a href="/register" class="text-blue-500 hover:underline">Sign up</a></p>
    </div>
</body>
</x-layout>