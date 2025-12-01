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
            align-items: flex-start;
            gap: 30px;
            background-color: #4B5563;
            border-radius: 16px;
            padding: 40px 60px;
            max-width: 1300px;
            width: 100%;
            color: #fff;
        }

        .history-content {
            flex: 1;
            text-align: center;
        }

        .top-sales-sidebar {
            width: 320px;
            background: linear-gradient(135deg, #2044a8ff 0%, #000000ff 100%);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            position: sticky;
            top: 20px;
        }

        .top-sales-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .top-sales-trophy {
            font-size: 1.8rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .top-sale-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 16px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .top-sale-rank {
            display: inline-block;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .top-sale-rank.first {
            background: linear-gradient(135deg, #fbbf24, #d97706);
            font-size: 1.2rem;
        }

        .top-sale-date {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #fef3c7;
        }

        .top-sale-stats {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .top-sale-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .top-sale-stat-label {
            color: #e0e7ff;
            opacity: 0.9;
        }

        .top-sale-stat-value {
            font-weight: 700;
            color: #fff;
            font-size: 1rem;
        }

        .top-sale-revenue {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: #fef3c7;
        }

        .no-top-sales {
            text-align: center;
            padding: 20px;
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
        }

        .history-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        #orderDates {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        /* Custom scrollbar */
        #orderDates::-webkit-scrollbar {
            width: 8px;
        }

        #orderDates::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 4px;
        }

        #orderDates::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 4px;
        }

        #orderDates::-webkit-scrollbar-thumb:hover {
            background: #764ba2;
        }

        .date-list-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 20px 24px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .date-list-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .date-list-item:hover::before {
            left: 100%;
        }

        .date-list-item:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.4);
        }

        .date-list-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .date-list-icon {
            font-size: 2rem;
        }

        .date-list-date {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .date-list-right {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .date-list-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .date-list-stat-label {
            font-size: 0.7rem;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-list-stat-value {
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
            table-layout: fixed;
        }

        #ordersTable thead {
            background-color: #374151;
        }

        #ordersTable th {
            padding: 12px;
            text-align: center;
            font-weight: 600;
            color: #F9FAFB;
            border-bottom: 2px solid #60A5FA;
            word-wrap: break-word;
        }

        #ordersTable th:first-child {
            width: 8%;
            text-align: center;
        }

        #ordersTable th:nth-child(2) {
            width: 27%;
            text-align: center;
        }

        #ordersTable th:nth-child(3) {
            width: 30%;
            text-align: center;
        }

        #ordersTable th:nth-child(4) {
            width: 35%;
            text-align: center;
        }

        #ordersTable td {
            padding: 12px;
            border-bottom: 1px solid #6B7280;
            color: #E5E7EB;
            text-align: center;
            word-wrap: break-word;
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
            .history-container {
                flex-direction: column;
            }
            .top-sales-sidebar {
                width: 100%;
                position: static;
            }
            .date-list-item {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            .date-list-right {
                width: 100%;
                justify-content: space-around;
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

        @if(Auth::user()->role !== 'cashier')
        <h1 class="history-title">Order History</h1>
        <div class="history-container">
            <!-- Top Sales Sidebar - Admin Only -->
            @if(Auth::user()->role !== 'cashier')
            <div class="top-sales-sidebar" id="topSalesSidebar">
                <div class="top-sales-title">
                    <span>Top Sales Days</span>
                </div>
                <div id="topSalesContent">
                    <div class="loading">Loading top sales...</div>
                </div>
            </div>
            @endif

            <!-- Main History Content -->
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const orderDatesContainer = document.getElementById('orderDates');
            const dayOrdersSection = document.getElementById('dayOrders');
            const dayTitle = document.getElementById('dayTitle');
            const daySummary = document.getElementById('daySummary');
            const ordersTableBody = document.querySelector('#ordersTable tbody');
            const backToDatesBtn = document.getElementById('backToDates');
            const topSalesContent = document.getElementById('topSalesContent');

            let currentDateData = null;
            let allDatesData = [];

            // Show loading
            orderDatesContainer.innerHTML = '<div class="loading">Loading order history...</div>';

            // Fetch all unique order dates
            try {
                const res = await fetch("{{ url('order-dates') }}");
                
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                
                const dates = await res.json();

                orderDatesContainer.innerHTML = '';

                // Populate history list
                if (dates.length === 0) {
                    orderDatesContainer.innerHTML = `<div class="no-data">📭 No order history yet.</div>`;
                    if (topSalesContent) {
                        topSalesContent.innerHTML = '<div class="no-top-sales">No sales data yet</div>';
                    }
                    return;
                }

                // Fetch detailed stats for each date
                for (const d of dates) {
                    const statsRes = await fetch(`/sales/by-date/${d.date}`);
                    
                    if (!statsRes.ok) {
                        throw new Error(`Failed to fetch sales for ${d.date}`);
                    }
                    
                    const sales = await statsRes.json();
                    
                    const totalOrdered = sales.reduce((sum, sale) => sum + parseInt(sale.ordered), 0);
                    const totalSalary = sales.reduce((sum, sale) => sum + parseFloat(sale.full_salary), 0);
                    const totalTransactions = sales.length;

                    // Store data for top sales calculation
                    allDatesData.push({
                        date: d.date,
                        totalOrdered,
                        totalSalary,
                        totalTransactions
                    });

                    const div = document.createElement('div');
                    const formatted = new Date(d.date).toLocaleDateString('en-US', { 
                        weekday: 'short',
                        month: 'short', 
                        day: 'numeric', 
                        year: 'numeric' 
                    });
                    
                    div.className = 'date-list-item';
                    div.innerHTML = `
                        <div class="date-list-left">
                            <span class="date-list-icon">📅</span>
                            <span class="date-list-date">${formatted}</span>
                        </div>
                        <div class="date-list-right">
                            <div class="date-list-stat">
                                <span class="date-list-stat-label">Transactions</span>
                                <span class="date-list-stat-value">${totalTransactions}</span>
                            </div>
                            <div class="date-list-stat">
                                <span class="date-list-stat-label">Items</span>
                                <span class="date-list-stat-value">${totalOrdered}</span>
                            </div>
                            <div class="date-list-stat">
                                <span class="date-list-stat-label">Revenue</span>
                                <span class="date-list-stat-value">₱${totalSalary.toFixed(0)}</span>
                            </div>
                        </div>
                    `;
                    
                    div.addEventListener('click', () => showOrdersForDate(d.date, formatted, sales));
                    orderDatesContainer.appendChild(div);
                }

                // Display Top Sales
                displayTopSales();

            } catch (error) {
                console.error('Error details:', error);
                orderDatesContainer.innerHTML = '<div class="no-data">❌ Error loading order history: ' + error.message + '</div>';
                if (topSalesContent) {
                    topSalesContent.innerHTML = '<div class="no-top-sales">Error loading top sales</div>';
                }
            }

            function displayTopSales() {
                // Sort by revenue and get top 5
                const topSales = [...allDatesData]
                    .sort((a, b) => b.totalSalary - a.totalSalary)
                    .slice(0, 5);

                topSalesContent.innerHTML = '';

                if (topSales.length === 0) {
                    topSalesContent.innerHTML = '<div class="no-top-sales">No sales data available</div>';
                    return;
                }

                topSales.forEach((sale, index) => {
                    const formatted = new Date(sale.date).toLocaleDateString('en-US', { 
                        weekday: 'short',
                        month: 'short', 
                        day: 'numeric'
                    });

                    const card = document.createElement('div');
                    card.className = 'top-sale-card';
                    card.innerHTML = `
                        <div class="top-sale-rank ${index === 0 ? 'first' : ''}">${index + 1}</div>
                        <div class="top-sale-date">📅 ${formatted}</div>
                        <div class="top-sale-stats">
                            <div class="top-sale-stat">
                                <span class="top-sale-stat-label">Transactions:</span>
                                <span class="top-sale-stat-value">${sale.totalTransactions}</span>
                            </div>
                            <div class="top-sale-stat">
                                <span class="top-sale-stat-label">Items Sold:</span>
                                <span class="top-sale-stat-value">${sale.totalOrdered}</span>
                            </div>
                        </div>
                        <div class="top-sale-revenue">₱${sale.totalSalary.toFixed(2)}</div>
                    `;
                    topSalesContent.appendChild(card);
                });
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
                orderDatesContainer.style.display = 'flex';
            });
        });
    </script>
    @endif
</x-app-layout>