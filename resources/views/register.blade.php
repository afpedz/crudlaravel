<x-layout>
    <x-slot:title>
        Register
    </x-slot>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-md rounded-xl">
            <h2 class="text-2xl font-bold text-center text-gray-700">{{ $title }}</h2>
            <form id="registerForm" class="space-y-4" action="{{ route('register') }}" method="post">
                @csrf

                <div>
                    <label class="block text-gray-600">Full Name</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('name') border-red-500 @enderror" placeholder="Enter your full name" value="{{ old('name') }}">
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-600">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('email') border-red-500 @enderror" placeholder="Enter your email" value="{{ old('email') }}">
                    @error('email')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-600">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('password') border-red-500 @enderror" placeholder="Enter your password">
                    @error('password')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('password_confirmation') border-red-500 @enderror" placeholder="Confirm your password">
                    @error('password_confirmation')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2 text-white bg-gray-800 rounded-lg hover:bg-gray-900">{{ $title }}</button>
            </form>
            <p class="text-sm text-center text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-gray-600 hover:underline font-semibold">Login</a></p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST'
                    , url: $(this).attr('action')
                    , data: $(this).serialize()
                    , success: function(response) {
                        window.location.href = response.redirect;
                    }
                    , error: function(xhr) {
                        // Clear previous error messages
                        $('.text-red-500').remove();

                        // Display validation errors
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                const input = $('[name="' + key + '"]');
                                input.addClass('border-red-500'); // Add error class
                                input.after('<div class="text-red-500 mt-2 text-sm">' + value[0] + '</div>'); // Show error message
                            });
                        }
                    }
                });
            });
            $('[name]').on('focus input', function() {
                $(this).removeClass('border-red-500');
                $(this).next('.text-red-500').remove();
            });
        });

    </script>

</x-layout>
