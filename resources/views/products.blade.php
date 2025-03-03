<x-layout>

    <x-slot:title>
        Products
    </x-slot>

    <x-slot:action>
        Add product
    </x-slot>

    <x-slot:onclick>
        showAddProductModal()
    </x-slot>

    @php
        function renderCategories($categories, $parentId = null, $depth = 0)
        {
            foreach ($categories as $category) {
                if ($category->parent_id == $parentId) {
                    echo '<option value="' .
                        $category->id .
                        '">' .
                        str_repeat('&nbsp;&nbsp;', $depth) .
                        $category->name .
                        '</option>';
                    renderCategories($categories, $category->id, $depth + 1);
                }
            }
        }
    @endphp


    <div class="max-w-7xl mx-auto mt-6">
        @if ($products->isEmpty())
            <div class="text-center text-gray-700">
                <p>No products yet, add one.</p>
            </div>
        @else
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
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border border-gray-300 text-gray-700 hover:bg-gray-50">
                            <td class="border border-gray-300 px-5 py-2 text-center">{{ $product->id }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $product->product_code }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $product->description }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $product->category->name }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $product->price }}</td>
                            <td class="border border-gray-300 px-5 py-2">{{ $product->unit->name }}</td>
                            <td class="border border-gray-300 px-5 py-2">
                                <div class="flex justify-center gap-2">
                                    <button onclick="openEditProductModal('{{ $product->id }}')"
                                        class="text-gray-800 hover:underline"><svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>|
                                    <button onclick="openConfirmDelete('{{ $product->id }}')"
                                        class="text-red-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div id="addProductModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Add Product</h2>
            <form id="addProductForm" action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="product_code" class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" id="productCode"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="productDescription"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md resize-none" rows="2" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="productCategory"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="">Select a Category</option>
                        @php renderCategories($categories) @endphp
                    </select>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" step="0.01" name="price" id="productPrice"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                    <select name="unit_id" id="productUnit"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="">Select a Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
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

    <div id="editProductModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Edit Product</h2>
            <form id="editProductForm" action=" " method="POST">
            @csrf
            @method('PUT')
                <input type="hidden" name="product_id" id="editProductId" />
                <div class="mb-4">
                    <label for="editProductCode" class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" id="editProductCode"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="mb-4">
                    <label for="editProductDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="editProductDescription"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md resize-none" rows="2" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="editProductCategory" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="editProductCategory"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="">Select a Category</option>
                        @php renderCategories($categories) @endphp
                    </select>
                </div>
                <div class="mb-4">
                    <label for="editProductPrice" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" step="0.01" name="price" id="editProductPrice"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="mb-4">
                    <label for="editProductUnit" class="block text-sm font-medium text-gray-700">Unit</label>
                    <select name="unit_id" id="editProductUnit"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="">Select a Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeEditProductModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="confirmDeleteModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 id="confirmDeleteMessage" class="text-xl font-semibold text-center mb-4">Are you sure you want to delete this product?</h2>
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
        function showAddProductModal() {
            document.getElementById('addProductModal').classList.remove('hidden');
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
        }
        function openConfirmDelete(productId) {
            document.getElementById('confirmDeleteMessage').textContent = "Are you sure you want to delete this product?";
            document.getElementById('confirmDeleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = '/products/' + productId; // Set the action for the delete form
        }

        function closeConfirmDelete() {
            document.getElementById('confirmDeleteModal').classList.add('hidden');
        }

        document.getElementById("productCategory").addEventListener("change", function() {
            let select = this;
            let selectedOption = select.options[select.selectedIndex];
            if (!selectedOption.hasAttribute("data-original-text")) {
                selectedOption.setAttribute("data-original-text", selectedOption.textContent);
            }
            selectedOption.textContent = selectedOption.getAttribute("data-original-text").trim();
        });
        function openEditProductModal(productId) {
            fetch(`/products/${productId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editProductId').value = data.product.id;
                    document.getElementById('editProductCode').value = data.product.product_code;
                    document.getElementById('editProductDescription').value = data.product.description;
                    document.getElementById('editProductPrice').value = data.product.price;
                    
                    const categorySelect = document.getElementById('editProductCategory');
                    categorySelect.value = data.product.category_id;

                    const unitSelect = document.getElementById('editProductUnit');
                    unitSelect.value = data.product.unit_id;

                    document.getElementById('editProductForm').action = `/products/${data.product.id}`;

                    document.getElementById('editProductModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching product data:', error);
                });
        }

        function closeEditProductModal() {
            document.getElementById('editProductModal').classList.add('hidden');
        }

        document.getElementById("productCategory").addEventListener("mousedown", function() {
            let select = this;
            for (let i = 0; i < select.options.length; i++) {
                let option = select.options[i];
                if (option.hasAttribute("data-original-text")) {
                    option.textContent = option.getAttribute("data-original-text"); // Restore indent
                }
            }
        });
    </script>

</x-layout>
