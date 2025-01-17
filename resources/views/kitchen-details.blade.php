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
                        <div>
                            <h2 class="text-xl font-semibold">Welcome to {{ $kitchen->name }}</h2>
                            <p>Here is all the items currently in the kitchen</p>
                        </div>
                        
                        {{-- Go back to dashboard btn with htmx --}}
                        <div class="col-span-2 flex justify-end">
                            <x-secondary-button href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                            hx-get="/dashboard" 
                            hx-target="#dashboard_container">Go back to dashboard</x-secondary-button>
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
                <h2 class="text-xl font-semibold">Want to add more items?</h2>
                <div class="py-6">
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
                        <div class="flex justify-between border rounded py-2 px-3 mt-3">
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" required>
                        </div>
                        <div class="flex justify-between border rounded py-2 px-3 mt-3">
                            <label for="amount">Amount:</label>
                            <input type="number" name="amount" id="amount" required>
                        </div>
                        <x-secondary-button type="submit" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 mt-2 rounded">Add item</x-secondary-button>
                    </form>
                </div>  
            </div>
            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
                {{-- Show your transactions --}}
                <h2 class="text-xl font-semibold">See your kitchen transactions and settle your account</h2>
                <div class="py-6">
                    <x-secondary-button href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                    hx-get="/transactions/{{ $kitchen->id }}/{{ Auth::user()->id }}" 
                    hx-target="#dashboard_container">Your kitchen transactions</x-secondary-button>
                </div>
            </div>

            {{-- @if ($isOwner) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
                        <h2 class="text-xl font-semibold">Admin settings</h2>
                        <p>Check all kitchen transactions or delete the kitchen</p>
                        <div class="w-full grid grid-cols-2 gap-6 items-center mb-6">
                        {{-- go to transactions-details.blade.php with htmx --}}
                            <div class="py-6">
                                <x-secondary-button href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                                hx-get="/transactions/{{ $kitchen->id }}" 
                                hx-target="#dashboard_container">Kitchen transactions</x-secondary-button>
                            </div>
                            
                            {{-- wanna delete the kitchen? --}}
                            <div class="py-6 col-span-2 flex justify-end">
                                <x-danger-button
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-kitchen-deletion')"
                                >
                                    {{ __('Delete kitchen') }}
                                </x-danger-button>
                            </div>

                            <!-- Modal -->
                            <x-modal name="confirm-kitchen-deletion" :show="$errors->kitchenDeletion->isNotEmpty()" focusable>
                                <form 
                                    method="POST" 
                                    action="{{ route('kitchen.destroy', ['id' => $kitchen->id]) }}" 
                                    class="p-6"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Are you sure you want to delete this kitchen?') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __('Once your kitchen is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete this kitchen.') }}
                                    </p>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button type="button"  
                                        x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-3">
                                            {{ __('Delete kitchen') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                </div>
            {{-- @endif --}}

        </div>
    </div>
</x-app-layout>