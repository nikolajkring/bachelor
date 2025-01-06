<div id="item-{{ $item->id }}">
    <form method="POST" 
        action="{{ route('items.update', ['id' => $item->id]) }}" 
        hx-put="{{ route('items.update', ['id' => $item->id]) }}" 
        hx-target="#item-{{ $item->id }}" 
        hx-swap="outerHTML">
            @csrf
            @method('PUT')
            <label for="name">Item name:</label>
            <input type="text" name="name" id="name" value="{{ $item->name }}" required>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="{{ $item->price }}" required>
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" value="{{ $item->amount }}" required>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded">Update</button>
    </form>
</div>
