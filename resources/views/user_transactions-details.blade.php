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
                        @if ($debits->sum('total') + $credits->sum('total') == 0)
                            <h1 class="font-semibold text-xl">You don't owe anything</h1>
                        @elseif ($debits->sum('total') + $credits->sum('total') > 0)
                            <h1 class="font-semibold text-xl">The kitchen owes you {{ $debits->sum('total') - $credits->sum('total') }}</h1>
                        @else
                            <h1 class="font-semibold text-xl">You owe the kitchen {{ $debits->sum('total') - $credits->sum('total') }}</h1>
                        @endif
                        
                        {{-- Go back to kitchen btn with htmx --}}
                        <div class="col-span-2 flex justify-end">
                            <x-secondary-button href="#" class="bg-blue-500 hover:bg-blue-700 border font-bold py-2 px-4 rounded" 
                            hx-get="/kitchen/{{ $kitchen->id }}" 
                            hx-target="#dashboard_container">Go back</x-secondary-button>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- @if (!$credits->isEmpty() || !$debits->isEmpty()) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
                <div class="w-full grid grid-cols-2 gap-6 items-center">
                    <h1 class="font-semibold text-xl">Transactions</h1>
                    {{-- Settle your payments for user logged in --}}
                    
                    @if ($credits->sum('total') + $debits->sum('total') != 0)
                    <div class="col-span-2 flex justify-end">
                        <x-primary-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-settlement')"
                        >{{ __('Settle account') }}</x-primary-button>
                    </div>
                    @endif
                </div>
            
                <!-- Modal -->
                <x-modal name="confirm-settlement" :show="$errors->settlement->isNotEmpty()" focusable>
                    <form 
                        method="POST" 
                        action="/settlements/{{ $kitchen->id }}/{{ Auth::user()->id }}" 
                        class="p-6"
                    >
                        @csrf
            
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Please make sure to sent the money to the number/numbers below') }}
                        </h2>
            
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Once you settle your account, the transaction will be processed. Please confirm to proceed.') }}
                        </p>
            
                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
            
                            <x-primary-button class="ml-3">
                                {{ __('Settle Account') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>

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
            {{-- @endif --}}

        </div>
    </div>
</x-app-layout>