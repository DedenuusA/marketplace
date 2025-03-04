    <tr>
        <th>Nama</th>
        <th>:</th>
        <td>{{ $orderItem->order->customer_name }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <th>:</th>
        <td>{{ $orderItem->order->customer_email }}</td>
    </tr>
    <tr>
        <th>Alamat</th>
        <th>:</th>
        <td>{{ $orderItem->order->shipping_address }}</td>
    </tr>
    <tr>
        <th>No Hp</th>
        <th>:</th>
        <td>{{ $orderItem->order->no_hp }}</td>
    </tr>
    <tr>
        <th>Catatan</th>
        <th>:</th>
        <td>{{ $orderItem->order->catatan }}</td>
    </tr>
    <tr>
        <th>Pembayaran</th>
        <th>:</th>
        <td>{{ $orderItem->order->jenis_pembayaran }}</td>
    </tr>
    <tr>
        <th>Total</th>
        <th>:</th>
        <td>@currency($orderItem->order->total_amount)</td>
    </tr>
    <tr>
        <th>Status</th>
        <th>:</th>
        <td>{{ $orderItem->order->status }}</td>
    </tr>
    <tr>
        <th>Tanggal Pesanan</th>
        <th>:</th>
        <td>{{ $orderItem->order->created_at }}</td>
    </tr>

