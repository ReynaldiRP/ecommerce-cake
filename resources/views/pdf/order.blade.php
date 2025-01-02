<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 20px;
            color: #333;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
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
<h2>Riwayat Order</h2>
<table>
    <thead>
    <tr class="table-header">
        <th>No</th>
        <th>Order Kode</th>
        <th>Estimasi Tanggal Pengiriman</th>
        <th>Alamat Penerima</th>
        <th>Penerima Kue</th>
        <th>Total Pembayaran</th>
        <th>Status Pemesanan</th>
        <th>Pesanan Dibuat</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $index => $order)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $order['order_code'] }}</td>
            <td>{{ $order['estimated_delivery_date'] }}</td>
            <td>{{ $order['user_address'] }}</td>
            <td>{{ $order['cake_recipient'] }}</td>
            <td>{{ $order['total_price'] }}</td>
            <td>{{ $order['status'] }}</td>
            <td>{{ $order['created_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="table-footer">
        <td colspan="8">Total Order: {{ count($orders) }}</td>
    </tr>
    </tfoot>
</table>
</body>
</html>


