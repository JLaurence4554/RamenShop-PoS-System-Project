<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Take Order') }}
        </h2>
    </x-slot>

    <style>
        .page-wrapper {
            padding: 24px;
            background-color: #1f2937; 
            color: white;
            min-height: 80vh;
            display: flex;
            gap: 16px;
        }

        .menu-section {
            flex: 1;
            background-color: #374151; 
            padding: 16px;
            border-radius: 10px;
        }

        .menu-section .button-group {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .menu-section button {
            background-color: #6b7280; 
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .menu-section button:hover {
            background-color: #4b5563; 
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 12px;
        }

        .product-grid button {
            background-color: #f9fafb;
            color: #111;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .product-grid button:hover {
            background-color: #e5e7eb; 
        }

        .addons-btn {
            margin-top: 16px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .order-section {
            width: 33%;
            background-color: #111827; 
            padding: 16px;
            border-radius: 10px;
        }

        .order-section h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .order-type {
            color: #d1d5db; 
            font-style: italic;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #374151;
            padding: 8px;
            border-radius: 6px;
        }

        .order-item button {
            background-color: #6b7280;
            border: none;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
        }

        .order-item button:hover {
            background-color: #4b5563;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 16px;
            margin-bottom: 12px;
        }

        .done-btn {
            background-color: #2563eb;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-weight: 500;
            transition: 0.2s;
        }

        .done-btn:hover {
            background-color: #1d4ed8;
        }

        .product-grid button {
            background-color: #f9fafb;
            color: #111;
            font-weight: 600;
            padding: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .product-grid button:hover {
            background-color: #e5e7eb;
        }

        .product-img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #ccc;
            background: #f3f4f6;
        }

        .no-image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            background: #d1d5db;
            color: #4b5563;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .product-name {
            font-size: 0.95rem;
        }

        .product-price {
            font-size: 0.85rem;
            color: #4b5563;
        }

    </style>

    <div class="page-wrapper">
        <!-- LEFT: Menu Section -->
        <div class="menu-section">
            <div class="button-group">
                <button id="dineInBtn">Dine in</button>
                <button id="takeOutBtn">Take out</button>
            </div>

            <div class="product-grid">
            @foreach ($products as $product)
                <button 
                    class="item-btn"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}">
                    
                    @if($product->image)
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="product-img">
                    @else
                        <div class="no-image">No Image</div>
                    @endif

                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">₱{{ number_format($product->price, 2) }}</div>
                </button>
            @endforeach
            </div>


            <button class="addons-btn">Add-ons</button>
        </div>

        <!-- RIGHT: Order Detail -->
        <div class="order-section">
            <h3>Order Detail:</h3>
            <div id="orderType" class="order-type">Select order type</div>

            <div id="orderList" class="space-y-2"></div>
            <hr class="my-3 border-gray-700">

            <div class="total-line">
                <span>Total:</span>
                <span id="orderTotal">₱0</span>
            </div>

            <button id="doneBtn" class="done-btn">Done</button>
        </div>
    </div>

    <script>
        const dineInBtn = document.getElementById('dineInBtn');
        const takeOutBtn = document.getElementById('takeOutBtn');
        const orderTypeDisplay = document.getElementById('orderType');
        const buttons = document.querySelectorAll('.item-btn');
        const orderList = document.getElementById('orderList');
        const orderTotal = document.getElementById('orderTotal');
        const doneBtn = document.getElementById('doneBtn');

        let orders = {};
        let orderType = '';

        dineInBtn.addEventListener('click', () => setOrderType('Dine In'));
        takeOutBtn.addEventListener('click', () => setOrderType('Take Out'));

        function setOrderType(type) {
            orderType = type;
            orderTypeDisplay.textContent = `${type}`;
            orders = {};
            renderOrders();
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!orderType) {
                    alert('Please select Dine In or Take Out first!');
                    return;
                }

                const name = btn.dataset.name;
                const price = parseFloat(btn.dataset.price);

                if (!orders[name]) {
                    orders[name] = { qty: 1, price };
                } else {
                    orders[name].qty += 1;
                }

                renderOrders();
            });
        });

        function renderOrders() {
            orderList.innerHTML = '';
            let total = 0;

            for (const [name, item] of Object.entries(orders)) {
                const div = document.createElement('div');
                div.className = 'order-item';
                div.innerHTML = `
                    <span>${name}</span>
                    <div class="flex items-center gap-2">
                        <button onclick="changeQty('${name}', -1)">-</button>
                        <span>${item.qty}</span>
                        <button onclick="changeQty('${name}', 1)">+</button>
                        <span>₱${item.price * item.qty}</span>
                    </div>
                `;
                orderList.appendChild(div);
                total += item.price * item.qty;
            }

            orderTotal.textContent = `₱${total}`;
        }

        function changeQty(name, delta) {
            orders[name].qty += delta;
            if (orders[name].qty <= 0) delete orders[name];
            renderOrders();
        }

        doneBtn.addEventListener('click', () => {
            if (!orderType || Object.keys(orders).length === 0) {
                alert('Please select order type and add items first!');
                return;
            }

            let total = 0;
            let ordered = 0;
            for (const item of Object.values(orders)) {
                total += item.price * item.qty;
                ordered += item.qty;
            }

            let summary = Object.entries(orders)
                .map(([name, item]) => `${name} x${item.qty} = ₱${(item.qty * item.price).toFixed(2)}`)
                .join('\n');

            alert(`✅ ${orderType}\n\n${summary}\n\nTotal: ₱${total.toFixed(2)}`);

            fetch("{{ route('save.sale') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ordered, full_salary: total })
            })
            .then(res => res.json())
            .then(data => {
                alert("Ordered Successfully!");
                orders = {};
                renderOrders();
            })
            .catch(err => alert("Error saving sale: " + err));
        });

    </script>
</x-app-layout>
