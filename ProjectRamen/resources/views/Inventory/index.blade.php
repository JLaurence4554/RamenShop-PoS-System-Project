<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kitchen Inventory') }}
        </h2>
    </x-slot>

    <style>
        /* [All the CSS from the previous artifact remains the same] */
        .page-wrapper {
            padding: 24px;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-filter-group {
            display: flex;
            gap: 12px;
            flex: 1;
            min-width: 300px;
        }

        .search-box, .filter-select {
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 1rem;
        }

        .search-box {
            flex: 1;
        }

        .filter-select {
            cursor: pointer;
            min-width: 150px;
        }

        .filter-select option {
            background: #1f2937;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-primary, .btn-secondary {
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon {
            font-size: 2rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .inventory-table-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .table-header {
            background: rgba(0, 0, 0, 0.3);
            padding: 16px 20px;
        }

        .table-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table thead {
            background: rgba(0, 0, 0, 0.2);
        }

        .inventory-table th {
            padding: 16px;
            text-align: left;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .inventory-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s;
        }

        .inventory-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .inventory-table td {
            padding: 16px;
            font-size: 0.95rem;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-icon {
            font-size: 1.5rem;
        }

        .item-name {
            font-weight: 600;
            font-size: 1rem;
        }

        .item-category {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-in-stock {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-low-stock {
            background: rgba(251, 146, 60, 0.2);
            color: #fb923c;
            border: 1px solid rgba(251, 146, 60, 0.3);
        }

        .status-out-of-stock {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .quantity-display {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .action-buttons-cell {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .btn-icon.edit {
            background: rgba(59, 130, 246, 0.2);
        }

        .btn-icon.delete {
            background: rgba(239, 68, 68, 0.2);
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border-radius: 20px;
            padding: 28px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            color: white;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #3b82f6;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 4px;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.08);
        }

        .form-input option {
            background: #1f2937;
            color: white;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px solid rgba(255, 255, 255, 0.1);
        }

        .btn-cancel {
            flex: 1;
            padding: 14px;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit {
            flex: 1;
            padding: 14px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.5);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 16px;
        }

        .tabs-container {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0;
        }

        .tab-btn {
            padding: 14px 24px;
            border: none;
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            position: relative;
            top: 2px;
        }

        .tab-btn:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .tab-btn.active {
            color: white;
            border-bottom-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .addon-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .addon-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .addon-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .addon-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .addon-table thead {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .addon-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .addon-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background 0.2s;
        }

        .addon-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .addon-table td {
            padding: 12px;
        }

        .addon-actions {
            display: flex;
            gap: 8px;
        }

        .addon-btn-icon {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .addon-btn-edit {
            background: #3b82f6;
            color: white;
        }

        .addon-btn-edit:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .addon-btn-delete {
            background: #ef4444;
            color: white;
        }

        .addon-btn-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .no-addons {
            text-align: center;
            padding: 40px 20px;
            color: rgba(255, 255, 255, 0.5);
        }

        .no-addons-icon {
            font-size: 3rem;
            margin-bottom: 16px;
        }
    </style>

    <div class="page-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="search-filter-group">
                <input 
                    type="text" 
                    class="search-box" 
                    id="searchInput" 
                    placeholder="🔍 Search items...">
                <select class="filter-select" id="categoryFilter">
                    <option value="all">All Categories</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="meat">Meat & Poultry</option>
                    <option value="seafood">Seafood</option>
                    <option value="noodles">Noodles & Pasta</option>
                    <option value="spices">Spices & Seasonings</option>
                    <option value="dairy">Dairy & Eggs</option>
                    <option value="condiments">Condiments</option>
                    <option value="other">Other</option>
                </select>
                <select class="filter-select" id="statusFilter">
                    <option value="all">All Status</option>
                    <option value="in-stock">In Stock</option>
                    <option value="low-stock">Low Stock</option>
                    <option value="out-of-stock">Out of Stock</option>
                </select>
            </div>
            <div class="action-buttons">
                <button class="btn-primary" id="addItemBtn">
                    ➕ Add Item
                </button>
                <button class="btn-secondary" id="restockBtn">
                    📦 Bulk Restock
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('inventory')">
                📦 Inventory Management
            </button>
            <button class="tab-btn" onclick="switchTab('addons')">
                🍽️ Add-ons Management
            </button>
        </div>

        <!-- Inventory Tab Content -->
        <div id="inventory" class="tab-content active">
            <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Items</div>
                        <div class="stat-value">{{ $stats['total_items'] }}</div>
                    </div>
                    <div class="stat-icon">📦</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Low Stock Items</div>
                        <div class="stat-value" style="color: #fb923c;">{{ $stats['low_stock'] }}</div>
                    </div>
                    <div class="stat-icon">⚠️</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Out of Stock</div>
                        <div class="stat-value" style="color: #ef4444;">{{ $stats['out_of_stock'] }}</div>
                    </div>
                    <div class="stat-icon">❌</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Value</div>
                        <div class="stat-value" style="color: #10b981;">₱{{ number_format($stats['total_value'], 2) }}</div>
                    </div>
                    <div class="stat-icon">💰</div>
                </div>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="inventory-table-container">
            <div class="table-header">
                <h3>📋 Inventory List</h3>
            </div>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Min. Stock</th>
                        <th>Unit Price</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="inventoryTableBody">
                    @forelse($items as $item)
                    <tr data-item-id="{{ $item->id }}">
                        <td>
                            <div class="item-info">
                                <div class="item-icon">
                                    @php
                                        $icons = [
                                            'vegetables' => '🥬',
                                            'meat' => '🥩',
                                            'seafood' => '🦐',
                                            'noodles' => '🍜',
                                            'spices' => '🌶️',
                                            'dairy' => '🥚',
                                            'condiments' => '🧂',
                                            'other' => '📦'
                                        ];
                                    @endphp
                                    {{ $icons[$item->category] ?? '📦' }}
                                </div>
                                <div>
                                    <div class="item-name">{{ $item->name }}</div>
                                    @if($item->supplier)
                                        <div class="item-category">{{ $item->supplier }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="text-transform: capitalize;">{{ $item->category }}</td>
                        <td>
                            <span class="quantity-display">{{ rtrim(rtrim(number_format($item->quantity, 2, '.', ''), '0'), '.') }}</span>
                        </td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ rtrim(rtrim(number_format($item->min_stock, 2, '.', ''), '0'), '.') }}</td>
                        <td>₱{{ number_format($item->unit_price, 2) }}</td>
                        <td style="font-weight: 600; color: #10b981;">₱{{ number_format($item->total_value, 2) }}</td>
                        <td>
                            @php
                                $statusClass = 'status-' . $item->status;
                                $statusText = str_replace('-', ' ', ucwords($item->status, '-'));
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            <div class="action-buttons-cell">
                                <button class="btn-icon edit" onclick="editItem({{ $item->id }})" title="Edit">
                                    ✏️
                                </button>
                                <button class="btn-icon" onclick="openRestockModal({{ $item->id }})" title="Restock">
                                    📦
                                </button>
                                <button class="btn-icon delete" onclick="deleteItem({{ $item->id }})" title="Delete">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <div>No items found</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div><!-- Close inventory tab-content -->

        <!-- Add-ons Tab Content -->
        <div id="addons" class="tab-content">
            <!-- Add-ons Management Section -->
            <div style="padding: 24px; background: rgba(255, 255, 255, 0.05); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid rgba(255, 255, 255, 0.1);">
                    <h3 style="font-size: 1.3rem; font-weight: 700;">🍽️ Manage Add-ons</h3>
                    <button class="btn-primary" id="addAddonBtn" style="padding: 10px 20px; font-size: 0.95rem;">+ Add New Add-on</button>
                </div>

                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(255, 255, 255, 0.2);">
                            <th style="padding: 12px; text-align: left;">Name</th>
                            <th style="padding: 12px; text-align: left;">Price (₱)</th>
                            <th style="padding: 12px; text-align: left;">Linked Inventory</th>
                            <th style="padding: 12px; text-align: left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="addonsTableBody">
                        @forelse($addons as $addon)
                        <tr data-addon-id="{{ $addon->id }}" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                            <td style="padding: 12px;">{{ $addon->name }}</td>
                            <td style="padding: 12px;">{{ number_format($addon->price, 2) }}</td>
                            <td style="padding: 12px;">{{ $addon->inventoryItem ? $addon->inventoryItem->name . ' (' . $addon->inventoryItem->unit . ')' : 'None' }}</td>
                            <td style="padding: 12px;">
                                <div class="action-buttons-cell">
                                    <button class="btn-icon edit" onclick="editAddon({{ $addon->id }})" title="Edit">
                                        ✏️
                                    </button>
                                    <button class="btn-icon delete" onclick="deleteAddon({{ $addon->id }})" title="Delete">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 20px; text-align: center; color: #999;">No add-ons yet. Create one to get started!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div><!-- Close addons tab-content -->
    </div><!-- Close main container -->

    <!-- Add/Edit Item Modal -->
    <div id="itemModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Item</h2>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>

            <form id="itemForm">
                @csrf
                <input type="hidden" id="itemId">
                
                <div class="form-group">
                    <label>Item Name *</label>
                    <input type="text" class="form-input" id="itemName" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Category *</label>
                        <select class="form-input" id="itemCategory" required>
                            <option value="">Select Category</option>
                            <option value="vegetables">Vegetables</option>
                            <option value="meat">Meat & Poultry</option>
                            <option value="seafood">Seafood</option>
                            <option value="noodles">Noodles & Pasta</option>
                            <option value="spices">Spices & Seasonings</option>
                            <option value="dairy">Dairy & Eggs</option>
                            <option value="condiments">Condiments</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Unit *</label>
                        <select class="form-input" id="itemUnit" required>
                            <option value="">Select Unit</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="g">Gram (g)</option>
                            <option value="l">Liter (l)</option>
                            <option value="ml">Milliliter (ml)</option>
                            <option value="pcs">Pieces (pcs)</option>
                            <option value="pack">Pack</option>
                            <option value="box">Box</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Quantity *</label>
                        <input type="number" class="form-input" id="itemQuantity" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label>Minimum Stock *</label>
                        <input type="number" class="form-input" id="itemMinStock" min="0" step="0.01" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Unit Price (₱) *</label>
                    <input type="number" class="form-input" id="itemPrice" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Supplier (Optional)</label>
                    <input type="text" class="form-input" id="itemSupplier">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Save Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Restock Modal -->
    <div id="restockModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Restock Item</h2>
                <button class="close-btn" id="closeRestockModal">&times;</button>
            </div>

            <form id="restockForm">
                @csrf
                <input type="hidden" id="restockItemId">
                
                <div class="form-group">
                    <label>Current Quantity</label>
                    <input type="text" class="form-input" id="currentQuantity" readonly>
                </div>

                <div class="form-group">
                    <label>Add Quantity *</label>
                    <input type="number" class="form-input" id="addQuantity" min="0.01" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>New Total</label>
                    <input type="text" class="form-input" id="newTotal" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancelRestockBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Confirm Restock</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add/Edit Add-on Modal -->
    <div id="addonModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="addonModalTitle">Add New Add-on</h2>
                <button class="close-btn" id="closeAddonModalBtn">&times;</button>
            </div>

            <form id="addonForm">
                @csrf
                <input type="hidden" id="addonId">

                <div class="form-group">
                    <label>Add-on Name *</label>
                    <input type="text" class="form-input" id="addonName" required>
                </div>

                <div class="form-group">
                    <label>Price (₱) *</label>
                    <input type="number" class="form-input" id="addonPrice" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label>Link to Inventory Item (Optional)</label>
                    <select class="form-input" id="addonInventoryItem">
                        <option value="">-- Select Inventory Item --</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->unit }})</option>
                        @endforeach
                    </select>
                    <small style="display: block; margin-top: 6px; color: rgba(255, 255, 255, 0.6);">Selecting an inventory item will deduct from it when this add-on is ordered</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancelAddonBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Save Add-on</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const addonModal = document.getElementById('addonModal');

        // Open add item modal
        document.getElementById('addAddonBtn').addEventListener('click', () => {
            document.getElementById('addonModalTitle').textContent = 'Add New Add-on';
            document.getElementById('addonForm').reset();
            document.getElementById('addonId').value = '';
            addonModal.classList.add('active');
        });

        // Close addon modal
        function closeAddonModal() {
            addonModal.classList.remove('active');
        }

        document.getElementById('closeAddonModalBtn').addEventListener('click', closeAddonModal);
        document.getElementById('cancelAddonBtn').addEventListener('click', closeAddonModal);

        document.getElementById('addonForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const addonId = document.getElementById('addonId').value;
            const url = addonId ? `/addons/${addonId}` : '/addons';
            const method = addonId ? 'PUT' : 'POST';

            const data = {
                name: document.getElementById('addonName').value,
                price: document.getElementById('addonPrice').value,
                inventory_item_id: document.getElementById('addonInventoryItem').value || null
            };

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });

        async function editAddon(id) {
            try {
                const response = await fetch(`/addons/${id}`);
                const result = await response.json();

                if (result.success) {
                    const addon = result.addon;
                    document.getElementById('addonModalTitle').textContent = 'Edit Add-on';
                    document.getElementById('addonId').value = addon.id;
                    document.getElementById('addonName').value = addon.name;
                    document.getElementById('addonPrice').value = addon.price;
                    document.getElementById('addonInventoryItem').value = addon.inventory_item_id || '';

                    addonModal.classList.add('active');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        async function deleteAddon(id) {
            if (!confirm('Are you sure you want to delete this add-on?')) return;

            try {
                const response = await fetch(`/addons/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // Close addon modal when clicking outside
        addonModal.addEventListener('click', (e) => {
            if (e.target === addonModal) closeAddonModal();
        });

        const modal = document.getElementById('itemModal');
        const restockModal = document.getElementById('restockModal');
        let currentRestockItem = null;

        function formatNumberToDisplay(num) {
            // Keep two decimals of precision but remove trailing zeros (e.g. 6.00 -> "6", 6.50 -> "6.5")
            return Number(parseFloat(num).toFixed(2)).toString();
        }

        // Open add item modal
        document.getElementById('addItemBtn').addEventListener('click', () => {
            document.getElementById('modalTitle').textContent = 'Add New Item';
            document.getElementById('itemForm').reset();
            document.getElementById('itemId').value = '';
            modal.classList.add('active');
        });

        // Close modals
        function closeModals() {
            modal.classList.remove('active');
            restockModal.classList.remove('active');
        }

        document.getElementById('closeModal').addEventListener('click', closeModals);
        document.getElementById('closeRestockModal').addEventListener('click', closeModals);
        document.getElementById('cancelBtn').addEventListener('click', closeModals);
        document.getElementById('cancelRestockBtn').addEventListener('click', closeModals);

        // Submit item form (Add/Edit)
        document.getElementById('itemForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const itemId = document.getElementById('itemId').value;
            const url = itemId ? `/inventory/${itemId}` : '/inventory';
            const method = itemId ? 'PUT' : 'POST';

            const data = {
                name: document.getElementById('itemName').value,
                category: document.getElementById('itemCategory').value,
                quantity: document.getElementById('itemQuantity').value,
                unit: document.getElementById('itemUnit').value,
                min_stock: document.getElementById('itemMinStock').value,
                unit_price: document.getElementById('itemPrice').value,
                supplier: document.getElementById('itemSupplier').value
            };

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });

        // Edit item
        async function editItem(id) {
            try {
                const response = await fetch(`/inventory/${id}/get`);
                const result = await response.json();
                
                if (result.success) {
                    const item = result.item;
                    document.getElementById('modalTitle').textContent = 'Edit Item';
                    document.getElementById('itemId').value = item.id;
                    document.getElementById('itemName').value = item.name;
                    document.getElementById('itemCategory').value = item.category;
                    document.getElementById('itemQuantity').value = formatNumberToDisplay(item.quantity);
                    document.getElementById('itemUnit').value = item.unit;
                    document.getElementById('itemMinStock').value = formatNumberToDisplay(item.min_stock);
                    document.getElementById('itemPrice').value = formatNumberToDisplay(item.unit_price);
                    document.getElementById('itemSupplier').value = item.supplier || '';
                    
                    modal.classList.add('active');
                }
            } catch (error) {
                alert('Error loading item: ' + error.message);
            }
        }

        // Delete item
        async function deleteItem(id) {
            if (!confirm('Are you sure you want to delete this item?')) return;

            try {
                const response = await fetch(`/inventory/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // Open restock modal
        async function openRestockModal(id) {
            try {
                const response = await fetch(`/inventory/${id}/get`);
                const result = await response.json();
                
                if (result.success) {
                    currentRestockItem = result.item;
                    document.getElementById('restockItemId').value = id;
                    document.getElementById('currentQuantity').value = `${formatNumberToDisplay(currentRestockItem.quantity)} ${currentRestockItem.unit}`;
                    document.getElementById('addQuantity').value = '';
                    document.getElementById('newTotal').value = `${formatNumberToDisplay(currentRestockItem.quantity)} ${currentRestockItem.unit}`;
                    
                    restockModal.classList.add('active');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        // Update new total when adding quantity
        document.getElementById('addQuantity').addEventListener('input', (e) => {
            if (!currentRestockItem) return;

            const addQty = parseFloat(e.target.value) || 0;
            const newTotal = parseFloat(currentRestockItem.quantity) + addQty;
            document.getElementById('newTotal').value = `${formatNumberToDisplay(newTotal)} ${currentRestockItem.unit}`;
        });

        // Submit restock form
        document.getElementById('restockForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const itemId = document.getElementById('restockItemId').value;
            const addQty = document.getElementById('addQuantity').value;

            try {
                const response = await fetch(`/inventory/${itemId}/restock`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ add_quantity: addQty })
                });

                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });

        // Bulk restock
        document.getElementById('restockBtn').addEventListener('click', async () => {
            if (!confirm('Restock all low/out of stock items to minimum levels?')) return;

            try {
                const response = await fetch('/inventory/bulk-restock', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });

        // Search and filters (client-side for now - can be made server-side)
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('categoryFilter').addEventListener('change', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryValue = document.getElementById('categoryFilter').value;
            const statusValue = document.getElementById('statusFilter').value;
            
            const rows = document.querySelectorAll('#inventoryTableBody tr[data-item-id]');
            
            rows.forEach(row => {
                const itemName = row.querySelector('.item-name')?.textContent.toLowerCase() || '';
                const itemSupplier = row.querySelector('.item-category')?.textContent.toLowerCase() || '';
                const itemCategory = row.querySelectorAll('td')[1]?.textContent.toLowerCase() || '';
                const statusBadge = row.querySelector('.status-badge')?.classList;
                
                const matchesSearch = itemName.includes(searchTerm) || itemSupplier.includes(searchTerm);
                const matchesCategory = categoryValue === 'all' || itemCategory === categoryValue;
                
                let matchesStatus = true;
                if (statusValue !== 'all') {
                    matchesStatus = statusBadge?.contains('status-' + statusValue);
                }
                
                if (matchesSearch && matchesCategory && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Close modals when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModals();
        });

        restockModal.addEventListener('click', (e) => {
            if (e.target === restockModal) closeModals();
        });

        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Show the selected tab content
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }

            // Mark the clicked button as active
            event.target.classList.add('active');
        }
    </script>
</x-app-layout>