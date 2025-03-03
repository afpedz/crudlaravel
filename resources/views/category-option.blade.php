@php
    $padding = $depth * 20; // Adjust the multiplier for desired indentation
@endphp
<option value="{{ $category->id }}" style="padding-left: '{{ $padding }}px;'">{{ $category->name }}</option>

@if ($category->children)
    @foreach ($category->children as $child)
        @include('category-option', ['category' => $child, 'depth' => $depth + 1])
    @endforeach
@endif