<x-app-layout>
    <x-slot name="header">
        <body id="dashboard_container">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kitchen Details') }}
            </h2>
        </body>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="w-full grid grid-cols-2 gap-6 items-center py-2">
                        {{-- join a kitchen --}}
                        <div class="col-span-2">
                            <h2 class="font-semibold text-xl">Welcome to {{ $kitchen->name }}</h2>
                        </div>
                        
                        {{-- Go back to dashboard btn with htmx --}}
                        <div class="col-span-2 flex justify-end">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                               hx-get="/dashboard" 
                               hx-target="#dashboard_container">Go back to dashboard</a>
                        </div>
                    </div>
                        

                    {{-- wanna add more users? --}}
                    {{-- Check if there are any items --}}
                    {{-- <h2 class="font-semibold text-l">Items:</h2> --}}
                    

                    {{-- Display all items --}}
                    <div id="items-container">
                        @include('partials.items', ['items' => $items])
                    </div>
                    
                    {{-- wanna add more items? --}}
                    <div class="py-12"> 
                        <h2 class="text-2xl font-bold mb-2 py-4 font-semibold text-xl">Add more items {{ $kitchen->name }}</h2>
                        <form
                            class="flex justify-between items-center"
                            method="POST" 
                            action="{{ route('items.store') }}" 
                            hx-post="{{ route('items.store') }}" 
                            hx-target="#items-container" 
                            hx-swap="innerHTML">
                            @csrf
                            <input  type="hidden" name="kitchen_id" value="{{ $kitchen->id }}">

                            <label for="name">Item name:</label>
                            <input type="text" name="name" id="name" required>
                        
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" required>
                        
                            <label for="amount">Amount:</label>
                            <input type="number" name="amount" id="amount" required>
                        
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded">Add item</button>
                        </form>
                    </div>  
                    
                </div>

                {{-- Show your transactions --}}
                <div class="py-6 p-6">
                    <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                    hx-get="/transactions/{{ $kitchen->id }}/{{ Auth::user()->id }}" 
                    hx-target="#dashboard_container">Your kitchen transactions</a>
                </div>

                    {{-- wanna delete the kitchen? --}}
                    {{-- if owner show this --}}
                    {{-- @if (Auth::user()->id === $is_owner->user_id && $user_kitchen->is_owner === 1 && $user_kitchen->kitchen_id === $kitchen->id) --}}
                        <div class="py-6 p-6">
                            <form 
                                method="POST" 
                                action="{{ route('kitchen.destroy', ['id' => $kitchen->id]) }}" 
                                hx-post="{{ route('kitchen.destroy', ['id' => $kitchen->id]) }}"
                                onsubmit="return confirm('Are you sure you want to delete this kitchen?');"
                                >
                                @csrf
                                @method('DELETE')
                                {{-- go to dashboard --}}
                                <button type="submit" class="bg-red-500 hover:bg-red-700 border font-bold py-2 px-4 rounded">Delete kitchen</button>
                            </form>
                        </div>

                        {{-- go to transactions-details.blade.php with htmx --}}
                        <div class="py-6 p-6">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                            hx-get="/transactions/{{ $kitchen->id }}" 
                            hx-target="#dashboard_container">Kitchen transactions</a>
                        </div>

                        {{-- go to settle_account --}}
                        <div class="py-6 p-6">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                            hx-get="/settlements/{{ $kitchen->id }}" 
                            hx-target="#dashboard_container">Settle account</a>
                        </div>
                    {{-- @endif --}}
                
            
            </div>
        </div>
    </div>
</x-app-layout>