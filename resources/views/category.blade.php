<x-layout>

    <x-slot:title>
        Categories
    </x-slot>

    <x-slot:action>
        Add category
    </x-slot>

    <x-slot:onclick>
        showAddCategoryModal()
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6">
    @if ($categoryTree->isEmpty())
        <h2 class="text-center text-gray-700">No categories yet, add one to view it here</h2>
    @else
        <ul class="list-none">
            @foreach ($categoryTree as $category)
                @if (is_null($category->parent_id))
                    @include('category-item', ['category' => $category])
                @endif
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $categoryTree->links() }}
        </div>
    @endif
</div>

    <div id="addCategoryModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Add Category</h2>
            <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="categoryName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                    <select name="parent_id" id="parentCategory"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="" selected>No Parent (Main Category)</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeAddCategoryModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Add
                        Category</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleChildren(id) {
            const childrenList = document.getElementById(`children-${id}`);
            const arrow = document.getElementById(`arrow-${id}`);
            if (childrenList.classList.contains('hidden')) {
                childrenList.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                childrenList.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        function showAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.remove('hidden');
        }

        function closeAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.add('hidden');
        }
    </script>

</x-layout>