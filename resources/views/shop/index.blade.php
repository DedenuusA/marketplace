@extends('templatemarket.master')
@section('title', 'Shop')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('market_place.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Shop</li>
        </ol>
    </div>

    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">{{ $activeToko->nama_toko }}</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <!-- Search Bar -->
                        <div class="col-xl-3">
                            <form action="{{ route('products.search') }}" method="GET">
                                @csrf
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" name="q" class="form-control p-3" placeholder="Keywords"
                                        aria-describedby="search-icon-1" value="{{ request('q') }}">
                                    <button type="submit" id="search-icon-1" class="input-group-text p-3">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row g-4">
                        <!-- Sidebar with Categories and Featured Products -->
                        <div class="col-lg-3">
                            <!-- Categories -->
                            <div class="mb-3">
                                <h4>Categories</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    @foreach ($categories as $category)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('categories.show', ['slug' => $category->slug]) }}">
                                                    <i class="fas fa-user-alt me-2"></i>{{ $category->nama_kategori }}
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- Product Listing -->
                        <div class="col-lg-9">
                            <div class="row g-4">
                                @foreach ($products as $product)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">
                                                    <img src="{{ asset('storage/images/' . $product->image) }}"
                                                        class="img-fluid rounded-top product-image"
                                                        alt="{{ $product->nama_product }}"></a>
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">
                                                {{ $product->kategori->nama_kategori }}</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $product->nama_product }}</h4>
                                                <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">
                                                    <p>
                                                        <?php
                                                        $kalimat = $product->deskripsi;
                                                        $sub_kalimat = substr($kalimat, 0, 50);
                                                        echo $sub_kalimat;
                                                        ?>...
                                                    </p>
                                                </a>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <?php
                                                    $harga = $product->harga;
                                                    $diskon = $product->diskon;
                                                    $result = ($harga * $diskon) / 100;
                                                    $hasil = $harga - $result;
                                                    ?>
                                                    @if ($product->diskon > 0)
                                                        <p class="text-dark fs-5 fw-bold mb-0">@currency($hasil)</p>
                                                        <span
                                                            class="sold-out text-decoration-line-through">@currency($product->harga)</span>
                                                        <span class="diskon text-danger">-{{ $diskon }}%</span>
                                                    @else
                                                        <p class="text-dark fs-5 fw-bold mb-0">@currency($product->harga)</p>
                                                    @endif

                                                    @if ($product->stok > 0)
                                                        <p class="text-dark fw-bold mb-0">Stok : {{ $product->stok }}
                                                        </p>
                                                    @else
                                                        <p class="text-dark fw-bold mb-0">SOLD OUT</p>
                                                    @endif
                                                    <p class="text-dark">
                                                        {{ $product->order_item_count }} Terjual
                                                    </p>
                                                    <p class="text-dark fw-bold"><i class="fa fa-star text-secondary">
                                                            {{ number_format($product->averageRating, 1) }}
                                                        </i></p>
                                                    {{-- <a href="javascript:void(0);"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart"
                                                        data-id="{{ $product->id }}"
                                                        data-user="{{ $product->user->id }}"><i
                                                            class="fa fa-plus me-2 text-primary"></i>
                                                        Keranjang
                                                    </a>
                                                    <a href="{{ route('checkout.product', $product->id) }}"
                                                        class="btn border border-secondary rounded-pill text-primary w-40 px-4 checkout-product-cart">Beli</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Pagination -->
                            <ul class="pagination">
                                <li class="page-item">
                                    <div class="pagination d-flex justify-content-center mt-5">
                                        {{ $products->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     document.querySelectorAll('.add-to-cart').forEach(button => {
            //         button.addEventListener('click', function() {
            //             const productId = this.getAttribute('data-id');
            //             const userId = this.getAttribute('data-user');
            //             const quantity = 1; // Kuantitas tetap 1 untuk setiap klik tombol

            //             // Kirim permintaan AJAX untuk memverifikasi login dan menambahkan produk ke keranjang
            //             fetch('/add-to-cart', {
            //                     method: 'POST',
            //                     headers: {
            //                         'Content-Type': 'application/json',
            //                         'X-CSRF-TOKEN': document.querySelector(
            //                             'meta[name="csrf-token"]').getAttribute('content')
            //                     },
            //                     body: JSON.stringify({
            //                         product_id: productId,
            //                         quantity: quantity,
            //                         user_id: userId
            //                     })
            //                 })
            //                 .then(response => response.json())
            //                 .then(data => {
            //                     if (data.message === 'Anda harus login terlebih dahulu') {
            //                         alert(data.message);
            //                         window.location.href = '/customer/check_login';
            //                     } else if (data.message ===
            //                         'Produk berhasil ditambahkan ke keranjang') {
            //                         alert(data.message);
            //                         updateCartCount
            //                             (); // Memperbarui jumlah keranjang jika diperlukan
            //                     } else {
            //                         alert('Terjadi kesalahan: ' + data.message);
            //                     }
            //                 })
            //                 .catch(error => console.error('Error:', error));
            //         });
            //     });
            // });

            // function updateCartCount() {
            //     fetch('{{ route('get.cart.count') }}', {
            //             method: 'GET',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //             }
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.success) {
            //                 document.getElementById('cart-count').innerText = data.cart_count;
            //             } else {
            //                 console.error('Error fetching cart count:', data.error);
            //             }
            //         })
            //         .catch(error => console.error('Error:', error));
            // }
        </script>
    @endpush
@endsection
