<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Recipe: <span class="text-blue-600">{{ $product->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <form action="{{ route('products.recipes.update', [$product, $recipe]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Ingredient Selection -->
                    <div class="mb-6">
                        <label for="inventory_item_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Select Ingredient <span class="text-red-600">*</span>
                        </label>
                        <select id="inventory_item_id" 
                                name="inventory_item_id" 
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('inventory_item_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Select an ingredient --</option>
                            @foreach($inventoryItems as $item)
                                <option value="{{ $item->id }}" {{ $recipe->inventory_item_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} ({{ $item->unit }}) - Stock: {{ $item->quantity }}
                                </option>
                            @endforeach
                        </select>
                        @error('inventory_item_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity Needed -->
                    <div class="mb-6">
                        <label for="quantity_needed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Quantity Needed Per Order <span class="text-red-600">*</span>
                        </label>
                        <input type="number" 
                               id="quantity_needed" 
                               name="quantity_needed" 
                               step="0.01" 
                               min="0.01"
                               placeholder="e.g., 0.5, 2, 1.5" 
                               value="{{ $recipe->quantity_needed }}"
                               class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-gray-600 @error('quantity_needed') border-red-500 @enderror"
                               required>
                        @error('quantity_needed')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Current ingredient: <strong>{{ $recipe->inventoryItem->name }}</strong>
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Update Recipe
                        </button>
                        <a href="{{ route('products.recipes.index', $product) }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
