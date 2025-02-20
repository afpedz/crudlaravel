<x-layout>
    <div class="flex flex-auto justify-between mb-5 m-10">
        <h1 class="text-2xl font-bold text-center text-gray-700">{{ $title }}</h1>
        <form action="{{ route('logout') }}" method="POST" class="text-center">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Logout</button>
        </form>
    </div>

    <div class="max-w-7xl mx-auto mt-6">
        <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="border border-gray-300 px-5 py-2">ID</th>
                    <th class="border border-gray-300 px-5 py-2">Full Name</th>
                    <th class="border border-gray-300 px-5 py-2">Email</th>
                    <th class="border border-gray-300 px-5 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <tr class="border border-gray-300 text-gray-700 hover:bg-gray-50" data-id="{{ $user->id }}">
                            <td class="border border-gray-300 px-5 py-2 text-center">{{ $user->id }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-5 py-2 text-center">
                                <button onclick="openModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')" class="text-blue-500 hover:underline">Edit</button>
                                |
                                <button onclick="openConfirmDelete('{{ $user->id }}')" class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden ">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Edit User</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="userId" />
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="userName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="userEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-white rounded-md hover:bg-gray-400 w-full">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 w-full">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="confirmDeleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden w-auto h-auto">
        <div class="bg-white p-8 rounded-lg w-xs">
            <h2 id="confirmDeleteMessage" class="text-xl font-semibold text-center mb-4">Are you sure you want to delete this user?</h2>
            <div class="flex justify-between gap-4">
                <button onclick="closeConfirmDelete()" class="px-4 py-2 bg-gray-300 text-white rounded-md hover:bg-gray-400 w-full">Cancel</button>
                <form id="deleteForm" action="" method="POST" class="inline-block w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 w-full">Confirm</button>
                </form>
            </div>
        </div>
    </div>
    <script src="jquery-3.7.1.min.js"></script>
    <script>
        function openModal(id, name, email) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('userId').value = id;
            document.getElementById('userName').value = name;
            document.getElementById('userEmail').value = email;
            document.getElementById('editForm').action = '/dashboard/' + id; // Set the correct action for the update
        }
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }

        function openConfirmDelete(userId) {
            const currentUserId = '{{ Auth::id() }}'; // Get the currently authenticated user's ID

            // Check if the user is trying to delete their own account
            if (userId.toString() === currentUserId) { // Ensure both are strings for comparison
                document.getElementById('confirmDeleteMessage').textContent = "You are about to delete your own user ID, doing so will log you out. Do you wish to continue?";
            } else {
                document.getElementById('confirmDeleteMessage').textContent = "Are you sure you want to delete this user?";
            }

            document.getElementById('confirmDeleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = '/dashboard/' + userId; // Set the action for the delete form
        }


        function closeConfirmDelete() {
            document.getElementById('confirmDeleteModal').classList.add('hidden');
        }
    //for updating ajax
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const actionUrl = this.action;
            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update the table row with the new data
                const row = document.querySelector(`tr[data-id="${data.id}"]`);
                row.querySelector('td:nth-child(2)').textContent = data.name;
                row.querySelector('td:nth-child(3)').textContent = data.email;
                closeModal();
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const actionUrl = this.action;

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
            // Check if the user was logged out
                if (data.loggedOut) {
                    // Redirect to the login page
                    window.location.href = '/login'; // Adjust the URL as needed
                } else {
                    // Remove the deleted user row from the table
                    const row = document.querySelector(`tr[data-id="${data.id}"]`);
                    if (row) {
                        row.remove();
                    }
                    closeConfirmDelete();
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    });

    </script>
</x-layout>
