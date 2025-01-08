<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Reports</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding-inline: 20px;
            padding-block: 10px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-header {
            background-color: #4CAF50;
            color: white;
        }

        .table-footer {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
<header style="text-align: center; padding: 15px; border-bottom: 2px solid #e0e0e0; background-color: #f9f9f9;">
    <img src="http://ecommerce-cake-app.test/assets/image/logo-dreamdessert.webp" alt="Company Logo" style="width: 90px; margin-bottom: 10px;"/>
    <h1 style="font-size: 28px; color: #333; margin: 5px 0;">Laporan Performa Pemesanan Kue</h1>
    <p style="font-size: 16px; color: #666; margin: 5px 0;">Dibuat pada: <strong>{{$generated_at}}</strong></p>
    <p style="font-size: 14px; color: #666; margin: 5px 0;">Periode : {{$period}} <strong></strong></p>
    <div style="margin-top: 20px;">
        <hr style="border: 1px solid #e0e0e0;"/>
    </div>
</header>

<main style="margin-top: 20px;margin-bottom: 20px">
    <table>
        <thead>
        <tr class="table-header">
            <th>No</th>
            <th>Nama Kue</th>
            <th>Rasa Kue</th>
            <th>Topping Kue</th>
            <th>Ukuran Kue</th>
            <th>Kuantiti</th>
            <th>Harga</th>
            <th>Total Harga</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productPerformance as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product['cake_name'] }}</td>
                <td>{{ $product['cake_flavour'] }}</td>
                <td>{{ $product['cake_topping'] }}</td>
                <td>{{ $product['cake_size'] }}@if($product['cake_size'] != '-') <span>Cm</span> @endif</td>
                <td>{{ $product['quantity'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td>{{ $product['total_price'] }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr class="table-footer">
            <td colspan="8">Total Pendapatan: {{ $totalRevenue }}</td>
        </tr>
        <tr class="table-footer">
            <td colspan="8">Kue Terbanyak Dipesan: {{ $bestSellingProduct['cake'] }} ({{$bestSellingProduct['total_sold']}} Pcs)</td>
        </tr>
        <tr class="table-footer">
            <td colspan="8">Kue Tersedikit Dipesan: {{ $worstSellingProduct['cake'] }} ({{$worstSellingProduct['total_sold']}} Pcs)</td>
        </tr>
        </tfoot>
    </table>
</main>

<footer style="text-align: center; padding: 20px; border-top: 2px solid #e0e0e0; background-color: #f9f9f9">
    <p style="font-size: 14px; color: #666; margin: 5px 0;">&copy; 2025 Dream Desserts. All rights reserved.</p>
    <p style="font-size: 14px; color: #666; margin: 5px 0;">Address: Jln.Airlangga, Masuk gang baratnya balai, RT.4/RW.3, Sukorejo, Kabupaten Kediri</p>
    <p style="font-size: 14px; color: #666; margin: 5px 0;">Phone: <a href="tel:+1234567890" style="color: #007bff; text-decoration: none;">(085) 707-498048</a></p>
    <p style="font-size: 14px; color: #666; margin: 5px 0;">Email: <a href="mailto:dreamdessert@example.com" style="color: #007bff; text-decoration: none;">dreamdessert@example.com</a></p>
</footer>
</body>
</html>


