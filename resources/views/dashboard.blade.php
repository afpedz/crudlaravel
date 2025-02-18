<x-layout>


<h1 class="text-2xl font-bold text-center text-gray-700"> {{ $title }} </h1>
<!-- keep the logout as a form with the @csrf to prevent cross something something forgery -->
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
</x-layout>