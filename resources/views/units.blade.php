<x-layout>

    <x-slot:title>
        Unit
    </x-slot>

    <x-slot:action>
        Add unit
    </x-slot>

    <x-slot:onclick>
        document.getElementById('addUnit').classList.remove('hidden');
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6">
        <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="border border-gray-300 px-5 py-2">ID</th>
                    <th class="border border-gray-300 px-5 py-2">Name</th>
                    <th class="border border-gray-300 px-5 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($units->count() > 0)
                    @foreach ($units->sortBy('id') as $unit)
                        <tr class="border border-gray-300 text-gray-700 hover:bg-gray-50 item"
                            data-id="{{ $unit->id }}">
                            <td class="border border-gray-300 px-5 py-2 text-center">{{ $unit->id }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $unit->name }}</td>
                            <td class="flex justify-center gap-3 px-5 py-2 text-center">
                                <!-- Edit Button -->
                                <button onclick="showEditModal({{ $unit->id }}, '{{ $unit->name }}')"
                                    class="text-gray-800 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                |

                                <!-- Delete Button -->
                                <button onclick="showDeleteModal({{ $unit->id }})"
                                    class="text-red-500 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
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

    <!-- Add Unit Modal -->
    <div id="addUnit" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Add Unit</h2>
            <form id="addUnitForm" action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Unit</label>
                    <input type="text" name="name" id="unitName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeUnitModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Add Unit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Unit Modal -->
    <div id="editUnit" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Edit Unit</h2>
            <form id="editUnitForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editUnitId">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Unit</label>
                    <input type="text" name="name" id="editUnitName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>


    <div id="deleteUnit" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <p class="text-center mb-4">Are you sure you want to delete this unit?</p>
            <form id="deleteUnitForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="deleteUnitId">
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 w-full">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showUnitModal() {
            document.getElementById('addUnit').classList.remove('hidden');
        }

        function closeUnitModal() {
            document.getElementById('addUnit').classList.add('hidden');
        }

        function showEditModal(id, name) {
            document.getElementById('editUnitId').value = id;
            document.getElementById('editUnitName').value = name;
            document.getElementById('editUnitForm').action = `/units/${id}`;
            document.getElementById('editUnit').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editUnit').classList.add('hidden');
        }


        function showDeleteModal(id) {
            document.getElementById('deleteUnitId').value = id;
            document.getElementById('deleteUnitForm').action = `/units/${id}`;
            document.getElementById('deleteUnit').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteUnit').classList.add('hidden');
        }
    </script>




</x-layout>
