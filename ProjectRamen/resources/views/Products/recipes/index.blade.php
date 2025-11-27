<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recipe Management') }}
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
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product-meta {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(-4px);
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
        }

        .recipes-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .add-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
        }

        .recipe-grid {
            display: grid;
            gap: 12px;
        }

        .recipe-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .recipe-card:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(4px);
        }

        .recipe-main {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }

        .recipe-info {
            flex: 1;
        }

        .ingredient-name {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .ingredient-category {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .recipe-quantity {
            text-align: right;
        }

        .quantity-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #10b981;
            display: block;
        }

        .quantity-unit {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .recipe-actions {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-edit {
            flex: 1;
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            padding: 8px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-edit:hover {
            background: rgba(59, 130, 246, 0.3);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .summary-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .summary-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        .summary-title {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .summary-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 4px;
        }

        .summary-content {
            background: rgba(0, 0, 0, 0.2);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .summary-item {
            display: flex;
            align-items: start;
            gap: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .summary-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .summary-bullet {
            color: #10b981;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .summary-text {
            flex: 1;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .summary-text strong {
            color: #10b981;
        }

        .empty-state {
            background: rgba(251, 191, 36, 0.1);
            border: 2px dashed rgba(251, 191, 36, 0.3);
            border-radius: 16px;
            padding: 48px 32px;
            text-align: center;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 16px;
        }

        .empty-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fbbf24;
        }

        .empty-text {
            font-size: 0.95rem;
            opacity: 0.8;
            line-height: 1.6;
        }

        @media (max-width: 1024px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .summary-panel {
                position: relative;
                top: 0;
            }
        }
    </style>

    <div class="page-wrapper">
        <!-- Product Header -->
        <div class="product-header">
            <div class="product-info">
                <div>
                    <div class="product-name">🍜 {{ $product->name }}</div>
                    <div class="product-meta">Recipe Configuration & Ingredient Management</div>
                </div>
                <a href="{{ route('product.index') }}" class="back-btn">
                    ← Back to Products
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="content-wrapper">
            <!-- Recipes Section -->
            <div class="recipes-section">
                <div class="section-header">
                    <div class="section-title">
                        📋 Recipe Ingredients
                    </div>
                    <a href="{{ route('products.recipes.create', $product) }}" class="add-btn">
                        + Add Ingredient
                    </a>
                </div>

                @if($recipes->count() > 0)
                    <div class="recipe-grid">
                        @foreach($recipes as $recipe)
                            <div class="recipe-card">
                                <div class="recipe-main">
                                    <div class="recipe-info">
                                        <div class="ingredient-name">
                                            {{ $recipe->inventoryItem->name }}
                                        </div>
                                        <span class="ingredient-category">
                                            {{ $recipe->inventoryItem->category }}
                                        </span>
                                    </div>
                                    <div class="recipe-quantity">
                                        <span class="quantity-value">{{ rtrim(rtrim(number_format($recipe->quantity_needed, 2, '.', ''), '0'), '.') }}</span>
                                        <span class="quantity-unit">{{ $recipe->inventoryItem->unit }}</span>
                                    </div>
                                </div>
                                <div class="recipe-actions">
                                    <a href="{{ route('products.recipes.edit', [$product, $recipe]) }}" class="btn-edit">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('products.recipes.destroy', [$product, $recipe]) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Remove this ingredient from recipe?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️ Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <div class="empty-title">No Recipe Defined Yet</div>
                        <div class="empty-text">
                            Add ingredients to create the recipe for this product.<br>
                            The system will automatically deduct inventory when orders are placed.
                        </div>
                    </div>
                @endif
            </div>

            <!-- Summary Panel -->
            <div class="summary-panel">
                <div class="summary-header">
                    <div class="summary-title">Recipe Summary</div>
                    <div class="summary-subtitle">Per Order Deduction</div>
                </div>

                @if($recipes->count() > 0)
                    <div class="summary-content">
                        <p style="margin-bottom: 16px; opacity: 0.9; font-size: 0.9rem;">
                            When <strong>1 order</strong> is placed:
                        </p>
                        @foreach($recipes as $recipe)
                            <div class="summary-item">
                                <span class="summary-bullet">•</span>
                                <div class="summary-text">
                                    <strong>{{ rtrim(rtrim(number_format($recipe->quantity_needed, 2, '.', ''), '0'), '.') }}</strong> {{ $recipe->inventoryItem->unit }} 
                                    of {{ $recipe->inventoryItem->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 20px; opacity: 0.6;">
                        <div style="font-size: 2rem; margin-bottom: 8px;">🍳</div>
                        <div style="font-size: 0.9rem;">Add ingredients to see summary</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>