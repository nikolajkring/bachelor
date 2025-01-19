
<div class="flex justify-between border rounded py-2 px-3">
    <p>id: {{ $kitchen->id }}</p>
    <p>Kitchen code: {{ $kitchen->kitchen_code }}</p>
    <p>Name: {{ $kitchen->name }}</p>
    <x-primary-button href="#" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded" hx-get="/kitchen/{{ $kitchen->id }}" hx-target="#dashboard_container">Go to kitchen</x-primary-button>
</div>