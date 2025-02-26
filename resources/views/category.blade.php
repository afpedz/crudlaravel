<x-layout>

    <x-slot:title>
        Categories
        </x-slot>

        <x-slot:action>
            Add category
            </x-slot>

            <x-slot:onclick>
                document.getElementById('addCategoryModal').classList.remove('hidden');
                </x-slot>

                <div class="max-w-7xl mx-auto mt-6">
                    @if ($categories->isEmpty())
                    <h2 class="text-center text-gray-700">No categories yet, add one to view it here</h2>
                    @else
                    <ul class="list-none">
                        @foreach ($categories as $category)
                        @if (is_null($category->parent_id))
                        <li class="py-2">
                            <div class="flex items-center">
                                @if ($category->children->isNotEmpty())
                                <button onclick="toggleChildren('{{ $category->id }}')" class="mr-2">
                                    <svg id="arrow-{{ $category->id }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-3-3h6l-3 3z" />
                                    </svg>
                                </button>
                                @endif
                                <span class="font-bold">{{ $category->name }}</span>
                                <div class="ml-auto">
                                    <button onclick="openModal('{{ $category->id }}', '{{ $category->name }}')"
                                        class="text-gray-800 hover:underline">Edit</button>
                                    <button onclick="openConfirmDelete('{{ $category->id }}')"
                                        class="text-red-500 hover:underline">Delete</button>
                                </div>
                            </div>
                            <ul id="children-{{ $category->id }}" class="hidden pl-5">
                                @foreach ($category->children as $child)
                                <li class="py-1">{{ $child->name }}</li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @endforeach
                    </ul>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>


                <div id="addCategoryModal"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
                    <div class="bg-white p-8 rounded-lg w-1/4">
                        <h2 class="text-2xl font-bold text-center mb-4">Add Category</h2>
                        <form id="addCategoryForm" action="" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category
                                    ID</label>
                                <input type="text" name="id" id="categoryId"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                            </div>

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                                <input type="text" name="name" id="categoryName"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                            </div>

                            <div class="mb-4">
                                <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent
                                    Category</label>
                                <select name="parent_id" id="parentCategory"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                                    <option value="" selected>No Parent (Main Category)</option>
                                    <!-- Dynamic options can be added here -->
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
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
                
                    // document.getElementById('addCategoryForm').addEventListener('submit', function (event) {
                    //     event.preventDefault();
                    //     console.log('Category added!');
                    //     closeAddCategoryModal();
                    // });
                
                </script>
</x-layout>