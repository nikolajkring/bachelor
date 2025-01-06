@foreach ($items as $item)
    @if ($item->amount > 0)
        <div id="item-{{ $item->id }}" class="flex justify-between border rounded py-2 px-3">
            <p>Id: {{ $item->id }}</p>
            <p>Item name: {{ $item->name }}</p>
            <p>Price: {{ $item->price }}</p>
            <p>Amount of items: <span id="amount-{{ $item->id }}">{{ $item->amount }}</span></p>
            {{-- how many do you want --}}
            <input type="number" name="amount_bought" id="amount_bought-{{ $item->id }}" value="1" min="1" max="{{ $item->amount}}" required>
            <button 
                type="button" 
                class="bg-red-500 hover:bg-red-700 border font-bold py-2 px-4 rounded"
                hx-post="{{ route('items.decrement', ['id' => $item->id]) }}"
                hx-trigger="click"
                hx-target="#amount-{{ $item->id }}"
                hx-swap="innerHTML:responseText"
                hx-include="#amount_bought-{{ $item->id }}"
                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
                Buy
            </button>
            
            {{-- if user made item, delete item --}}
            @if ($item->user_id == Auth::id())
                <button 
                    type="button" 
                    class="bg-red-500 hover:bg-red-700 border font-bold py-2 px-4 rounded"
                    hx-delete="{{ route('items.destroy', ['id' => $item->id]) }}"
                    hx-trigger="click"
                    hx-target="#item-{{ $item->id }}"
                    hx-swap="outerHTML"
                    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
                    Delete
                </button>
                
                
                <button 
                    type="button" 
                    class="bg-red-500 hover:bg-red-700 border font-bold py-2 px-4 rounded"
                    hx-get="{{ route('items.edit', ['id' => $item->id]) }}"
                    hx-trigger="click"
                    hx-target="#item-{{ $item->id }}"
                    hx-swap="outerHTML">
                    Edit
                </button>
            @endif
        </div>
    @endif
@endforeach
