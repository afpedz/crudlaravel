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

    <div id="addCategoryModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Add Category</h2>
            <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="categoryName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="mb-4">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                    <select name="parent_id" id="parentCategory" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="" selected>No Parent (Main Category)</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeAddCategoryModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <div id="confirmDeleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 id="confirmDeleteMessage" class="text-xl font-semibold text-center mb-4">Are you sure you want to delete this category?</h2>
            <div class="flex justify-between gap-4">
                <button onclick="closeConfirmDelete()" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Cancel</button>
                <form id="deleteForm" action="" method="POST" class="inline-block w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 w-full">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <div id="editCategoryModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg w-1/4">
            <h2 class="text-2xl font-bold text-center mb-4">Edit Category</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="category_id" id="categoryId" />
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="editName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required />
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 w-full">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 w-full">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
function toggleChildren(id) {
    const childrenList = document.getElementById(`children-${id}`);
    const arrow = document.getElementById(`arrow-${id}`);
    
    if (childrenList) { // Check if childrenList exists
        if (childrenList.classList.contains('hidden')) {
            childrenList.classList.remove('hidden');
            arrow.classList.add('rotate-180'); // Rotate the arrow
        } else {
            childrenList.classList.add('hidden');
            arrow.classList.remove('rotate-180'); // Reset the arrow
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
        function refreshCategoryList(categories) {
        const categoryList = document.querySelector('ul.list-none');
        categoryList.innerHTML = ''; // Clear the existing list

        categories.forEach(category => {
            if (category.parent_id === null) {
                categoryList.appendChild(createCategoryItem(category));
            }
        });
        }

        function createCategoryItem(category) {
    const newCategoryItem = document.createElement('li');
    newCategoryItem.classList.add('py-2');
    newCategoryItem.setAttribute('data-id', category.id); // Set data-id for future reference

    newCategoryItem.innerHTML = `
        <div class="flex items-center">
            ${category.children && category.children.length > 0 ? `
                <button onclick="toggleChildren('${category.id}')" class="mr-2">
                    <svg id="arrow-${category.id}" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-3-3h6l-3 3z" />
                    </svg>
                </button>
            ` : ''}
            <span class="font-bold">${category.name}</span>
            <div class="ml-auto">
                <button onclick="openEditModal('${category.id}', '${category.name}')" class="text-gray-800 hover:underline">Edit</button>
                <button onclick="openConfirmDelete('${category.id}')" class="text-red-500 hover:underline">Delete</button>
            </div>
        </div>
    `;

    // If the category has children, create a nested list
    if (category.children && category.children.length > 0) {
        const childrenList = document.createElement('ul');
        childrenList.classList.add('hidden', 'pl-5');
        childrenList.id = `children-${category.id}`; // Set the ID for the children list
        category.children.forEach(child => {
            childrenList.appendChild(createCategoryItem(child));
        });
        newCategoryItem.appendChild(childrenList);
    }

    return newCategoryItem;
}

    
        //For adding categoriees AJAX
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
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
                // Refresh the entire category list
                refreshCategoryList(data);
                closeAddCategoryModal();
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
             });
            });
        });

        // For updating categories via AJAX
        document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('editForm').addEventListener('submit', function (e) {
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
            // Refresh the entire category list
            refreshCategoryList(data);
            closeEditCategoryModal(); // Close the modal
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });
});

        // For deleting categories via AJAX
        document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('deleteForm').addEventListener('submit', function (e) {
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
            // Refresh the entire category list
            refreshCategoryList(data);
            closeConfirmDelete(); // Close the confirmation modal
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });
});


    </script>

</x-layout>