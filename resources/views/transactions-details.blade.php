<x-app-layout>
    <x-slot name="header">
        <body id="dashboard_container">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </body>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- show all transactions related to the kitchen from the transactions table --}}
                    <h2>Kitchen balance</h2>
                    <p>{{ $debits->sum('total') - $credits->sum('total') }}</p>

                    {{-- Go back to kitchen btn with htmx --}}
                    <div class="py-6 p-6">
                        <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                        hx-get="/kitchen/{{ $kitchen->id }}" 
                        hx-target="#dashboard_container">Go back to dashboard</a>
                    </div>
                    

                    <h2>All transactions</h2>
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Id</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">User Id</th>
                                <th class="px-4 py-2">Item Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="border px-4 py-2">{{ $transaction->id }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->amount }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->total }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->created_at }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->user_id }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->item->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>