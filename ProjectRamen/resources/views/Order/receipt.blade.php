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
            height: 100vh;
            margin: 0;
        }

        .receipt-container {
            background-color: white;
            width: 300px;
            padding: 30px 16px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
            min-height: 480px; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .receipt-header {
            font-weight: bold;
            font-size: 1.46rem;
            margin-bottom: 4px;
        }

        .receipt-subheader {
            font-size: 0.75rem;
            margin-bottom: 12px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin: 15px 0;
        }

        .items {
            text-align: left;
            font-size: 0.9rem;
            margin: 0 0 30px 0;
        }

        .items div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
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
            width: 80%;
            max-width: 200px;
            margin: 15px 0 0 0;
            height: auto;
            opacity: 0.9;
        }

        .footer {
            font-size: 0.85rem;
            font-weight: bold;
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
            <div style="font-size: 1.7rem; font-weight: bold; margin-bottom: 6px;">{{ request('orderType') }}</div>
            <div class="divider"></div>

            <div class="receipt-info">
                <span>{{ now()->format('d-m-Y') }}</span>
                <span>{{ now()->format('H:i') }}</span>
            </div>

            <div class="divider"></div>

            <div class="items">
                <div><strong>Item</strong> <strong>Peice</strong></div>
                @php
                    $orders = json_decode(request('orders'), true);
                @endphp
                @foreach ($orders as $order)
                    <div>
                        <span>{{ $order['name'] }} x{{ $order['qty'] }}</span>
                        <span>₱{{ number_format($order['price'] * $order['qty'], 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="divider"></div>

            <div class="receipt-info">
                <strong>Total</strong>
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
            window.location.href = "{{ route('order.order') }}";
        }

        function doneAndPrint() {
            window.print();
            setTimeout(() => {
                window.location.href = "{{ route('order.order') }}";
            }, 1500);
        }
    </script>

</body>
</html>
