<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 20px;
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
<h2>Riwayat Transaksi</h2>
<table>
    <thead>
    <tr class="table-header">
        <th>No</th>
        <th>Transaksi Id</th>
        <th>Kode Order</th>
        <th>Metode Pembayaran</th>
        <th>Status Pembayaran</th>
        <th>Transaksi Dibuat</th>
        <th>Transaksi Dibayar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $index => $payment)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $payment['transaction_id'] }}</td>
            <td>{{ $payment['order_code'] }}</td>
            <td>{{ $payment['payment_method'] }}</td>
            <td>{{ $payment['payment_status'] }}</td>
            <td>{{ $payment['created_at'] }}</td>
            <td>{{ $payment['updated_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="table-footer">
        <td colspan="7">Total Transaksi: {{ count($payments) }}</td>
    </tr>
    </tfoot>
</table>
</body>
</html>


