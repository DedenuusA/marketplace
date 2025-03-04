@extends('templatemarket.master')
@section('title', 'Market_place')
@section('content')

    <style>
        .sold-out {
            text-decoration: line-through;
            font-size: 0.875em;
        }

        .diskon {
            font-size: 0.87em;
            color: red;
            margin-left: 5px;
        }
    </style>

    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Original</h4>
                    <h1 class="mb-5 display-3 text-primary">Product Original</h1>
                    <form action="{{ route('products.search') }}" method="GET">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="text"
                                placeholder="Search" name="q" value="{{ request('q') }}">
                            <button type="submit"
                                class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 25%;">Submit Now</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="marketplace/img/promo2.jpg" class="img-fluid w-100 h-100 bg-secondary rounded"
                                    alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">10%</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="marketplace/img/promo.jpg" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">50%</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Pengiriman Gratis</h5>
                            <p class="mb-0">Gratis Pengiriman Belanja</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Pembayaran Aman</h5>
                            <p class="mb-0">100% Aman</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Pengembalian 30 hari</h5>
                            <p class="mb-0">Pengembalian uang 30 hari</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Dukungan 24/7</h5>
                            <p class="mb-0">Dukungan setiap saat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-8 text-start">
                        <h1>{{ $activeToko->nama_toko }}</h1>
                    </div>
                </div>
                <br>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($product as $products)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <a href="{{ route('product.detail', ['slug' => $products->slug]) }}"><img
                                                            src="{{ asset('storage/images/' . $products->image) }}"
                                                            class="img-fluid rounded-top product-image"
                                                            alt="{{ $products->image }} - {{ $products->description }}"></a>
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">
                                                    {{ $products->kategori->nama_kategori }}
                                                    | {{ $products->toko->nama_toko }}
                                                </div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>{{ $products->nama_product }}</h4>
                                                    <a href="{{ route('product.detail', ['slug' => $products->slug]) }}">
                                                        <p>
                                                            <?php
                                                            $kalimat = $products->deskripsi;
                                                            $sub_kalimat = substr($kalimat, 0, 50);
                                                            echo $sub_kalimat;
                                                            ?>...
                                                        </p>
                                                    </a>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <?php
                                                        $harga = $products->harga;
                                                        $diskon = $products->diskon;
                                                        $result = ($harga * $diskon) / 100;
                                                        $hasil = $harga - $result;
                                                        ?>
                                                        @if ($products->diskon > 0)
                                                            <p class="text-dark fs-5 fw-bold mb-0">@currency($hasil)</p>
                                                            <span
                                                                class="sold-out text-decoration-line-through">@currency($products->harga)</span>
                                                            <span class="diskon text-danger">-{{ $diskon }}%</span>
                                                        @else
                                                            <p class="text-dark fs-5 fw-bold mb-0">@currency($products->harga)</p>
                                                        @endif

                                                        @if ($products->stok > 0)
                                                            <p class="text-dark fw-bold mb-0">Stok : {{ $products->stok }}
                                                            </p>
                                                        @else
                                                            <p class="text-dark fw-bold mb-0">SOLD OUT</p>
                                                        @endif
                                                        <p class="text-dark">
                                                            {{ $products->order_item_count }} Terjual
                                                        </p>
                                                        <p class="text-dark fw-bold"><i class="fa fa-star text-secondary">
                                                                {{ number_format($products->averageRating, 1) }}
                                                            </i></p>
                                                    </div>
                                                    {{-- <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <a href="javascript:void(0);"
                                                            class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart"
                                                            data-id="{{ $products->id }}"
                                                            data-user="{{ $products->user->id }}"><i
                                                                class="fa fa-plus me-2 text-primary"></i>Keranjang</a>
                                                        <a href="{{ route('checkout.product', $products->id) }}"
                                                            id="checkout-button"
                                                            class="btn border border-secondary rounded-pill px-4 w-40 text-primary checkout-product-cart">Beli</a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <ul class="pagination">
                                    <li class="page-item">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            {{ $product->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">Product ORI</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach ($product as $products)
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <a href="{{ route('product.detail', ['slug' => $products->slug]) }}"><img
                                    src="{{ asset('storage/images/' . $products->image) }}"
                                    class="img-fluidw-100 rounded-top product-image"
                                    alt="{{ $products->image }} - {{ $products->description }}"></a>
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                            style="top: 10px; right: 10px;">{{ $products->kategori->nama_kategori }}</div>
                        <div class="p-4 rounded-bottom">
                            <h4>{{ $products->nama_product }}</h4>
                            <a href="{{ route('product.detail', ['slug' => $products->slug]) }}">
                                <p>
                                    <?php
                                    $kalimat = $products->deskripsi;
                                    $sub_kalimat = substr($kalimat, 0, 50);
                                    echo $sub_kalimat;
                                    ?>...
                                </p>
                            </a>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <?php
                                $harga = $products->harga;
                                $diskon = $products->diskon;
                                $result = ($harga * $diskon) / 100;
                                $hasil = $harga - $result;
                                ?>
                                @if ($products->diskon > 0)
                                    <p class="text-dark fs-5 fw-bold mb-0">@currency($hasil)</p>
                                    <span class="sold-out text-decoration-line-through">@currency($products->harga)</span>
                                    <span class="diskon text-danger">-{{ $diskon }}%</span>
                                @else
                                    <p class="text-dark fs-5 fw-bold mb-0">@currency($products->harga)</p>
                                @endif

                                @if ($products->stok > 0)
                                    <p class="text-dark fw-bold mb-0">Stok : {{ $products->stok }}
                                    </p>
                                @else
                                    <p class="text-dark fw-bold mb-0">SOLD OUT</p>
                                @endif
                                <p class="text-dark">
                                    {{ $products->order_item_count }} Terjual
                                </p>
                                <p class="text-dark fw-bold"><i class="fa fa-star text-secondary">
                                        {{ number_format($products->averageRating, 1) }}
                                    </i></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- tinker
    use App\Models\Product;
use Illuminate\Support\Str;

Product::all()->each(function ($product) {
    $product->slug = Str::slug($product->nama_product);
    $product->save();
}); --}}


    @push('scripts')
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.add-to-cart').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-id');
                        const userId = this.getAttribute('data-user');
                        const quantity = 1; // Kuantitas tetap 1 untuk setiap klik tombol

                        // Kirim permintaan AJAX untuk memverifikasi login dan menambahkan produk ke keranjang
                        fetch('/add-to-cart', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    product_id: productId,
                                    quantity: quantity,
                                    user_id: userId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'Anda harus login terlebih dahulu') {
                                    alert(data.message);
                                    window.location.href = '/customer/check_login';
                                } else if (data.message ===
                                    'Produk berhasil ditambahkan ke keranjang') {
                                    alert(data.message);
                                    updateCartCount
                                        (); // Memperbarui jumlah keranjang jika diperlukan
                                } else {
                                    alert('Terjadi kesalahan: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });

            function updateCartCount() {
                fetch('{{ route('get.cart.count') }}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
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
            } --}}
        </script>
    @endpush
@endsection
