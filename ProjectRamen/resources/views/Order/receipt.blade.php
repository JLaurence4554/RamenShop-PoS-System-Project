<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
      @media print {
          body {
              background: white !important;
          }

          .receipt-container {
              box-shadow: none !important;
              border: none !important;
              margin: 0 auto;
              width: 300px; 
          }

          .button-group {
              display: none !important; 
          }

          .receipt-container * {
              color: black !important;
              -webkit-print-color-adjust: exact;
              print-color-adjust: exact;
          }
      }

        body {
            font-family: "Courier New", monospace;
            background-color: #1e293b; 
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }

        .receipt-container {
            background-color: white;
            width: 3in;
            padding: 35px 24px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            min-height: 480px; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .receipt-header {
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 8px;
            letter-spacing: 1px;
            line-height: 1.3;
        }

        .receipt-subheader {
            font-size: 0.8rem;
            margin-bottom: 16px;
            line-height: 1.6;
            color: #333;
        }

        .divider {
            border-top: 2px dashed #333;
            margin: 14px 0;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.95rem;
            margin: 16px 0;
            font-weight: 500;
        }

        .items {
            text-align: left;
            font-size: 0.9rem;
            margin: 0 0 24px 0;
        }

        .item-row {
            margin-bottom: 14px;
            padding: 8px;
            background-color: #f9fafb;
            border-radius: 6px;
        }

        .item-main {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .item-customization {
            font-size: 0.78rem;
            color: #555;
            margin-left: 8px;
            line-height: 1.5;
            padding-left: 12px;
            border-left: 2px solid #d1d5db;
        }

        .customization-line {
            margin-bottom: 3px;
        }

        .total {
            font-weight: bold;
            font-size: 1rem;
            text-align: right;
            margin-top: 10px;
        }

        .receipt-image {
            text-align: center;
        }

        .receipt-image img {
            width: 70%;
            max-width: 180px;
            margin: 15px 0 10px 0;
            height: auto;
            opacity: 1;
        }

        .footer {
            font-size: 0.9rem;
            font-weight: bold;
            margin-top: 8px;
        }

        .button-group {
            margin-top: 18px;
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 22px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-cancel {
            background-color: #9ca3af;
            color: white;
        }

        .btn-print {
            background-color: #16a34a;
            color: white;
        }

        .btn-cancel:hover { background-color: #6b7280; }
        .btn-print:hover { background-color: #15803d; }

    </style>
</head>
<body>

    <div class="receipt-container">
        <div>
            <div class="receipt-header">Sakura Street <br>
                      Ramen</div>
            <div class="receipt-subheader">
                Purok-6, <br>Pandan Ligao City, Albay<br>
                contact: 09917725231
            </div>

            <div class="divider"></div>
            <div style="font-size: 1.9rem; font-weight: bold; margin-bottom: 6px; letter-spacing: 2px;">{{ request('orderType') }}</div>
            <div class="divider"></div>

            <div class="receipt-info">
                <span>{{ now()->format('d-m-Y') }}</span>
                <span>{{ now()->format('H:i') }}</span>
            </div>

            <div class="divider"></div>

            <div class="items">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-weight: 700; font-size: 0.95rem; border-bottom: 2px solid #333; padding-bottom: 6px;">
                    <strong>Item</strong>
                    <strong>Price</strong>
                </div>
                
                @php
                    $orders = json_decode(request('orders'), true);
                @endphp
                
                @foreach ($orders as $order)
                    <div class="item-row">
                        <div class="item-main">
                            <span>{{ $order['name'] }} x{{ $order['qty'] }}</span>
                            <span>₱{{ number_format($order['totalPrice'] * $order['qty'], 2) }}</span>
                        </div>
                        
                        @if(isset($order['customization']))
                            <div class="item-customization">
                                <div class="customization-line">
                                    Spicy: Lvl {{ $order['customization']['spicyLevel'] }}
                                </div>
                                <div class="customization-line">
                                    Garlic: {{ ucfirst($order['customization']['garlicLevel']) }}
                                </div>
                                <div class="customization-line">
                                    Onion: {{ ucfirst($order['customization']['onionLevel']) }}
                                </div>
                                
                                @if(isset($order['customization']['addOns']) && count($order['customization']['addOns']) > 0)
                                    <div class="customization-line">
                                        Add-ons:
                                        @php
                                            $addOnsNames = [
                                                'egg' => 'Soft-Boiled Egg',
                                                'chashu' => 'Extra Chashu',
                                                'nori' => 'Extra Nori',
                                                'corn' => 'Corn',
                                                'bamboo' => 'Bamboo Shoots',
                                                'veggie' => 'Extra Vegetables'
                                            ];
                                            $addonsList = array_map(function($addon) use ($addOnsNames) {
                                                return $addOnsNames[$addon['id']] ?? $addon['id'];
                                            }, $order['customization']['addOns']);
                                        @endphp
                                        {{ implode(', ', $addonsList) }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="divider"></div>

            <div class="receipt-info" style="background-color: #f3f4f6; padding: 12px; border-radius: 8px; font-size: 1.1rem;">
                <strong>TOTAL</strong>
                <strong>₱{{ number_format(request('total'), 2) }}</strong>
            </div>
        </div>

        <div class="receipt-image">
            <img src="{{ asset('images/thankyou.jpg') }}" alt="Logo">
        </div>

        <div class="footer">Thank You and Come Again</div>
    </div>

    <div class="button-group">
        <button class="btn btn-cancel" onclick="cancelReceipt()">Cancel</button>
        <button class="btn btn-print" onclick="doneAndPrint()">Done</button>
    </div>

    <script>
        function cancelReceipt() {
            if (confirm('Are you sure you want to cancel this receipt?')) {
                window.location.href = "{{ route('order.order') }}";
            }
        }

        function doneAndPrint() {
            // Automatically print
            window.print();
            
            // Redirect after print dialog closes or after a short delay
            setTimeout(() => {
                window.location.href = "{{ route('order.order') }}";
            }, 1000);
        }

        // Optional: Auto-print on page load
        // Uncomment the line below if you want the receipt to print immediately when the page loads
        // window.onload = function() { window.print(); };
    </script>

</body>
</html>