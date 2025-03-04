@extends('templatemarket.master')
@section('title', 'Contack')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Contact</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('market_place.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Contact</li>
        </ol>
    </div>

    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Hubungi Kami</h1>
                            <p class="mb-4">Anda Perlu Bantuan Dan ingin Mempunyai Toko onlie Segeralah Hubungi.</p>
                            <a href="#">Download Now</a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe class="rounded w-100" style="height: 400px;"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.483824600531!2d108.3296498!3d-6.3313049!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6eb954f082d9cf%3A0x2c7c13ed336affef!2sKilau%20Cabang%20Indramayu!5e0!3m2!1sid!2sid!4v1724741483136!5m2!1sid!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form id="komentarForm" class="">
                            @csrf
                            <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Nama"
                                id="nama" required>
                            <input type="email" class="w-100 form-control border-0 py-3 mb-4" id="email"
                                placeholder="Email" required>
                            <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Pesan" id="pesan"
                                required></textarea>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary"
                                type="submit" id="save-komentar-btn">Simpan</button>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Alamat</h4>
                                <p class="mb-2">123 Street New York.USA</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Email</h4>
                                <p class="mb-2">info@example.com</p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Telephone</h4>
                                <p class="mb-2">(+012) 3456 7890</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#komentarForm').on('submit', function(event) {
                    event.preventDefault();

                    var formData = {
                        nama: $('#nama').val(),
                        email: $('#email').val(),
                        pesan: $('#pesan').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: '/komentar',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            alert('Komentar berhasil disimpan!');
                            $('#komentarForm')[0].reset();
                        },
                        error: function(xhr, status, error) {
                            alert('Gagal menyimpan komentar. Silakan coba lagi.');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
