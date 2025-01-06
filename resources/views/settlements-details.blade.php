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

                    <h2>Let's settle the kitchen economy</h2>
                     {{-- Go back to kitchen btn with htmx --}}
                     <div class="py-6 p-6">
                        <a href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                        hx-get="/kitchen/{{ $kitchen->id }}" 
                        hx-target="#dashboard_container">Go back</a>
                    </div>

                    {{-- display all credit for the kitchen --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3>Credits</h3>
                            <p>{{ $credits->sum('total') }}</p>
                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Credit id</th>
                                        <th class="px-4 py-2">User id</th>
                                        <th class="px-4 py-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($credits as $credit)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $credit->id }}</td>
                                            <td class="border px-4 py-2">{{ $credit->user_id }}</td>
                                            <td class="border px-4 py-2">{{ $credit->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h3>Debits</h3>
                            <p>{{ $debits->sum('total') }}</p>
                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Debit id</th>
                                        <th class="px-4 py-2">User id</th>
                                        <th class="px-4 py-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($debits as $debit)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $debit->id }}</td>
                                            <td class="border px-4 py-2">{{ $debit->user_id }}</td>
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