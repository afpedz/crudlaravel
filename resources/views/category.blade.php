<x-layout>

    <x-slot:title>
        Categories
    </x-slot>

    <x-slot:action>
        Add category
    </x-slot>

    <x-slot:onclick>
        addCategory()
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
                                        <svg id="arrow-{{ $category->id }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15l-3-3h6l-3 3z" />
                                        </svg>
                                    </button>
                                @endif
                                <span class="font-bold">{{ $category->name }}</span>
                                <div class="ml-auto">
                                    <button onclick="openModal('{{ $category->id }}', '{{ $category->name }}')" class="text-gray-800 hover:underline">Edit</button>
                                    <button onclick="openConfirmDelete('{{ $category->id }}')" class="text-red-500 hover:underline">Delete</button>
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
    </script>

</x-layout>