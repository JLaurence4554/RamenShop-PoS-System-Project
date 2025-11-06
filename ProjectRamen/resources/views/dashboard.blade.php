<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <style>
        .dashboard-wrapper {
            background-color: rgba(26, 36, 49, 1);
            color: #fff;
            min-height: calc(100vh - 64px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 30px;
        }

        .welcome-title {
            font-size: 2.90rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .sales-container {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 35px; 
            background-color: #4B5563;
            border-radius: 16px;
            padding: 40px 60px; 
            max-width: 1300px; 
            width: 100%;
        }

        .sales-box {
            flex: 1;
            background-color: #6B7280;
            border-radius: 12px;
            padding: 30px;
        }

        .sales-divider {
            width: 4px; 
            background-color: #D1D5DB;
        }

        .sales-box h3 {
            font-size: 1.80rem; 
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid #D1D5DB;
            padding-bottom: 6px;
        }

        .sales-box p {
            font-size: 1.1rem; 
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }

        .label {
            color: #E5E7EB;
            font-size: 1.05rem; 
        }

        .value {
            color: #F9FAFB;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .history-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #4B5563;
            border-radius: 16px;
            padding: 40px 60px;
            max-width: 1300px;
            width: 100%;
            color: #fff;
        }
        .history-content {
            width: 100%;
            text-align: center;
        }
        .history-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        #orderDates {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 60%;
            margin: 0 auto;
        }
        .date-card {
            background-color: #6B7280;
            font-size: 1.3rem;
            color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .date-card:hover {
            background-color: #a0a2a5ff;
            transform: scale(1.03);
        }

        .day-orders {
            margin-top: 20px;
            color: black;
            background-color: #d1d3d4ff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: inset 3px 3px 6px rgba(0,0,0,0.4),
            3px 3px 6px rgba(0,0,0,0.2);
        }
        #ordersTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        #ordersTable th, #ordersTable td {
            padding: 8px;
            border-bottom: 1px solid #9CA3AF;
        }

        #ordersTable tbody tr {
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        #ordersTable tbody tr:hover {
            background-color: rgba(159, 162, 165, 0.8);
        }

        #backToDates {
            margin-top: 15px;
            background: #2563EB;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
        }
        
        #dayTitle {
            font-size: 1.5rem;
            font-weight: 700;
            color: #000000ff;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000000ff;
            padding-bottom: 8px;
            letter-spacing: 0.5px;
        }

        #backToDates:hover {
            background: #1E40AF;
        }

        @media (max-width: 768px) {
            .sales-container {
                flex-direction: column;
                padding: 20px;
            }
            .sales-divider {
                display: none;
            }
        }
    </style>

    <div class="dashboard-wrapper">
        <h1 class="welcome-title">Welcome Back, {{ Auth::user()->name }}!</h1>

        <div class="sales-container">
            <!-- Current Sale -->
            <div class="sales-box">
                <h3>Current Sale</h3>
                <p><span class="label">Ordered:</span> <span class="value">{{ $currentSale->ordered ?? 0 }}</span></p>
                <p><span class="label">Full Salary:</span> <span class="value">₱{{ number_format($currentSale->full_salary ?? 0, 2) }}</span></p>
            </div>

            <div class="sales-divider"></div>

            <!-- Last Sale -->
            <div class="sales-box">
                <h3>Last Sale</h3>
                <p><span class="label">Ordered:</span> <span class="value">{{ $lastSale->ordered ?? 0 }}</span></p>
                <p><span class="label">Full Salary:</span> <span class="value">₱{{ number_format($lastSale->full_salary ?? 0, 2) }}</span></p>
            </div>
        </div>
        <h1 class="history-title">Order History</h1>
        <div class="history-container">
            <div class="history-content">
                <div id="orderDates" class="order-dates"></div>

                <div id="dayOrders" class="day-orders" style="display:none;">
                    <h3 id="dayTitle"></h3>
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ordered</th>
                                <th>Full Salary</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button id="backToDates">Back</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const orderDatesContainer = document.getElementById('orderDates');
            const dayOrdersSection = document.getElementById('dayOrders');
            const dayTitle = document.getElementById('dayTitle');
            const ordersTableBody = document.querySelector('#ordersTable tbody');
            const backToDatesBtn = document.getElementById('backToDates');

            // Fetch all unique order dates
            const res = await fetch("{{ url('order-dates') }}");
            const dates = await res.json();

            // Populate history cards
            if (dates.length === 0) {
                orderDatesContainer.innerHTML = `<p>No order history yet.</p>`;
                return;
            }

            dates.forEach(d => {
                const div = document.createElement('div');
                const formatted = new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                div.textContent = formatted;
                div.className = 'date-card';
                div.addEventListener('click', () => showOrdersForDate(d.date, formatted));
                orderDatesContainer.appendChild(div);
            });

            async function showOrdersForDate(date, formatted) {
                const res = await fetch(`/sales/by-date/${date}`);
                const sales = await res.json();

                orderDatesContainer.style.display = 'none';
                dayOrdersSection.style.display = 'block';
                dayTitle.textContent = `Orders for ${formatted}`;
                ordersTableBody.innerHTML = '';

                if (sales.length === 0) {
                    ordersTableBody.innerHTML = '<tr><td colspan="4">No orders for this date</td></tr>';
                    return;
                }

                sales.forEach((sale, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${sale.ordered}</td>
                        <td>₱${parseFloat(sale.full_salary).toFixed(2)}</td>
                        <td>${new Date(sale.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</td>
                    `;
                    ordersTableBody.appendChild(row);
                });
            }

            // Back to date list
            backToDatesBtn.addEventListener('click', () => {
                dayOrdersSection.style.display = 'none';
                orderDatesContainer.style.display = 'grid';
            });
        });
        </script>
</x-app-layout>
