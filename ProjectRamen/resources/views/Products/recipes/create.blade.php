<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Ingredient') }}
        </h2>
    </x-slot>

    <style>
        .page-wrapper {
            padding: 20px;
            color: white;
            min-height: 100vh;
        }

        .product-header {
            background: linear-gradient(135deg, #0436a1ff 0%, #0369a1 100%);
            padding: 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(4, 54, 161, 0.3);
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
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5);
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

        .info-box {
            background: rgba(59, 130, 246, 0.1);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin-top: 24px;
        }

        .info-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #60a5fa;
        }

        .info-text {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 12px;
            opacity: 0.9;
        }

        .info-example {
            background: rgba(0, 0, 0, 0.2);
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-top: 12px;
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

        .border-red-500 {
            border-color: #ef4444 !important;
        }
    </style>

    <div class="page-wrapper">
        <!-- Product Header -->
        <div class="product-header">
            <div class="product-name">🍜 {{ $product->name }}</div>
            <div class="product-subtitle">Add New Ingredient to Recipe</div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form action="{{ route('products.recipes.store', $product) }}" method="POST">
                @csrf

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
                        <option value="">-- Select an ingredient --</option>
                        @foreach($inventoryItems as $item)
                            <option value="{{ $item->id }}" {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>
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
                        <span>Select the ingredient that will be deducted from inventory when this product is ordered</span>
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
                               placeholder="e.g., 0.5, 2, 1.5" 
                               value="{{ old('quantity_needed') }}"
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
                        <span>Example: If you need 0.3 kg of noodles per order, enter 0.3</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        ✓ Add Ingredient
                    </button>
                    <a href="{{ route('products.recipes.index', $product) }}" class="btn-secondary">
                        ← Cancel
                    </a>
                </div>
            </form>

            <!-- Info Box -->
            <div class="info-box">
                <div class="info-title">
                    <span>📌</span>
                    <span>How This Works</span>
                </div>
                <div class="info-text">
                    When a customer orders this product, the system will automatically deduct the ingredient quantity you specify here.
                </div>
                <div class="info-example">
                    <strong>🎯 Example:</strong><br>
                    If you add "2 eggs" here, and a customer orders 3 of this product, the system will deduct <strong>6 eggs</strong> (2 × 3) from inventory.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>