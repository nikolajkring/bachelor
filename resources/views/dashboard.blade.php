<x-app-layout>
    <x-slot name="header">
        <body id="dashboard_container">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </body>
    </x-slot>

    {{-- Your kitchens --}}
    <div class="py-12" hx-indicator="#loading-spinner">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Your/my kitchens tjek witch kitchens you have in the pivot table --}}
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Your kitchens:</h2>
                        {{-- Display all kitchens id and name here --}}
                        <div id="kitchens-list">
                            @foreach (Auth::user()->kitchens as $kitchen)
                                <div class="flex justify-between border rounded py-2 px-3">
                                    <p>id: {{ $kitchen->id }}</p>
                                    <p>Kitchen code: {{ $kitchen->kitchen_code }}</p>
                                    <p>Name: {{ $kitchen->name }}</p>
                                    {{-- button to go to specific kitchen by id, using htmx and the route defined in web.php --}}
                                    <a href="#" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded" 
                                    hx-get="/kitchen/{{ $kitchen->id }}" 
                                    hx-target="#dashboard_container">Go to kitchen</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    
                    {{-- join a kitchen --}}
                    <div class="pt-6">
                        <h2 class="text-2xl font-bold mb-2">Join a kitchen:</h2>
                        <form method="POST" action="/join-kitchen" hx-post="/join-kitchen" hx-target="#kitchens-list" hx-swap="beforeend">
                            @csrf
                            <div class="mb-4">
                                <label for="kitchen_code" class="block text
                                -gray-700 text-sm font-bold mb-2">Enter the kitchen code:</label>
                                <input placeholder="Code here" type="text" name="kitchen_code" id="kitchen_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded">Join</button>
                        </form>
                    </div>

                    {{-- create a kitchen --}}
                    <div class="pt-6">
                        <h2 class="text-2xl font-bold mb-2">Create a new kitchen:</h2>
                        <form method="POST" action="/create-kitchen" hx-post="/create-kitchen" hx-target="#kitchens-list" hx-swap="beforeend">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Enter the kitchen name:</label>
                                <input placeholder="Name here" type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 border font-bold py-2 px-4 rounded">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kitchen-details" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6"></div>
</x-app-layout>