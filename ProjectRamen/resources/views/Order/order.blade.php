<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Take Order') }}
        </h2>
    </x-slot>

    <style>
        .page-wrapper {
            padding: 20px;
            color: white;
            min-height: 100vh;
            display: flex;
            gap: 20px;
        }

        .menu-section {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .order-type-header {
            background: #0436a1ff;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .order-type-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            text-align: center;
        }

        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .order-type-btn {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 14px 20px;
            border-radius: 10px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .order-type-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .order-type-btn.active {
            background: white;
            color: #2563eb;
            border-color: white;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
        }

        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .menu-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .product-card {
            background: white;
            color: #1f2937;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
            border: 3px solid transparent;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            border-color: #3b82f6;
        }

        .product-img-container {
            width: 100%;
            height: 140px;
            overflow: hidden;
            background: #f3f4f6;
            position: relative;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .product-info {
            padding: 12px;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #1f2937;
        }

        .product-price {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2563eb;
        }

        .order-section {
            width: 380px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 140px);
        }

        .order-header {
            background: #059669;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            text-align: center;
        }

        .order-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .order-type-display {
            font-size: 0.9rem;
            opacity: 0.9;
            font-style: italic;
        }

        .order-items-container {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 16px;
            padding-right: 4px;
        }

        .order-items-container::-webkit-scrollbar {
            width: 6px;
        }

        .order-items-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .order-items-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .empty-order {
            text-align: center;
            padding: 40px 20px;
            color: rgba(255, 255, 255, 0.5);
        }

        .empty-order-icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }

        .order-item {
            background: rgba(255, 255, 255, 0.08);
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
        }

        .order-item:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .order-item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .order-item-name {
            font-weight: 700;
            font-size: 1rem;
            flex: 1;
        }

        .order-item-base-price {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-left: 8px;
        }

        .order-item-details {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 10px;
            line-height: 1.6;
            background: rgba(0, 0, 0, 0.2);
            padding: 8px;
            border-radius: 6px;
        }

        .order-item-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 10px;
            border-radius: 8px;
        }

        .qty-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .qty-display {
            min-width: 30px;
            text-align: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .item-price-delete {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .item-total-price {
            font-weight: 700;
            font-size: 1.1rem;
            color: #10b981;
        }

        .delete-btn {
            background: #dc2626;
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 700;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-btn:hover {
            background: #b91c1c;
            transform: scale(1.1);
        }

        .order-summary {
            background: rgba(0, 0, 0, 0.3);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .summary-row.total {
            font-size: 1.3rem;
            font-weight: 700;
            padding-top: 12px;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
            margin-top: 8px;
            color: #10b981;
        }

        .done-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            width: 100%;
            cursor: pointer;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .done-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5);
        }

        .done-btn:disabled {
            background: rgba(107, 114, 128, 0.5);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
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
            max-width: 650px;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        .customization-section {
            margin-bottom: 24px;
            background: rgba(255, 255, 255, 0.05);
            padding: 16px;
            border-radius: 12px;
        }

        .customization-section label {
            display: block;
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 1.05rem;
        }

        .level-buttons {
            display: flex;
            gap: 10px;
        }

        .level-btn {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: capitalize;
            font-weight: 600;
        }

        .level-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .level-btn.active {
            background: #3b82f6;
            border-color: #60a5fa;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .level-btn.active.spicy {
            background: #ea580c;
            border-color: #fb923c;
            box-shadow: 0 4px 12px rgba(234, 88, 12, 0.4);
        }

        .addon-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .addon-btn {
            padding: 14px;
            border-radius: 10px;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
        }

        .addon-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .addon-btn.active {
            background: #10b981;
            border-color: #34d399;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .addon-name {
            font-weight: 700;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .addon-price {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .modal-footer {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px solid rgba(255, 255, 255, 0.1);
        }

        .modal-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 16px;
            color: #10b981;
        }

        .confirm-btn {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .confirm-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
        }

        @media (max-width: 1200px) {
            .page-wrapper {
                flex-direction: column;
            }

            .order-section {
                width: 100%;
                max-height: 500px;
            }
        }
    </style>

    <div class="page-wrapper">
        <!-- LEFT: Menu Section -->
        <div class="menu-section">
            <div class="order-type-header">
                <h3>🍜 Select Order Type</h3>
                <div class="button-group">
                    <button class="order-type-btn" id="dineInBtn">
                        🪑 Dine In
                    </button>
                    <button class="order-type-btn" id="takeOutBtn">
                        🥡 Take Out
                    </button>
                </div>
            </div>

            <div class="menu-header">
                <h3>📋 Menu</h3>
            </div>

            <div class="product-grid">
            @foreach ($products as $product)
                <button 
                    class="product-card"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}">
                    
                    <div class="product-img-container">
                        @if($product->image)
                            <img 
                                src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="product-img">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </div>

                    <div class="product-info">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                    </div>
                </button>
            @endforeach
            </div>
        </div>

        <!-- RIGHT: Order Detail -->
        <div class="order-section">
            <div class="order-header">
                <h3>Order Details</h3>
                <div id="orderTypeDisplay" class="order-type-display">Please select order type</div>
            </div>

            <div class="order-items-container" id="orderItemsContainer">
                <div class="empty-order">
                    <div class="empty-order-icon">🍜</div>
                    <div>No items added yet</div>
                </div>
            </div>

            <div class="order-summary">
                <div class="summary-row">
                    <span>Items:</span>
                    <span id="itemCount">0</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span id="orderTotal">₱0.00</span>
                </div>
            </div>

            <button id="doneBtn" class="done-btn" disabled>
                ✓ Complete Order
            </button>
        </div>
    </div>

    <!-- Customization Modal -->
    <div id="customizationModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Customize Order</h2>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>

            <!-- Spicy Level -->
            <div class="customization-section">
                <label>🌶️ Spicy Level (1-5)</label>
                <div class="level-buttons">
                    <button class="level-btn spicy" data-level="1">1</button>
                    <button class="level-btn spicy" data-level="2">2</button>
                    <button class="level-btn spicy" data-level="3">3</button>
                    <button class="level-btn spicy" data-level="4">4</button>
                    <button class="level-btn spicy" data-level="5">5</button>
                </div>
            </div>

            <!-- Garlic Level -->
            <div class="customization-section">
                <label>🧄 Garlic Level</label>
                <div class="level-buttons">
                    <button class="level-btn garlic-btn" data-garlic="none">None</button>
                    <button class="level-btn garlic-btn" data-garlic="normal">Normal</button>
                    <button class="level-btn garlic-btn" data-garlic="extra">Extra</button>
                </div>
            </div>

            <!-- Onion Level -->
            <div class="customization-section">
                <label>🧅 Onion Level</label>
                <div class="level-buttons">
                    <button class="level-btn onion-btn" data-onion="none">None</button>
                    <button class="level-btn onion-btn" data-onion="normal">Normal</button>
                    <button class="level-btn onion-btn" data-onion="extra">Extra</button>
                </div>
            </div>

            <!-- Add-ons -->
            <div class="customization-section">
                <label>➕ Add-ons (Optional)</label>
                <div class="addon-grid">
                    @forelse($addons ?? [] as $addon)
                    <button class="addon-btn" data-addon-id="{{ $addon->id }}" data-addon="{{ strtolower(str_replace(' ', '-', $addon->name)) }}" data-price="{{ $addon->price }}">
                        <div class="addon-name">{{ $addon->name }}</div>
                        <div class="addon-price">+₱{{ number_format($addon->price, 2) }}</div>
                    </button>
                    @empty
                    <p style="color: #999;">No add-ons available</p>
                    @endforelse
                </div>
            </div>

            <div class="modal-footer">
                <div class="modal-total">
                    <span>Item Total:</span>
                    <span id="modalTotal">₱0.00</span>
                </div>
                <button class="confirm-btn" id="confirmCustomization">Add to Order</button>
            </div>
        </div>
    </div>

    <script>
        const dineInBtn = document.getElementById('dineInBtn');
        const takeOutBtn = document.getElementById('takeOutBtn');
        const orderTypeDisplay = document.getElementById('orderTypeDisplay');
        const itemButtons = document.querySelectorAll('.product-card');
        const orderItemsContainer = document.getElementById('orderItemsContainer');
        const orderTotal = document.getElementById('orderTotal');
        const itemCount = document.getElementById('itemCount');
        const doneBtn = document.getElementById('doneBtn');

        // Modal elements
        const modal = document.getElementById('customizationModal');
        const modalTitle = document.getElementById('modalTitle');
        const closeModal = document.getElementById('closeModal');
        const confirmBtn = document.getElementById('confirmCustomization');
        const modalTotal = document.getElementById('modalTotal');

        let orders = [];
        let orderType = '';
        let currentProduct = null;
        let currentCustomization = {
            spicyLevel: 1,
            garlicLevel: 'normal',
            onionLevel: 'normal',
            addOns: []
        };

        // Add-ons data from database
        const addOnsData = {
            @forelse($addons ?? [] as $addon)
            '{{ $addon->id }}': { name: '{{ $addon->name }}', price: {{ $addon->price }} },
            @empty
            @endforelse
        };

        dineInBtn.addEventListener('click', () => setOrderType('Dine In', dineInBtn));
        takeOutBtn.addEventListener('click', () => setOrderType('Take Out', takeOutBtn));

        function setOrderType(type, btn) {
            orderType = type;
            orderTypeDisplay.textContent = type;
            
            // Update button states
            dineInBtn.classList.remove('active');
            takeOutBtn.classList.remove('active');
            btn.classList.add('active');
            
            orders = [];
            renderOrders();
        }

        // Open modal when clicking product
        itemButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!orderType) {
                    alert('Please select Dine In or Take Out first!');
                    return;
                }

                currentProduct = {
                    id: parseInt(btn.dataset.id),
                    name: btn.dataset.name,
                    price: parseFloat(btn.dataset.price)
                };

                // Reset customization
                currentCustomization = {
                    spicyLevel: 1,
                    garlicLevel: 'normal',
                    onionLevel: 'normal',
                    addOns: []
                };

                openModal();
            });
        });

        function openModal() {
            modalTitle.textContent = `Customize ${currentProduct.name}`;
            
            // Reset all buttons
            document.querySelectorAll('.level-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.addon-btn').forEach(btn => btn.classList.remove('active'));

            // Set default selections
            document.querySelector(`.level-btn.spicy[data-level="1"]`).classList.add('active');
            document.querySelector(`.garlic-btn[data-garlic="normal"]`).classList.add('active');
            document.querySelector(`.onion-btn[data-onion="normal"]`).classList.add('active');

            updateModalTotal();
            modal.classList.add('active');
        }

        closeModal.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        // Spicy level buttons
        document.querySelectorAll('.level-btn.spicy').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.level-btn.spicy').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentCustomization.spicyLevel = parseInt(btn.dataset.level);
                updateModalTotal();
            });
        });

        // Garlic level buttons
        document.querySelectorAll('.garlic-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.garlic-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentCustomization.garlicLevel = btn.dataset.garlic;
                updateModalTotal();
            });
        });

        // Onion level buttons
        document.querySelectorAll('.onion-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.onion-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentCustomization.onionLevel = btn.dataset.onion;
                updateModalTotal();
            });
        });

        // Add-on buttons
        document.querySelectorAll('.addon-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const addonId = btn.dataset.addonId;
                const addonPrice = parseFloat(btn.dataset.price);
                
                if (btn.classList.contains('active')) {
                    btn.classList.remove('active');
                    currentCustomization.addOns = currentCustomization.addOns.filter(a => a.id !== addonId);
                } else {
                    btn.classList.add('active');
                    currentCustomization.addOns.push({ id: addonId, price: addonPrice });
                }
                
                updateModalTotal();
            });
        });

        function updateModalTotal() {
            let total = currentProduct.price;
            currentCustomization.addOns.forEach(addon => {
                total += addon.price;
            });
            modalTotal.textContent = `₱${total.toFixed(2)}`;
        }

        confirmBtn.addEventListener('click', () => {
            const orderItem = {
                id: Date.now(),
                product_id: currentProduct.id,
                name: currentProduct.name,
                basePrice: currentProduct.price,
                customization: { ...currentCustomization, addOns: [...currentCustomization.addOns] },
                qty: 1
            };

            // Calculate item total with add-ons
            orderItem.totalPrice = orderItem.basePrice;
            orderItem.customization.addOns.forEach(addon => {
                orderItem.totalPrice += addon.price;
            });

            orders.push(orderItem);
            renderOrders();
            modal.classList.remove('active');
        });

        function renderOrders() {
            if (orders.length === 0) {
                orderItemsContainer.innerHTML = `
                    <div class="empty-order">
                        <div class="empty-order-icon">🍜</div>
                        <div>No items added yet</div>
                    </div>
                `;
                orderTotal.textContent = '₱0.00';
                itemCount.textContent = '0';
                doneBtn.disabled = true;
                return;
            }

            orderItemsContainer.innerHTML = '';
            let total = 0;
            let totalItems = 0;

            orders.forEach(item => {
                const div = document.createElement('div');
                div.className = 'order-item';
                
                // Build customization details
                let customDetails = `
                    🌶️ Spicy: Level ${item.customization.spicyLevel}<br>
                    🧄 Garlic: ${item.customization.garlicLevel}<br>
                    🧅 Onion: ${item.customization.onionLevel}
                `;
                
                if (item.customization.addOns.length > 0) {
                    const addonNames = item.customization.addOns.map(a => addOnsData[a.id].name).join(', ');
                    customDetails += `<br>➕ ${addonNames}`;
                }

                div.innerHTML = `
                    <div class="order-item-header">
                        <div class="order-item-name">${item.name}</div>
                        <div class="order-item-base-price">₱${item.basePrice.toFixed(2)}</div>
                    </div>
                    <div class="order-item-details">
                        ${customDetails}
                    </div>
                    <div class="order-item-controls">
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="changeQty(${item.id}, -1)">−</button>
                            <span class="qty-display">${item.qty}</span>
                            <button class="qty-btn" onclick="changeQty(${item.id}, 1)">+</button>
                        </div>
                        <div class="item-price-delete">
                            <span class="item-total-price">₱${(item.totalPrice * item.qty).toFixed(2)}</span>
                            <button class="delete-btn" onclick="deleteItem(${item.id})">×</button>
                        </div>
                    </div>
                `;
                orderItemsContainer.appendChild(div);
                total += item.totalPrice * item.qty;
                totalItems += item.qty;
            });

            orderTotal.textContent = `₱${total.toFixed(2)}`;
            itemCount.textContent = totalItems;
            doneBtn.disabled = false;
        }

        function changeQty(id, delta) {
            const item = orders.find(o => o.id === id);
            if (item) {
                item.qty += delta;
                if (item.qty <= 0) {
                    orders = orders.filter(o => o.id !== id);
                }
                renderOrders();
            }
        }

        function deleteItem(id) {
            orders = orders.filter(o => o.id !== id);
            renderOrders();
        }

        doneBtn.addEventListener('click', () => {
            if (!orderType || orders.length === 0) {
                alert('Please select order type and add items first!');
                return;
            }

            let total = 0;
            let ordered = 0;
            const items = [];
            
            orders.forEach(item => {
                total += item.totalPrice * item.qty;
                ordered += item.qty;
                items.push({
                    product_id: item.product_id,
                    quantity: item.qty,
                    price: item.basePrice,
                    subtotal: item.totalPrice * item.qty,
                    addons: item.customization.addOns || []
                });
            });

            // First, deduct inventory
            fetch("{{ route('orders.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ items, total })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Failed to process order');
                }

                // Then save the sale
                return fetch("{{ route('save.sale') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ ordered, full_salary: total })
                });
            })
            .then(res => res.json())
            .then(data => {
                alert("Order placed successfully!");

                const query = new URLSearchParams({
                    orders: JSON.stringify(orders.map(item => ({
                        name: item.name,
                        qty: item.qty,
                        price: item.basePrice,
                        totalPrice: item.totalPrice,
                        customization: {
                            spicyLevel: item.customization.spicyLevel,
                            garlicLevel: item.customization.garlicLevel,
                            onionLevel: item.customization.onionLevel,
                            addOns: item.customization.addOns.map(addon => ({
                                id: addon.id,
                                name: addOnsData[addon.id].name,
                                price: addon.price
                            }))
                        }
                    }))),
                    total,
                    orderType
                }).toString();

                window.location.href = `{{ route('receipt') }}?${query}`;

                orders = [];
                renderOrders();
            })
            .catch(err => alert("Error: " + err.message));
        });

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>
</x-app-layout>