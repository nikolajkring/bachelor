<div id="item-{{ $item->id }}" class="border rounded py-2 px-3 mb-4">
    <form method="POST" 
        action="{{ route('items.update', ['id' => $item->id]) }}" 
        hx-put="{{ route('items.update', ['id' => $item->id]) }}" 
        hx-target="#item-{{ $item->id }}" 
        hx-swap="outerHTML">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Item name:</label>
            <input type="text" name="name" id="name" value="{{ $item->name }}" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Price:</label>
            <input type="number" name="price" id="price" value="{{ $item->price }}" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-bold mb-2">Amount:</label>
            <input type="number" name="amount" id="amount" value="{{ $item->amount }}" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">Update</button>
    </form>
</div>