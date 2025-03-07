<x-layout>

    <x-slot:title>
        Users
    </x-slot>

    <x-slot:action>
        Add User
    </x-slot>


    <x-slot:onclick>
        document.getElementById('addUserModal').classList.remove('hidden')
    </x-slot>


    <div class="max-w-7xl mx-auto mt-6">
        <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="border border-gray-300 px-5 py-2">ID</th>
                    <th class="border border-gray-300 px-5 py-2">Full Name</th>
                    <th class="border border-gray-300 px-5 py-2">Email</th>
                    <th class="border border-gray-300 px-5 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <tr class="border border-gray-300 text-gray-700 hover:bg-gray-50 item"
                            data-id="{{ $user->id }}">
                            <td class="border border-gray-300 px-5 py-2 text-center">{{ $user->id }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $user->email }}</td>
                            <td class="flex justify-center gap-3 px-5 py-2 text-center">
                                <button
                                    onclick="openModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')"
                                    class="text-gray-800 hover:underline"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                |
                                <button onclick="openConfirmDelete('{{ $user->id }}')"
                                    class="text-red-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    {{-- edit modal --}}
    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden ">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Edit User</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="userId" />
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="userName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="userEmail"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>



    <div id="addUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Add User</h2>
            <form id="addForm" action="" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="userName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="userEmail"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="userPassword"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" name="confirm_password" id="confirmPassword"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeAddUser()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Add
                        User</button>
                </div>
            </form>
        </div>
    </div>


    <div id="confirmDeleteModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden w-auto h-auto">
        <div class="bg-white p-8 rounded-lg w-xs">
            <h2 id="confirmDeleteMessage" class="text-xl font-semibold text-center mb-4">Are you sure you
                want to delete this user?</h2>
            <div class="flex justify-between gap-4">
                <button onclick="closeConfirmDelete()"
                    class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Cancel</button>
                <form id="deleteForm" action="" method="POST" class="inline-block w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 w-full">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id, name, email) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('userId').value = id; // Set the hidden user ID
            document.getElementById('editForm').action = '/dashboard/' + id;

            fetch(`/dashboard/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('userName').value = data.name; // Set the name input
                    document.getElementById('userEmail').value = data.email; // Set the email input
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }


        function addUser() {
            const modal = document.getElementById("addUserModal");
            modal.classList.remove("hidden");
        }

        function closeAddUser() {
            document.getElementById('addUserModal').classList.add('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function openConfirmDelete(userId) {
            const currentUserId = '{{ Auth::id() }}';

            if (userId == currentUserId) {
                document.getElementById('confirmDeleteMessage').textContent =
                    "You are about to delete your own user ID, doing so will log you out. Do you wish to continue?";
            } else {
                document.getElementById('confirmDeleteMessage').textContent = "Are you sure you want to delete this user?";
            }

            document.getElementById('confirmDeleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = '/dashboard/' + userId;
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
                        if (row) {
                            row.querySelector('td:nth-child(2)').textContent = data.name; // Update name
                            row.querySelector('td:nth-child(3)').textContent = data
                            .email; // Update email
                        }
                        closeModal();
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        });
        //for deletion ajax
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
                        if (data.loggedOut) {
                            window.location.href = '/login';
                        } else {
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
