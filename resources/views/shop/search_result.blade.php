@extends('templatemarket.master')
@section('title', 'Search')
@section('content')


    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('market_place.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Search</li>
        </ol>
    </div>

    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1>Hasil Pencarian untuk: "{{ $query }}"</h1>

            @if ($products->count() > 0)
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3">
                            <div class="fruite-img">
                                <div class="card">
                                    <img src="{{ asset('storage/images/' . $product->image) }}"
                                        class="img-fluid rounded-top product-image" alt="{{ $product->nama_product }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->nama_product }}</h5>
                                        <p class="card-text">{{ $product->descripsi }}</p>
                                        <a href="{{ route('product.detail', ['slug' => $product->slug]) }}"
                                            class="btn btn-primary">Lihat Produk</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $products->appends(['q' => $query])->links() }}
            @else
                <p>Tidak ada produk yang ditemukan.</p>
            @endif
        </div>
    </div>
@endsection
