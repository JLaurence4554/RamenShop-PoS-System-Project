<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Recipes for: <span class="text-blue-600">{{ $product->name }}</span>
            </h2>
            <a href="{{ route('product.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add New Recipe Button -->
            <div class="mb-6">
                <a href="{{ route('products.recipes.create', $product) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Add Ingredient to Recipe
                </a>
            </div>

            <!-- Recipes Table -->
            @if($recipes->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Ingredient Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Quantity Needed</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Unit</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recipes as $recipe)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $recipe->inventoryItem->name }}
                                        <span class="text-xs text-gray-500 ml-2">({{ $recipe->inventoryItem->category }})</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $recipe->quantity_needed }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $recipe->inventoryItem->unit }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('products.recipes.edit', [$product, $recipe]) }}" 
                                           class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                        
                                        <form action="{{ route('products.recipes.destroy', [$product, $recipe]) }}" 
                                              method="POST" 
                                              class="inline" 
                                              onsubmit="return confirm('Are you sure you want to remove this ingredient?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Recipe Summary -->
                <div class="mt-8 p-4 bg-blue-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="font-bold text-lg mb-3 text-gray-900 dark:text-white">Recipe Summary</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">
                        When 1 order of <strong>{{ $product->name }}</strong> is placed, the system will deduct:
                    </p>
                    <ul class="space-y-2">
                        @foreach($recipes as $recipe)
                            <li class="text-sm text-gray-800 dark:text-gray-200">
                                • <strong>{{ $recipe->quantity_needed }}</strong> {{ $recipe->inventoryItem->unit }} of <strong>{{ $recipe->inventoryItem->name }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="bg-yellow-50 dark:bg-gray-700 border border-yellow-400 text-yellow-800 dark:text-yellow-200 px-4 py-3 rounded">
                    <p><strong>No recipes defined yet!</strong></p>
                    <p class="text-sm mt-1">Add ingredients to this product's recipe so the system knows what to deduct when orders are placed.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
