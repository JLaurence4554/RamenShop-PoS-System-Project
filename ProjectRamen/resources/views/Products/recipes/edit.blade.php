<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Ingredient') }}
        </h2>
    </x-slot>

    <style>
        .page-wrapper {
            padding: 20px;
            color: white;
            min-height: 100vh;
        }

        .product-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            padding: 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .product-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 32px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .current-ingredient-banner {
            background: rgba(59, 130, 246, 0.15);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .current-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 4px;
        }

        .current-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #60a5fa;
        }

        .form-section {
            margin-bottom: 28px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: white;
        }

        .required {
            color: #ef4444;
            font-size: 1.2rem;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.08);
            color: white;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-select:focus,
        .form-input:focus {
            outline: none;
            border-color: #f59e0b;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2);
        }

        .form-select option {
            background: #1f2937;
            color: white;
            padding: 12px;
        }

        .form-help {
            margin-top: 8px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: start;
            gap: 6px;
        }

        .error-message {
            margin-top: 8px;
            padding: 10px 12px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            color: #f87171;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-actions {
            display: flex;
            gap: 16px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 2px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            flex: 1;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.5);
        }

        .btn-secondary {
            background: rgba(107, 114, 128, 0.3);
            color: white;
            padding: 16px 32px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.4);
            transform: translateY(-2px);
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            opacity: 0.5;
        }

        .warning-box {
            background: rgba(245, 158, 11, 0.1);
            border: 2px solid rgba(245, 158, 11, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin-top: 24px;
        }

        .warning-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fbbf24;
        }

        .warning-text {
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .comparison-grid {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 16px;
            align-items: center;
            margin-top: 16px;
        }

        .comparison-box {
            background: rgba(0, 0, 0, 0.2);
            padding: 16px;
            border-radius: 10px;
            text-align: center;
        }

        .comparison-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .comparison-value {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .comparison-old {
            color: #f87171;
            text-decoration: line-through;
        }

        .comparison-new {
            color: #10b981;
        }

        .comparison-arrow {
            font-size: 2rem;
            color: #fbbf24;
        }
    </style>

    <div class="page-wrapper">
        <!-- Product Header -->
        <div class="product-header">
            <div class="product-name">✏️ {{ $product->name }}</div>
            <div class="product-subtitle">Update Recipe Ingredient</div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <!-- Current Ingredient Banner -->
            <div class="current-ingredient-banner">
                <div>
                    <div class="current-label">Currently Editing:</div>
                    <div class="current-value">{{ $recipe->inventoryItem->name }}</div>
                </div>
                <div style="text-align: right;">
                    <div class="current-label">Current Quantity:</div>
                    <div class="current-value">{{ rtrim(rtrim(number_format($recipe->quantity_needed, 2, '.', ''), '0'), '.') }} {{ $recipe->inventoryItem->unit }}</div>
                </div>
            </div>

            <form action="{{ route('products.recipes.update', [$product, $recipe]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Ingredient Selection -->
                <div class="form-section">
                    <label for="inventory_item_id" class="form-label">
                        <span>🥘</span>
                        <span>Select Ingredient</span>
                        <span class="required">*</span>
                    </label>
                    <select id="inventory_item_id" 
                            name="inventory_item_id" 
                            class="form-select @error('inventory_item_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Choose an ingredient from inventory --</option>
                        @foreach($inventoryItems as $item)
                            <option value="{{ $item->id }}" {{ $recipe->inventory_item_id == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->unit }}) - Stock: {{ rtrim(rtrim(number_format($item->quantity, 2, '.', ''), '0'), '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('inventory_item_id')
                        <div class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="form-help">
                        <span>💡</span>
                        <span>You can change to a different ingredient if needed</span>
                    </div>
                </div>

                <!-- Quantity Needed -->
                <div class="form-section">
                    <label for="quantity_needed" class="form-label">
                        <span>⚖️</span>
                        <span>Quantity Needed Per Order</span>
                        <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <input type="number" 
                               id="quantity_needed" 
                               name="quantity_needed" 
                               step="0.01" 
                               min="0.01"
                               placeholder="Enter quantity (e.g., 0.5, 2, 1.5)" 
                               value="{{ rtrim(rtrim(number_format($recipe->quantity_needed, 2, '.', ''), '0'), '.') }}"
                               class="form-input @error('quantity_needed') border-red-500 @enderror"
                               required>
                        <span class="input-icon">📊</span>
                    </div>
                    @error('quantity_needed')
                        <div class="error-message">
                            <span>⚠️</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="form-help">
                        <span>💡</span>
                        <span>Update the amount needed for ONE order. Changes will affect future orders only.</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        ✓ Update Recipe
                    </button>
                    <a href="{{ route('products.recipes.index', $product) }}" class="btn-secondary">
                        ← Cancel
                    </a>
                </div>
            </form>

            <!-- Warning Box -->
            <div class="warning-box">
                <div class="warning-title">
                    <span>⚠️</span>
                    <span>Important Note</span>
                </div>
                <div class="warning-text">
                    Changes to this recipe will only apply to <strong>new orders placed after this update</strong>. 
                    Previously placed orders will not be affected.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: Add comparison preview when quantity changes
        const quantityInput = document.getElementById('quantity_needed');
        const originalQuantity = {{ $recipe->quantity_needed }};
        
        quantityInput.addEventListener('input', function() {
            const newValue = parseFloat(this.value);
            if (newValue && newValue !== originalQuantity) {
                // You can add visual feedback here if desired
                console.log('Quantity changed from', originalQuantity, 'to', newValue);
            }
        });
    </script>
</x-app-layout>