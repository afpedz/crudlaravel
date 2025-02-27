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
                                <button onclick="openModal('{{ $product->id }}')" class="text-gray-800 hover:underline">Edit</button>
                                |
                                <button onclick="openConfirmDelete('{{ $product->id }}')" class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Product Modal --}}
    <div id="addProductModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Add Product</h2>
            <form id="addProductForm" action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="product_code" class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" id="productCode" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="productDescription" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md resize-none" rows="2" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="productCategory" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" step="0.01" name="price" id="productPrice" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                    <select name="unit_id" id="productUnit" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeAddProductModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Add Product</button>
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
    </script>

</x-layout>
