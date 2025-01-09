<x-app-layout>
    <x-slot name="header">
        <body id="dashboard_container">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transactions') }}
            </h2>
        </body>
    </x-slot>
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- show all transactions related to the kitchen from the transactions table, but only for the specific user--}}
                    <div class="w-full grid grid-cols-2 gap-6 items-center">
                        @if ($credits->sum('total') + $debits->sum('total') == 0)
                            <h1 class="font-semibold text-xl">You don't owe anything</h1>
                        @else
                            <h1 class="font-semibold text-xl">Your balance -{{ $credits->sum('total') + $debits->sum('total') }}</h1>
                        @endif
                        
                        {{-- Go back to kitchen btn with htmx --}}
                        <div class="col-span-2 flex justify-end">
                            <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                            hx-get="/kitchen/{{ $kitchen->id }}" 
                            hx-target="#dashboard_container">Go back</a>
                        </div>
                    </div>
                    
                    <div class="w-full grid grid-cols-2 gap-6 items-center items-center py-6">
                        {{-- display all credit for the kitchen --}}
                        <h2 id="settled_box">What hasn't been settled</h2>

                        {{-- settle your payments for user logged in --}}
                        <form 
                            class="col-span-2 flex justify-end"
                            method="POST" 
                            action="/settlements/{{ $kitchen->id }}/{{ Auth::user()->id }}" 
                            hx-post="/settlements/{{ $kitchen->id }}/{{ Auth::user()->id }}" 
                            hx-target="#dashboard_container">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 border font-bold py-2 px-4 rounded">Settle account</button>
                        </form>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h2 class="font-semibold text-l">What you bought from the kitchen</h2>
                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Credit id</th>
                                        <th class="px-4 py-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($credits as $credit)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $credit->id }}</td>
                                            <td class="border px-4 py-2">{{ $credit->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h2 class="font-semibold text-l">What you bought for the kitchen</h2>
                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Debit id</th>
                                        <th class="px-4 py-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($debits as $debit)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $debit->id }}</td>
                                            <td class="border px-4 py-2">{{ $debit->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                

                </div>
            </div>
        </div>
    </div>
</x-app-layout>