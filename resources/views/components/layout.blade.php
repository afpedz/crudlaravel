<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $title ? $title : 'CRUD Laravel' }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@if (!in_array(Route::currentRouteName(), ['login', 'register']))
<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button"
                    class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex shrink-0 items-center">
                    <img class="h-8 w-auto"
                        src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                        alt="Your Company">
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <x-nav-link href="/dashboard" :active="request()->is('dashboard')">Users</x-nav-link>
                        <x-nav-link href="/products" :active="request()->is('products')"> Products</x-nav-link>
                        <x-nav-link href="/category" :active="request()->is('category')">Categories</x-nav-link>
                        <x-nav-link href="/units" :active="request()->is('units')">Units</x-nav-link>
                    </div>
                </div>
            </div>

            <div class="flex justify-end hidden sm:ml-6 sm:block">
                <form action="{{ route('logout') }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Logout</button>
                </form>
            </div>
        </div>
    </div>


    <div class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/dashboard" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
                aria-current="page">Users</a>
            <a href="/products"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Products</a>
            <a href="/category"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Categories</a>
            <div>
                <form action="{{ route('logout') }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="bg-white shadow">
    <div class="flex justify-between mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="text-3xl font-bold tracking-tight text-gray-900"> {{ $title }} </div>
        <button onclick="{{ $onclick }}"
            class="bg-gray-800 px-4 text-white font-semibold hover:bg-gray-900 rounded-lg">{{ $action }}</button>
    </div>
</div>
@endif


<main>

    <body>
        {{ $slot }}
    </body>
</main>


</html>