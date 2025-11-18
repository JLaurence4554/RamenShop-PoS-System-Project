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
            padding-bottom: 40px;
        }

        .welcome-title {
            font-size: 2rem;
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
            margin-bottom: 40px;
        }

        .sales-box {
            flex: 1;
            background-color: #6B7280;
            border-radius: 12px;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .sales-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
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
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        #orderDates {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
            width: 100%;
        }

        .date-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-size: 1.2rem;
            color: #fff;
            padding: 24px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }

        .date-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .date-card:hover::before {
            left: 100%;
        }

        .date-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }

        .date-card-date {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 8px;
        }

        .date-card-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .date-card-stat {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .date-card-stat-label {
            font-size: 0.75rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-card-stat-value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .day-orders {
            margin-top: 20px;
            color: #fff;
            background-color: #374151;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        #dayTitle {
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #60A5FA;
            padding-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .day-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background-color: #4B5563;
            padding: 16px;
            border-radius: 8px;
            text-align: center;
        }

        .summary-card-label {
            font-size: 0.85rem;
            color: #D1D5DB;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-card-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        #ordersTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #4B5563;
            border-radius: 8px;
            overflow: hidden;
        }

        #ordersTable thead {
            background-color: #374151;
        }

        #ordersTable th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #F9FAFB;
            border-bottom: 2px solid #60A5FA;
        }

        #ordersTable td {
            padding: 12px;
            border-bottom: 1px solid #6B7280;
            color: #E5E7EB;
        }

        #ordersTable tbody tr {
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        #ordersTable tbody tr:hover {
            background-color: #6B7280;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            justify-content: center;
        }

        #backToDates, #exportBtn {
            background: #2563EB;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
        }

        #backToDates:hover, #exportBtn:hover {
            background: #1D4ED8;
        }

        #exportBtn {
            background: #059669;
        }

        #exportBtn:hover {
            background: #047857;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #9CA3AF;
            font-size: 1.1rem;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #D1D5DB;
        }

        @media (max-width: 768px) {
            .sales-container {
                flex-direction: column;
                padding: 20px;
            }
            .sales-divider {
                display: none;
            }
            #orderDates {
                grid-template-columns: 1fr;
            }
            .day-summary {
                grid-template-columns: 1fr;
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

        <h1 class="history-title">📊 Order History</h1>
        <div class="history-container">
            <div class="history-content">
                <div id="orderDates" class="order-dates"></div>

                <div id="dayOrders" class="day-orders" style="display:none;">
                    <h3 id="dayTitle"></h3>
                    
                    <div class="day-summary" id="daySummary"></div>

                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Items Ordered</th>
                                <th>Total Amount</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="action-buttons">
                        <button id="backToDates">← Back to Dates</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const orderDatesContainer = document.getElementById('orderDates');
            const dayOrdersSection = document.getElementById('dayOrders');
            const dayTitle = document.getElementById('dayTitle');
            const daySummary = document.getElementById('daySummary');
            const ordersTableBody = document.querySelector('#ordersTable tbody');
            const backToDatesBtn = document.getElementById('backToDates');
            const exportBtn = document.getElementById('exportBtn');

            let currentDateData = null;

            // Show loading
            orderDatesContainer.innerHTML = '<div class="loading">Loading order history...</div>';

            // Fetch all unique order dates
            try {
                const res = await fetch("{{ url('order-dates') }}");
                const dates = await res.json();

                orderDatesContainer.innerHTML = '';

                // Populate history cards
                if (dates.length === 0) {
                    orderDatesContainer.innerHTML = `<div class="no-data">📭 No order history yet.</div>`;
                    return;
                }

                // Fetch detailed stats for each date
                for (const d of dates) {
                    const statsRes = await fetch(`/sales/by-date/${d.date}`);
                    const sales = await statsRes.json();
                    
                    const totalOrdered = sales.reduce((sum, sale) => sum + parseInt(sale.ordered), 0);
                    const totalSalary = sales.reduce((sum, sale) => sum + parseFloat(sale.full_salary), 0);
                    const totalTransactions = sales.length;

                    const div = document.createElement('div');
                    const formatted = new Date(d.date).toLocaleDateString('en-US', { 
                        weekday: 'short',
                        month: 'short', 
                        day: 'numeric', 
                        year: 'numeric' 
                    });
                    
                    div.className = 'date-card';
                    div.innerHTML = `
                        <div class="date-card-date">📅 ${formatted}</div>
                        <div class="date-card-stats">
                            <div class="date-card-stat">
                                <span class="date-card-stat-label">Transactions</span>
                                <span class="date-card-stat-value">${totalTransactions}</span>
                            </div>
                            <div class="date-card-stat">
                                <span class="date-card-stat-label">Items</span>
                                <span class="date-card-stat-value">${totalOrdered}</span>
                            </div>
                            <div class="date-card-stat">
                                <span class="date-card-stat-label">Revenue</span>
                                <span class="date-card-stat-value">₱${totalSalary.toFixed(0)}</span>
                            </div>
                        </div>
                    `;
                    
                    div.addEventListener('click', () => showOrdersForDate(d.date, formatted, sales));
                    orderDatesContainer.appendChild(div);
                }
            } catch (error) {
                orderDatesContainer.innerHTML = '<div class="no-data">❌ Error loading order history</div>';
                console.error('Error:', error);
            }

            function showOrdersForDate(date, formatted, sales) {
                currentDateData = { date, formatted, sales };

                orderDatesContainer.style.display = 'none';
                dayOrdersSection.style.display = 'block';
                dayTitle.textContent = `Orders for ${formatted}`;
                
                // Calculate summary stats
                const totalOrdered = sales.reduce((sum, sale) => sum + parseInt(sale.ordered), 0);
                const totalSalary = sales.reduce((sum, sale) => sum + parseFloat(sale.full_salary), 0);
                const totalTransactions = sales.length;
                const avgTransaction = totalTransactions > 0 ? totalSalary / totalTransactions : 0;

                // Display summary
                daySummary.innerHTML = `
                    <div class="summary-card">
                        <div class="summary-card-label">Total Transactions</div>
                        <div class="summary-card-value">${totalTransactions}</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-label">Total Items</div>
                        <div class="summary-card-value">${totalOrdered}</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-label">Total Revenue</div>
                        <div class="summary-card-value">₱${totalSalary.toFixed(2)}</div>
                    </div>
                `;

                // Populate orders table
                ordersTableBody.innerHTML = '';

                if (sales.length === 0) {
                    ordersTableBody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No orders for this date</td></tr>';
                    return;
                }

                sales.forEach((sale, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td><strong>${sale.ordered}</strong> items</td>
                        <td><strong>₱${parseFloat(sale.full_salary).toFixed(2)}</strong></td>
                        <td>${new Date(sale.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })}</td>
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