<x-app-layout>
    <x-slot name="header">
        <body id="dashboard_container">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kitchen details') }}
            </h2>
        </body>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="w-full grid grid-cols-2 gap-6 items-center mb-6">
                        <h2 class="text-xl font-semibold">Welcome to {{ $kitchen->name }}</h2>
                        
                        {{-- Go back to dashboard btn with htmx --}}
                        <div class="col-span-2 flex justify-end">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                            hx-get="/dashboard" 
                            hx-target="#dashboard_container">Go back to dashboard</a>
                        </div>
                    </div>

                    {{-- Display all items --}}
                    <div id="items-container">
                        @include('partials.items', ['items' => $items])
                    </div>
                </div>
            </div>
        

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
                {{-- wanna add more items? --}}
                <div class="py-12">
                    <h2 class="text-2xl font-bold mb-2">Add more items {{ $kitchen->name }}</h2>
                    <form 
                        method="POST" 
                        action="{{ route('items.store') }}" 
                        hx-post="{{ route('items.store') }}" 
                        hx-target="#items-container" 
                        hx-swap="innerHTML">
                        @csrf
                        <input type="hidden" name="kitchen_id" value="{{ $kitchen->id }}">
                        <div class="flex justify-between border rounded py-2 px-3">
                            <label for="name">Item name:</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="flex justify-between border rounded py-2 px-3">
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" required>
                        </div>
                        <div class="flex justify-between border rounded py-2 px-3">
                            <label for="amount">Amount:</label>
                            <input type="number" name="amount" id="amount" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded">Add item</button>
                    </form>
                </div>  
            </div>
            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
                {{-- Show your transactions --}}
                <div class="py-6">
                    <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                    hx-get="/transactions/{{ $kitchen->id }}/{{ Auth::user()->id }}" 
                    hx-target="#dashboard_container">Your kitchen transactions</a>
                </div>

                {{-- @if ($isOwner) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    {{-- wanna delete the kitchen? --}}
                    <div class="py-6">
                        <form 
                            method="POST" 
                            action="{{ route('kitchen.destroy', ['id' => $kitchen->id]) }}" 
                            hx-post="{{ route('kitchen.destroy', ['id' => $kitchen->id]) }}"
                            onsubmit="return confirm('Are you sure you want to delete this kitchen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 border font-bold py-2 px-4 rounded">Delete kitchen</button>
                        </form>
                    </div>

                    {{-- go to transactions-details.blade.php with htmx --}}
                    <div class="py-6">
                        <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                        hx-get="/transactions/{{ $kitchen->id }}" 
                        hx-target="#dashboard_container">Kitchen transactions</a>
                    </div>
                </div>
                {{-- @endif --}}

                {{-- go to settle_account --}}
                {{-- <div class="py-6">
                    <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                    hx-get="/settlements/{{ $kitchen->id }}" 
                    hx-target="#dashboard_container">Settle account</a>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>