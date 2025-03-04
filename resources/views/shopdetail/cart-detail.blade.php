@extends('templatemarket.master')
@section('title', 'Cart')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('market_place.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                @if (count($cart) > 0)
                    <table class="table" id="cart-table">
                        <div id="empty-message" style="display: none">
                            <p>
                                <center>Keranjang Kamu Kosong</center>
                            </p>
                        </div>
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                <?php
                                $harga = $item->product->harga;
                                $diskon = $item->product->diskon;
                                $result = ($harga * $diskon) / 100;
                                $hasil = $harga - $result;
                                ?>
                                <tr data-id="{{ $item->id }}">
                                    <td><img src="{{ asset('storage/images/' . $item->product->image) }}"
                                            alt="{{ $item->product->nama_product }}" class="img-fluid me-5"
                                            style="width: 80px; height: 80px;"></td>
                                    <td class="mb-0 mt-4">{{ $item->product->nama_product }}</td>
                                    @if ($item->product->diskon > 0)
                                        <td class="mb-0 mt-4">@currency($hasil)</td>
                                    @else
                                        <td class="mb-0 mt-4">@currency($item->product->harga)</td>
                                    @endif
                                    <td class="mb-0 mt-4">{{ $item->product->stok }}</td>
                                    <td>
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <div class="input-group mt-0" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button type="button"
                                                    class="btn btn-sm btn-minus rounded-circle bg-light border quantity-btn"
                                                    data-action="minus">
                                                    <i class="fa fa-minus"></i></button>
                                            </div>
                                            @if ($item->product->diskon > 0)
                                                <input type="text" name="quantity" id="quantity-{{ $item->id }}"
                                                    value="{{ $item->quantity }}" min="1"
                                                    class="form-control form-control-sm text-center border-0 quantity-input"
                                                    data-price="{{ $hasil }}" data-max="{{ $item->product->stok }}">
                                            @else
                                                <input type="text" name="quantity" id="quantity-{{ $item->id }}"
                                                    value="{{ $item->quantity }}" min="1"
                                                    class="form-control form-control-sm text-center border-0 quantity-input"
                                                    data-price="{{ $item->product->harga }}"
                                                    data-max="{{ $item->product->stok }}">
                                            @endif

                                            <div class="input-group-btn">
                                                <button type="button"
                                                    class="btn btn-sm btn-plus rounded-circle bg-light border quantity-btn"
                                                    data-action="plus">
                                                    <i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-price">
                                        @if ($item->product->diskon > 0)
                                            <!-- Hitung harga setelah diskon -->
                                            @php
                                                $harga = $item->product->harga;
                                                $diskon = $item->product->diskon;
                                                $hasil = $harga - ($harga * $diskon) / 100;
                                            @endphp
                                            {{ number_format($hasil * $item->quantity) }}
                                        @else
                                            {{ number_format($item->product->harga * $item->quantity) }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-id="{{ $item->id }}"
                                            class="btn btn-md rounded-circle bg-light border mt-9 delete-btn"><i
                                                class="fa fa-times text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                @php
                                    // Menghitung total harga
                                    $grandTotal = $cart->sum(function ($item) {
                                        return $item->product->harga * $item->quantity;
                                    });
                                @endphp
                                <td>
                                    <strong class="mb-0 ps-4 me-4">TOTAL: <span
                                            id="grand-total">{{ number_format($grandTotal) }}</span></strong>
                                </td>
                                <td>
                                    <a href="{{ route('proses.checkout') }}"
                                        class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                        <i class=" me-2 text-primary"></i>Proses Checkout
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <p>
                        <center>Keranjang Kamu Kosong.</center>
                    </p>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateTotal() {
                    let grandTotal = 0;
                    document.querySelectorAll('tr[data-id]').forEach(function(row) {
                        const quantityInput = row.querySelector('.quantity-input');
                        const price = parseFloat(quantityInput.dataset.price);
                        const quantity = parseInt(quantityInput.value, 10);
                        const total = price * quantity;

                        // Update total price for this row
                        row.querySelector('.total-price').textContent = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }).format(total);

                        grandTotal += total;
                    });

                    // Update grand total
                    document.getElementById('grand-total').textContent = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(grandTotal);
                }

                document.querySelectorAll('.quantity-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const quantityInput = row.querySelector('.quantity-input');
                        let quantity = parseInt(quantityInput.value, 10);
                        let max = parseInt(quantityInput.dataset.max);

                        if (this.classList.contains('btn-plus')) {
                            if (quantity < max) {
                                quantity++;
                            } else {
                                alert('Jumlah melebihi stok yang tersedia');
                            }
                        }

                        // Jika tombol minus ditekan
                        if (this.classList.contains('btn-minus')) {
                            quantity = Math.max(quantity - 1, 1); // Pastikan kuantitas minimal 1
                        }

                        quantityInput.value = quantity;
                        updateTotal();

                        // Update cart data in session
                        const itemId = row.dataset.id;
                        $.ajax({
                            url: '/update-cart', // Endpoint untuk memperbarui kuantitas
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: JSON.stringify({
                                item_id: itemId,
                                quantity: quantity
                            }),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    updateTotal
                                        (); // Panggil fungsi untuk memperbarui grand total
                                } else {
                                    alert('Terjadi kesalahan saat memperbarui kuantitas.');
                                }
                            },
                            error: function(xhr) {
                                alert('Melebihi stok');
                            }
                        });
                    });
                });

                updateTotal(); // Initial call to set the correct total on page load

                $(document).ready(function() {
                    $('.delete-btn').on('click', function() {
                        var $this = $(this);
                        var itemId = $this.data('id');

                        $.ajax({
                            url: '/delete/cart/' + itemId, // Sesuaikan dengan rute Anda
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $this.closest('tr').remove();
                                    if ($('#cart-table tbody tr').length === 0) {
                                        $('#cart-table').hide(); // Sembunyikan tabel
                                        $('#empty-message')
                                            .show(); // Tampilkan pesan kosong
                                    }
                                    updateTotal(); // Perbarui total di halaman
                                    updateCartCount
                                        ();
                                    alert('Data berhasil dihapus.');
                                } else {
                                    alert('Terjadi kesalahan saat menghapus data.');
                                }
                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan: ' + xhr.responseText);
                            }
                        });
                    });
                });

            });

            function updateCartCount() {
                fetch('{{ route('get.cart.count') }}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('cart-count').innerText = data.cart_count;
                        } else {
                            console.error('Error fetching cart count:', data.error);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endpush
@endsection
