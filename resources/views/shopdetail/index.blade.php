@extends('templatemarket.master')
@section('title', 'Detail')
@section('content')

    <style>
        .review-item {
            display: flex;
            flex-direction: column;
        }

        .review-item .rating {
            margin-left: auto;
            /* Memastikan bintang rating berada di sebelah kanan */
        }

        .rating i {
            margin-right: 2px;
        }
    </style>

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop Detail</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('market_place.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Shop Detail</li>
        </ol>
    </div>

    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        @foreach ($products as $product)
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="fruite-img">
                                            <img src="{{ asset('storage/images/' . $product->image) }}"
                                                class="img-fluid rounded" alt="{{ $product->deskripsi }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <?php
                                        $harga = $product->harga;
                                        $diskon = $product->diskon;
                                        $result = ($harga * $diskon) / 100;
                                        $hasil = $harga - $result;
                                        ?>
                                        <h4 class="fw-bold mb-3">{{ $product->nama_product }}</h4>
                                        <p class="mb-3">Kategori : {{ $product->kategori->nama_kategori }}</p>
                                        {{-- <h5 class="fw-bold mb-3" id="total-price">@currency($product->harga)</h5> --}}

                                        @if ($product->diskon > 0)
                                            <span class="text-dark fs-5 fw-bold mb-0">@currency($hasil)</span>
                                            <span class="sold-out text-decoration-line-through">@currency($product->harga)</span>
                                            <span class="diskon text-danger">-{{ $diskon }}%</span>
                                        @else
                                            <p class="text-dark fs-5 fw-bold mb-0">@currency($product->harga)</p>
                                        @endif

                                        <p class="text-dark fw-bold"><i class="fa fa-star text-secondary">
                                                {{ number_format($product->averageRating, 1) }}
                                            </i></p>
                                        <p class="mb-4">{{ $product->deskripsi }}</p>

                                        @if ($product->stok > 0)
                                            <p class="mb-3">Stok: {{ $product->stok }} |
                                                {{ $product->order_item_count }}
                                                Terjual
                                            </p>
                                        @else
                                            <p class="text-dark fw-bold mb-0">SOLD OUT |
                                                {{ $product->order_item_count }}
                                                Terjual</p>
                                        @endif
                                        <div class="input-group quantity mb-5" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-center border-0"
                                                id="quantity" value="1" data-max="{{ $product->stok }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);"
                                            class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"
                                            id="add-cart">
                                            <i class="fa fa-plus me-2 text-primary"></i>Keranjang
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="btn border border-secondary rounded-pill px-4 w-40 mb-4 py-2 text-primary"
                                            id="checkout">Beli Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane" id="nav-mission" role="tabpanel"
                                        aria-labelledby="nav-mission-tab">
                                        @if ($product->reviews->isNotEmpty())
                                            @foreach ($product->reviews as $review)
                                                <div class="d-flex">
                                                    <img src="{{ asset('marketplace/img/avatar.jpg') }}"
                                                        class="img-fluid rounded-circle p-3"
                                                        style="width: 100px; height: 100px;"
                                                        alt="marketplace/img/avatar.jpg">
                                                    <div class="review-item">
                                                        <p class="mb-2" style="font-size: 14px;">
                                                            {{ $review->created_at }}
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5>
                                                                {{-- Pastikan orderItem ada dan memiliki order, lalu tampilkan customer_name --}}
                                                                @if ($review->orderItem && $review->orderItem->order)
                                                                    {{ $review->orderItem->order->customer_name }}
                                                                @else
                                                                    Nama pelanggan tidak tersedia
                                                                @endif
                                                            </h5>
                                                            <div class="rating d-flex">
                                                                {{-- Tampilkan rating berdasarkan nilai review --}}
                                                                @php
                                                                    $rating = $review->rating;
                                                                @endphp
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="fa fa-star {{ $i <= $rating ? 'text-secondary' : '' }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <p>{{ $review->review }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>Belum ada ulasan</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnMinus = document.querySelector('.btn-minus');
                const btnPlus = document.querySelector('.btn-plus');
                const quantityInput = document.getElementById('quantity');
                const addToCartButton = document.getElementById('add-cart');
                const checkoutButton = document.getElementById('checkout');
                // const totalPriceElement = document.getElementById('total-price');
                const pricePerUnit = {{ $product->harga }}; // Pastikan ini adalah angka, bukan string

                // function updateTotalPrice() {
                //     const quantity = parseInt(quantityInput.value, 10);
                //     const totalPrice = quantity * pricePerUnit;
                //     totalPriceElement.textContent = '' + new Intl.NumberFormat('id-ID', {
                //         style: 'currency',
                //         currency: 'IDR',
                //         minimumFractionDigits: 0,
                //         maximumFractionDigits: 0
                //     }).format(totalPrice);
                // }

                // Inisialisasi harga total saat halaman dimuat
                // updateTotalPrice();

                // Event Listener untuk tombol minus
                btnMinus.addEventListener('click', function() {
                    let quantity = parseInt(quantityInput.value, 10);
                    if (quantity > 1) {
                        quantity -= 1;
                        quantityInput.value = quantity;
                        // updateTotalPrice();
                    }
                });

                // Event Listener untuk tombol plus
                btnPlus.addEventListener('click', function() {
                    let quantity = parseInt(quantityInput.value, 10);
                    let max = parseInt(quantityInput.dataset.max);
                    if (quantity < max) {
                        quantity += 1;
                        quantityInput.value = quantity;
                    } else {
                        alert('Jumlah melebihi stok yang tersedia');
                    }
                    // updateTotalPrice();
                });

                function handleCartAction(actionUrl, productId, userId, redirectUrl) {
                    fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                quantity: parseInt(quantityInput.value, 10),
                                product_id: parseInt(productId, 10),
                                user_id: parseInt(userId),
                            })
                        })
                        .then(response => {
                            // console.log('Response status:', response.status);
                            return response.text();

                        })
                        .then(text => {
                            try {
                                const data = JSON.parse(text);
                                if (data && data.message) {
                                    alert(data.message);
                                    updateCartCount();
                                    if (redirectUrl) {
                                        window.location.href = redirectUrl;
                                    }
                                }
                            } catch (error) {
                                console.error('JSON parsing error:', error);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }

                // Tambahkan parameter productId dan redirectUrl pada event listener
                addToCartButton.addEventListener('click', function() {
                    const isLoggedIn = {{ Auth::guard('customer')->user() ? 'true' : 'false' }};
                    const productId = {{ $product->id }};
                    const userId = {{ $product->user_id }};
                    if (isLoggedIn) {
                        handleCartAction('{{ route('add.cart') }}', productId, userId);
                    } else {
                        alert('Anda harus login terlebih dahulu');
                        sessionStorage.setItem('redirectUrl', window.location.href);
                        window.location.href = '{{ route('customer.login') }}';
                    }
                });

                checkoutButton.addEventListener('click', function() {
                    const isLoggedIn = {{ Auth::guard('customer')->user() ? 'true' : 'false' }};
                    const productId = {{ $product->id }};
                    const userId = {{ $product->user_id }};
                    if (isLoggedIn) {
                        handleCartAction('{{ route('checkout.detail') }}', productId, userId,
                            '{{ route('proses.checkout') }}');
                    } else {
                        alert('Anda harus login terlebih dahulu');
                        sessionStorage.setItem('redirectUrl', window.location.href);
                        window.location.href = '{{ route('customer.login') }}';
                    }
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
