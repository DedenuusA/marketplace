@extends('template.master')
@section('title', 'Bantuan')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pertanyaan yang Sering Diajukan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Pertanyaan Umum</li>
                </ol>
            </nav>
        </div>

        <section class="section faq">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card basic">
                        <div class="card-body">
                            <h5 class="card-title">Pertanyaan Dasar</h5>

                            <div>
                                <h6>1. Bagaimana cara saya memasang produk di website?</h6>
                                <p>Pertanyaan ini mungkin terdengar jelas, tapi juga dipikirkan. Misal, jika kamu memiliki
                                    10 produk dan harus memasukan informasi dan upload gambar produk secara manual, mungkin
                                    itu tidak masalah. Tapi bagaimana jika kamu memiliki ratusan jenis produk? Pikirkan
                                    aplikasi atau program yang bisa memasukan informasi dan gambar produk secara otomatis
                                    pada website.
                                </p>
                            </div>

                            <div class="pt-2">
                                <h6>2. Bagaimana cara saya mengelola persediaan?</h6>
                                <p>Setelah produk dan webiste siap, langkah selanjutnya adalah bagaimana cara mengelola
                                    persediaan? Jika kamu hanya menjual secara online dari satu toko, itu tidak masalah.
                                    Tapi bagaimana jika ingin berencana untuk berjualan di marketplace seperi Amazon?
                                    Pikirkan menglola barang persediaannya.</p>
                            </div>

                            <div class="pt-2">
                                <h6>3. Jenis pembayaran apa yang harus saya gunakan?</h6>
                                <p>Ada banyak sekali metode/jenis pemabayaran yang bisa kita gunakan. Ada kartu kredit,
                                    transfer ATM bank lokal, COD, hingga PayPal. Pikirkan juga apakah memerlukan bentuk
                                    checkout khusus?

                                    Tujuan dari bisnis e-commerce adalah untuk menjual barang atau jasa secara elektronik.
                                    Itu tidak akan terjadi kecuali kita memiliki proses pembayaran tersebut.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
