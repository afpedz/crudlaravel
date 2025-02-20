<x-layout>
    <x:slot name="title">
        Login
    </x:slot>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-md rounded-xl">
            <h2 class="text-2xl font-bold text-center text-gray-700">{{ $title }}</h2>
            <form id="loginForm" class="space-y-3" action="{{ route('login') }}" method="post">
                @csrf
                @if (session('status'))
                <div class="bg-red-500 px-4 py-2 rounded-lg mb-6 text-white text-center mt-2">
                    {{ session('status') }}
                </div>
                @endif
                <div>
                    <label class="block text-gray-600">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('email') border-red-500 @enderror" placeholder="Enter your email">
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
                <button type="submit" class="w-full px-4 py-2 text-white bg-gray-800 rounded-lg hover:bg-gray-900">{{ $title }}</button>
            </form>
            <p class="text-sm text-center text-gray-600">Don't have an account? <a href="/register" class="text-gray-600 hover:underline font-semibold">Sign up</a></p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

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
                        } else if (xhr.status === 401) {
                            // Handle invalid login credentials
                            const statusMessage = xhr.responseJSON.message || 'Invalid login credentials';

                            // Remove any existing invalid login credentials message
                            $('#loginForm .bg-red-500').remove();

                            // Add the new error message
                            $('#loginForm').prepend('<div class="bg-red-500 px-4 py-2 rounded-lg mb-6 text-white text-center mt-2">' + statusMessage + '</div>');
                        }
                    }
                });
            });

            // Remove error styles when the user interacts with the input fields
            $('[name]').on('focus input', function() {
                $(this).removeClass('border-red-500'); // Remove error class
                $(this).next('.text-red-500').remove(); // Remove the error message
            });
        });

    </script>

</x-layout>
