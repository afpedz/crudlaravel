<x-layout>

    <x-slot:title>
        Products
        </x-slot>


        <x-slot:action>
            Add product
            </x-slot>


            <x-slot:onclick>
                document.getElementById('addProductModal').classList.remove('hidden');
                </x-slot>




                <div class="max-w-7xl mx-auto mt-6">
                    <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="border border-gray-300 px-5 py-2">ID</th>
                                <th class="border border-gray-300 px-5 py-2">Product Code</th>
                                <th class="border border-gray-300 px-5 py-2">Description</th>
                                <th class="border border-gray-300 px-5 py-2">Category</th>
                                <th class="border border-gray-300 px-5 py-2">Price</th>
                                <th class="border border-gray-300 px-5 py-2">Unit</th>
                                <th class="border border-gray-300 px-5 py-2">Action</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
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
                        </tbody> --}}
                    </table>
                </div>



                {{-- product modal --}}


                <div id="addProductModal"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
                    <div class="bg-white p-8 rounded-lg w-1/4">
                        <h2 class="text-2xl font-bold text-center mb-4">Add Product</h2>
                        <form id="addProductForm" action="" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="product_code" class="block text-sm font-medium text-gray-700">Product
                                    Code</label>
                                <input type="text" name="product_code" id="productCode"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="productDescription"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md resize-none"
                                    rows="2" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="productCategory"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" step="0.01" name="price" id="productPrice"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                            </div>

                            <div class="mb-4">
                                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                                <input type="text" name="unit" id="productUnit"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                            </div>

                            <div class="flex justify-between gap-4">
                                <button type="button" onclick="closeAddProductModal()"
                                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Add
                                    Product</button>
                            </div>
                        </form>
                    </div>
                </div>



                <script>
                    function showAddProductModal() {
                        document.getElementById('addProductModal').classList.remove('hidden');
                    }
                
                    function closeAddProductModal() {
                        document.getElementById('addProductModal').classList.add('hidden');
                    }
                
                    // document.getElementById('addProductForm').addEventListener('submit', function(event) {
                    //     event.preventDefault();
                    //     console.log('Product added!');
                    //     closeAddProductModal();
                    // });
                </script>



</x-layout>