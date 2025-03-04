@extends('templatemarket.master')
@section('title', 'Checkout')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('market_place.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Rincian Checkout</h1>
            <form action="{{ route('checkout.customer') }}" method="POST">
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="form-item">
                            <label class="form-label my-3">Nama<sup>*</sup></label>
                            <input type="text" class="form-control" name="customer_name" id="customer_name"
                                value="{{ $customer->nama }}" required>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email<sup>*</sup></label>
                            <input type="email" class="form-control" name="customer_email" id="customer_email"
                                value="{{ $customer->email }}" required>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Alamat <sup>*</sup></label>
                            <textarea id="shipping_address" name="shipping_address" class="form-control" spellcheck="false" cols="30"
                                rows="11" placeholder="isikan alamat lengkap">{{ $customer->alamat }}</textarea>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">No HP<sup>*</sup></label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp"
                                value="{{ $customer->phone_number }}" required>
                        </div>
                        <br>
                        <div class="form-item">
                            <textarea id="catatan" name="catatan" class="form-control" spellcheck="false" cols="10" rows="6"
                                placeholder="catatan">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            @if (count($cart) > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $item)
                                            @php
                                                $harga = $item->product->harga;
                                                $diskon = $item->product->diskon;
                                                $hasil = $harga - ($harga * $diskon) / 100;
                                            @endphp
                                            <tr>
                                                <td><img src="{{ asset('storage/images/' . $item->product->image) }}"
                                                        alt="{{ $item->product->nama_product }}" class="img-fluid me-5"
                                                        style="width: 80px; height: 80px;"></td>
                                                <td class="mb-0 mt-4">{{ $item->product->nama_product }}</td>
                                                @if ($item->product->diskon > 0)
                                                    <td class="mb-0 mt-4">@currency($hasil)</td>
                                                @else
                                                    <td class="mb-0 mt-4">@currency($item->product->harga)</td>
                                                @endif
                                                <td class="mb-0 mt-4">{{ $item->quantity }}</td>
                                                @if ($item->product->diskon > 0)
                                                    @php
                                                        $harga = $item->product->harga;
                                                        $diskon = $item->product->diskon;
                                                        $hasil = $harga - ($harga * $diskon) / 100;
                                                    @endphp
                                                    <td>@currency($hasil * $item->quantity)</td>
                                                @else
                                                    <td> @currency($item->product->harga * $item->quantity)</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @if ($item->product->diskon > 0)
                                                @php
                                                    $total = $cart->sum(function ($item) {
                                                        $harga = $item->product->harga;
                                                        $diskon = $item->product->diskon;
                                                        $hasil = $harga - ($harga * $diskon) / 100;
                                                        return $hasil * $item->quantity;
                                                    });
                                                @endphp
                                            @else
                                                @php
                                                    $total = $cart->sum(function ($item) {
                                                        return $item->product->harga * $item->quantity;
                                                    });
                                                @endphp
                                            @endif
                                            @php
                                                $total = $cart->sum(function ($item) {
                                                    $harga = $item->product->harga;
                                                    $diskon = $item->product->diskon;

                                                    if ($diskon > 0) {
                                                        $hasil = $harga - ($harga * $diskon) / 100;
                                                    } else {
                                                        $hasil = $harga;
                                                    }

                                                    return $hasil * $item->quantity;
                                                });
                                            @endphp
                                            <th scope="row"></th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                            </td>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark">@currency($total)</p>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p>
                                    <center>Keranjang Anda Kosong.</center>
                                </p>
                            @endif
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0"
                                        name="jenis_pembayaran" id="jenis_pembayaran" value="transfer">
                                    <label class="form-check-label" for="Transfer">Transfer Bank</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0"
                                        id="jenis_pembayaran" name="jenis_pembayaran" value="cod">
                                    <label class="form-check-label" for="Delivery">COD</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place
                                Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const formData = new FormData(form);
                    const options = {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    };

                    fetch(form.action, options)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.whatsapp_url;
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        </script>
    @endpush
@endsection
