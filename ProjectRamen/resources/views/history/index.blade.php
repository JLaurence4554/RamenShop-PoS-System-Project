<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Purchase History') }}
        </h2>
    </x-slot>
<div class="p-6 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100">
    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-8">
        @if($histories->count() > 0)
            <table class="min-w-full border-separate border-spacing-y-3 border border-gray-300 dark:border-gray-700 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <th class="px-5 py-4 text-left rounded-tl-lg">Order ID</th>
                        <th class="px-5 py-4 text-left">Order Type</th>
                        <th class="px-5 py-4 text-left">Items</th>
                        <th class="px-5 py-4 text-left">Total (₱)</th>
                        <th class="px-5 py-4 text-left rounded-tr-lg">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr class="bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out shadow-sm">
                            <td class="px-5 py-4 rounded-l-lg">{{ $history->id }}</td>
                            <td class="px-5 py-4">{{ $history->order_type }}</td>
                            <td class="px-5 py-4">
                                <ul class="list-disc list-inside space-y-1">
                                  @foreach($history->items as $item)
                                    <li>{{ $item['name'] }} × {{ $item['qty'] }} = ₱{{ $item['price'] * $item['qty'] }}</li>
                                  @endforeach
                                </ul>
                            </td>
                            <td class="px-5 py-4 font-semibold text-green-500">₱{{ number_format($history->total, 2) }}</td>
                            <td class="px-5 py-4 rounded-r-lg">{{ $history->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-500 dark:text-gray-400 mt-6">No order history found.</p>
        @endif
    </div>
</div>
</x-app-layout>
