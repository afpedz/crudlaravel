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

    <div class="max-w-7xl px-8 mx-auto mt-6">
        @if ($categoryTree->isEmpty())
            <h2 class="text-center text-gray-700 font-semibold">No categories yet, add one to view it here</h2>
        @else
            <ul class="list-none border-2 p-2 rounded-lg">
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
                            @include('category-option', ['category' => $category, 'depth' => 0])
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


    <div id="confirmDeleteModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 id="confirmDeleteMessage" class="text-xl font-semibold text-center mb-4">Are you sure you want to delete
                this category?</h2>
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

    <div id="editCategoryModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Edit Category</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="category_id" id="categoryId" />
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="editName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeEditCategoryModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleChildren(id) {
            const childrenList = document.getElementById(`children-${id}`);
            const arrow = document.getElementById(`arrow-${id}`);

            if (childrenList) {
                if (childrenList.classList.contains('hidden')) {
                    childrenList.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                } else {
                    childrenList.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                }
            } else {
                console.error(`Children list for category ID ${id} not found.`);
            }
        }

        function showAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.remove('hidden');
        }

        function closeAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.add('hidden');
        }

        function openEditModal(id, name) {
            document.getElementById('editCategoryModal').classList.remove('hidden');
            document.getElementById('categoryId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editForm').action = '/categories/' + id;
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }

        function closeConfirmDelete() {
            document.getElementById('confirmDeleteModal').classList.add('hidden');
        }

        function openConfirmDelete(categoryId) {
            document.getElementById('confirmDeleteMessage').textContent = "Are you sure you want to delete this category?";
            document.getElementById('confirmDeleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = '/categories/' + categoryId;
        }
        //refreshes the category list
        function refreshCategoryList(categories) {
            const categoryList = document.querySelector('ul.list-none');
            if (!categoryList) {
                console.error('Category list element not found.');
                return;
            }

            categoryList.innerHTML = '';

            const categoryMap = {};
            categories.forEach(category => {
                categoryMap[category.id] = {
                    ...category,
                    children: []
                };
            });

            categories.forEach(category => {
                if (category.parent_id) {
                    categoryMap[category.parent_id].children.push(categoryMap[category.id]);
                }
            });

            // Sort the top-level categories alphabetically
            const sortedCategories = Object.values(categoryMap).filter(cat => !cat.parent_id)
                .sort((a, b) => a.name.localeCompare(b.name));

            sortedCategories.forEach(category => {
                categoryList.appendChild(createCategoryItem(category));
            });
        }
        //for when making a new category it checks if its a parent or child or child with child etc.
        function createCategoryItem(category) {
            const newCategoryItem = document.createElement('li');

             if(!category.children.length > 0){
                 newCategoryItem.classList.add('ml-8');
             }
            newCategoryItem.setAttribute('data-id', category.id);
            newCategoryItem.innerHTML = `
                <div class="flex justify-between p-2 mt-2 hover:bg-slate-100 hover:rounded-lg ">
                    ${category.children && category.children.length > 0 ? `
                            <button onclick="toggleChildren('${category.id}')" class="mr-2">
                                <svg id="arrow-${category.id}" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-3-3h6l-3 3z" />
                                </svg>
                            </button>
                        ` : ''}
                    <span class="font-bold">${category.name}</span>
                    <div class="ml-auto  gap-4 flex mr-4">
                        <button onclick="openEditModal('${category.id}', '${category.name}')" class="text-gray-800 hover:underline"><svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg></button>
                        <button onclick="openConfirmDelete('${category.id}')" class="text-red-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg></button>
                    </div>
                </div>
            `;

            if (category.children && category.children.length > 0) {
                const childrenList = document.createElement('ul');
                childrenList.classList.add('hidden', 'pl-5', 'border-t-2', 'mt-2');
                childrenList.id = `children-${category.id}`;

                // Sort children alphabetically before appending
                const sortedChildren = category.children.sort((a, b) => a.name.localeCompare(b.name));
                sortedChildren.forEach(child => {
                    childrenList.appendChild(createCategoryItem(child));
                });

                newCategoryItem.appendChild(childrenList);
            }

            return newCategoryItem;
        }
        function updateCategoryDropdown(categories) {
            const parentCategorySelect = document.getElementById('parentCategory');
            parentCategorySelect.innerHTML =
                '<option value="" selected>No Parent (Main Category)</option>'; // Reset options

            // Sort categories alphabetically
            categories.sort((a, b) => a.name.localeCompare(b.name));

            // Create a map to hold categories by their parent_id
            const categoryMap = {};
            categories.forEach(category => {
                if (!categoryMap[category.parent_id]) {
                    categoryMap[category.parent_id] = [];
                }
                categoryMap[category.parent_id].push(category);
            });

            // Recursive function to add options with indentation
            function addOptions(parentId = null, depth = 0) {
                if (categoryMap[parentId]) {
                    categoryMap[parentId].forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        // Use non-breaking spaces for indentation
                        option.textContent = '\u00A0'.repeat(depth * 4) + category.name; 
                        parentCategorySelect.appendChild(option);
                        addOptions(category.id, depth + 1);
                    });
                }
            }
            addOptions();
        }
        
        // For adding categories AJAX
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
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
                        if (Array.isArray(data.categoryTree) && Array.isArray(data.categories)) {
                            console.log('Data received:', data);

                            refreshCategoryList(data.categoryTree);
                            updateCategoryDropdown(data.categories);
                            closeAddCategoryModal();
                        } else {
                            console.error('Unexpected response structure:', data);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        });

        // For updating categories via AJAX
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
                        if (Array.isArray(data.categoryTree) && Array.isArray(data.categories)) {
                            console.log('Data received:', data);

                            refreshCategoryList(data.categoryTree);
                            updateCategoryDropdown(data.categories);
                            closeEditCategoryModal();
                        } else {
                            console.error('Unexpected response structure:', data);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        });

        // For deleting categories via AJAX
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
                        if (Array.isArray(data.categoryTree) && Array.isArray(data.categories)) {
                            console.log('Data received:', data);

                            refreshCategoryList(data.categoryTree);
                            updateCategoryDropdown(data.categories);
                            closeConfirmDelete();
                        } else {
                            console.error('Unexpected response structure:', data);
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        });
        //use for initial loading indentation of drop down list
        document.addEventListener('DOMContentLoaded', function() {
            updateCategoryDropdown(@json($categories));//idk why error but it works
        });
    </script>

</x-layout>
