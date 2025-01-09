<div id="item-{{ $item->id }}" class="border rounded py-2 px-3">
    <div>
        <p class="font-semibold">Item name: {{ $item->name }}</p>
        <p>Price: {{ $item->price }}</p>
        <p>Amount of items: <span id="amount-{{ $item->id }}">{{ $item->amount }}</span></p>
        <input type="number" name="amount_bought" id="amount_bought-{{ $item->id }}" value="1" min="1" max="{{ $item->amount}}" required class="border rounded px-2 py-1 mb-2">
        <button 
            type="button" 
            class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded mb-2"
            hx-post="{{ route('items.decrement', ['id' => $item->id]) }}"
            hx-trigger="click"
            hx-target="#amount-{{ $item->id }}"
            hx-swap="innerHTML:responseText"
            hx-include="#amount_bought-{{ $item->id }}"
            hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
            Buy
        </button>
        
        @if ($item->user_id == Auth::id())
            <button 
                type="button" 
                class="bg-red-500 hover:bg-red-700 border font-bold py-2 px-4 rounded mb-2"
                hx-delete="{{ route('items.destroy', ['id' => $item->id]) }}"
                hx-trigger="click"
                hx-target="#item-{{ $item->id }}"
                hx-swap="outerHTML"
                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
                Delete
            </button>
            
            <button 
                type="button" 
                class="bg-yellow-500 hover:bg-yellow-700 border font-bold py-2 px-4 rounded"
                hx-get="{{ route('items.edit', ['id' => $item->id]) }}"
                hx-trigger="click"
                hx-target="#item-{{ $item->id }}"
                hx-swap="outerHTML">
                Edit
            </button>
        @endif
    </div>
</div>