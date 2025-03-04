@extends('templatemarket.master')
@section('title', 'Market_place')
@section('content')


    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Profile</h1>
    </div>

    <div class="container-fluid py-5">
        <div class="pagetitle">
            <h1>Profile</h1>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @if ($profile->gambar != '')
                                <img id="gambar" src="{{ asset($profile->gambar) }}" alt="Profile" style="height:auto"
                                    width="150px">
                            @else
                                <img id="gambar" src="{{ asset('marketplace/img/avatar.jpg') }}" alt="Profile"
                                    style="height:auto" width="150px">
                            @endif
                            <br>
                            <h3 id="nama-info-profil">{{ $profile->nama }}</h3>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Ubah Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Detail Profil</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nama</div>
                                        <div class="col-lg-9 col-md-8" id="nama-info">{{ $profile->nama }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8" id="email-info">{{ $profile->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">No HP</div>
                                        <div class="col-lg-9 col-md-8" id="phone_number-info">{{ $profile->phone_number }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Negara</div>
                                        <div class="col-lg-9 col-md-8">Indonesia</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Alamat</div>
                                        <div class="col-lg-9 col-md-8" id="alamat-info">{{ $profile->alamat }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                                        <div class="col-lg-9 col-md-8" id="jenis_kelamin-info">{{ $profile->jenis_kelamin }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Tgl Daftar</div>
                                        <div class="col-lg-9 col-md-8">{{ $profile->created_at }}</div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <div id="error-div"></div>
                                    <form id="update-profile-form">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                @if ($profile->gambar != '')
                                                    <img id="gambar-info" src="{{ asset($profile->gambar) }}" alt="Profile"
                                                        style="height:auto" width="150px">
                                                @else
                                                    <img id="gambar" src="{{ asset('marketplace/img/avatar.jpg') }}"
                                                        alt="Profile" style="height:auto" width="150px">
                                                @endif
                                                <div class="pt-2">
                                                    <input type="file" name="profile_image" id="profileImage"
                                                        style="display: none;">
                                                    <a href="#" class="btn btn-primary btn-sm"
                                                        title="Upload new profile image" id="upload-btn">
                                                        <i class="bi bi-upload"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="update_id" id="update_id">
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" class="form-control" id="nama"
                                                    value="{{ $profile->nama }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="email" class="form-control" id="email"
                                                    value="{{ $profile->email }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea class="form-control" id="alamat" style="height: 100px">{{ $profile->alamat }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Jenis_kelamin" class="col-md-4 col-lg-3 col-form-label">Jenis
                                                Kelamin</label>
                                            <div class="col-md-4 col-lg-9">
                                                <select id="jenis_kelamin" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="laki-laki"
                                                        {{ $profile->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                                        laki - laki
                                                    </option>
                                                    <option
                                                        value="perempuan"{{ $profile->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                                        perempuan
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" class="form-control" id="phone_number"
                                                    value="{{ $profile->phone_number }}">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"
                                                id="save-profile-btn">Simpan</button>
                                        </div>
                                    </form>

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <form id="update-password-form">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password
                                                Lama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password
                                                Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control"
                                                    id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Ulangi
                                                Password Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control"
                                                    id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"
                                                id="save-password-btn">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#save-profile-btn').click(function(e) {
                    e.preventDefault(); 
                    let formData = {
                        nama: $('#nama').val(),
                        email: $('#email').val(),
                        alamat: $('#alamat').val(),
                        jenis_kelamin: $('#jenis_kelamin').val(),
                        phone_number: $('#phone_number').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };

                    $.ajax({
                        url: '/customer/update-profile',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.message) {
                                alert('Profil berhasil diperbarui!');

                                $(document).ready(function() {
                                    $('#nama-info-profil').text(formData.nama);
                                    $('#nama-info').text(formData.nama);
                                    $('#email-info').text(formData.email);
                                    $('#phone_number-info').text(formData.phone_number);
                                    $('#alamat-info').text(formData.alamat);
                                    $('#jenis_kelamin-info').text(formData.jenis_kelamin);
                                });
                            } else {
                                alert('Gagal memperbarui profil.');
                            }
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan saat memperbarui profil: ' + xhr
                                .responseText);
                        }
                    });
                });
            });
            $(document).ready(function() {
                $('#update-password-form').submit(function(e) {
                    e.preventDefault();
                    let formData = {
                        password: $('#currentPassword').val(),
                        newpassword: $('#newPassword').val(),
                        renewpassword: $('#renewPassword').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: '/customer/update-password',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.message === true) {
                                alert('Password berhasil diperbarui!');
                                $('#update-password-form')[0].reset();
                            } else {
                                alert(response.error || 'Gagal memperbarui password.');
                            }
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                });
            });
            $(document).ready(function() {
                $('#upload-btn').on('click', function(e) {
                    e.preventDefault();
                    $('#profileImage').click();

                    $('#profileImage').on('change', function() {
                        var formData = new FormData($('#update-profile-form')[0]);

                        $.ajax({
                            url: '/upload/image/customer',
                            type: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    alert('Gambar Berhasil Di Upload');
                                    $('#gambar').attr('src', response
                                        .new_image_url);
                                    $('#gambar-info').attr('src', response
                                        .new_image_url);
                                } else {
                                    alert('Upload gagal');
                                }
                            },
                            error: function(xhr) {
                                alert('Terjadi kesalahan saat mengupload gambar' + xhr
                                    .responseText);
                            }
                        });
                    });
                });
            });
        </script>
    @endpush

@endsection
