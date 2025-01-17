<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($items as $item)
        @if ($item->amount > 0)
            <div id="item-{{ $item->id }}" class="border rounded py-2 px-3">
                <div>
                    <p class="font-semibold">Item name: {{ $item->name }}</p>
                    <p>Price: {{ $item->price }}</p>
                    <p>Amount of items: <span id="amount-{{ $item->id }}">{{ $item->amount }}</span></p>
                    {{-- how many do you want --}}
                    <input type="number" name="amount_bought" id="amount_bought-{{ $item->id }}" value="1" min="1" max="{{ $item->amount}}" required class="border rounded px-2 py-1 mb-2">
                    <button 
                        type="button" 
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
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
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            hx-delete="{{ route('items.destroy', ['id' => $item->id]) }}"
                            hx-trigger="click"
                            hx-target="#item-{{ $item->id }}"
                            hx-swap="outerHTML"
                            hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
                            Delete
                        </button>
                        
                        <button 
                            type="button" 
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                            hx-get="{{ route('items.edit', ['id' => $item->id]) }}"
                            hx-trigger="click"
                            hx-target="#item-{{ $item->id }}"
                            hx-swap="outerHTML">
                            Edit
                        </button>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>