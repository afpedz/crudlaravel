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
            <button onclick="openEditModal('{{ $category->id }}', '{{ $category->name }}')"
                class="text-gray-800 hover:underline">Edit</button>
            <button onclick="openConfirmDelete('{{ $category->id }}')"
                class="text-red-500 hover:underline">Delete</button>
        </div>
    </div>
    @if ($category->children->isNotEmpty())
        <ul id="children-{{ $category->id }}" class="hidden pl-5">
            @foreach ($category->children as $child)
                @include('category-item', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>