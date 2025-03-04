@extends('template.master')
@section('title', 'Profile')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @if ($profile->gambar != '')
                                <img src="{{ asset($profile->gambar) }}" alt="Profile" id="gambar-info"
                                    class="rounded-circle">
                            @else
                                <img src="{{ asset('marketplace\img\avatar.jpg') }}" alt="profile" id="gambar-info"
                                    class="rounded-circle">
                            @endif
                            <h2 id="nama-profil-info">{{ $profile->name }}</h2>
                            <p>{{ $profile->role }}</p>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link" data-toggle="tab"
                                        data-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-toggle="tab" data-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-toggle="tab" data-target="#profile-change-password">Edit
                                        Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label" style="text-align: left">Nama</div>
                                        <div class="col-lg-9 col-md-8" id="nama-info">{{ $profile->name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label" style="text-align: left;">Email</div>
                                        <div class="col-lg-9 col-md-8" id="email-info">{{ $profile->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label" style="text-align: left">No HP</div>
                                        <div class="col-lg-9 col-md-8" id="no_telepon-info">{{ $profile->no_telepon }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label" style="text-align: left">Jenis Kelamin</div>
                                        <div class="col-lg-9 col-md-8" id="jenis_kelamin-info">{{ $profile->jenis_kelamin }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label" style="text-align: left">Alamat</div>
                                        <div class="col-lg-9 col-md-8" id="alamat-info">{{ $profile->alamat }}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade profile-edit" id="profile-edit">

                                    <form id="update-profile-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                @if ($profile->gambar != '')
                                                    <img id="gambar" src="{{ asset($profile->gambar) }}" alt="Profile">
                                                @else
                                                    <img src="{{ asset('marketplace\img\avatar.jpg') }}" alt="profile">
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

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullName" type="text" class="form-control" id="name"
                                                    value="{{ $profile->name }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="company" type="email" class="form-control" id="email"
                                                    value="{{ $profile->email }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">No HP</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="job" type="number" class="form-control"
                                                    id="no_telepon" value="{{ $profile->no_telepon }}">
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
                                            <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="alamat" class="form-control" id="alamat" style="height: 100px">{{ $profile->alamat }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"
                                                id="save-userprofil-btn">Simpan</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
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
    </main>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#upload-btn').on('click', function(e) {
                    e.preventDefault();
                    $('#profileImage').click(); // Men-trigger input file

                    $('#profileImage').on('change', function() {
                        var formData = new FormData($('#update-profile-form')[0]);

                        $.ajax({
                            url: '/upload/image', // Ganti dengan URL endpoint yang sesuai
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
                                        .new_image_url); // Update gambar
                                    $('#gambar-info').attr('src', response
                                        .new_image_url);
                                } else {
                                    alert('Upload gagal');
                                }
                            },
                            error: function() {
                                alert('Terjadi kesalahan saat mengupload gambar');
                            }
                        });
                    });
                });
            });
            $(document).ready(function() {
                $('#save-userprofil-btn').click(function(e) {
                    e.preventDefault(); // Mencegah reload form

                    // Ambil data dari form
                    let formData = {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        alamat: $('#alamat').val(),
                        jenis_kelamin: $('#jenis_kelamin').val(),
                        no_telepon: $('#no_telepon').val(),
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    };

                    $.ajax({
                        url: '/user/update-profile', // Sesuaikan dengan route backend
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.message) {
                                // Berikan feedback kepada pengguna
                                alert('Profil berhasil diperbarui!');

                                $(document).ready(function() {
                                    // Update tampilan data di halaman dari nilai input
                                    $('#nama-profil-info').text(formData.name);
                                    $('#nama-info').text(formData.name);
                                    $('#email-info').text(formData.email);
                                    $('#no_telepon-info').text(formData.no_telepon);
                                    $('#alamat-info').text(formData.alamat);
                                    $('#jenis_kelamin-info').text(formData.jenis_kelamin);
                                });

                                // Anda bisa memperbarui elemen lainnya jika diperlukan
                            } else {
                                alert('Gagal memperbarui profil.');
                            }
                        },
                        error: function(xhr) {
                            // Tangani error
                            alert('Terjadi kesalahan saat memperbarui profil');
                        }
                    });
                });
            });
            $(document).ready(function() {
                // Handle form submit
                $('#update-password-form').submit(function(e) {
                    e.preventDefault(); // Prevent default form submission

                    // Get form data
                    let formData = {
                        password: $('#currentPassword').val(),
                        newpassword: $('#newPassword').val(),
                        renewpassword: $('#renewPassword').val(),
                        _token: $('input[name="_token"]').val() // Include CSRF token
                    };

                    $.ajax({
                        url: '/password/update/user', // Replace with your actual route
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle success response
                            if (response.message === true) {
                                alert('Password berhasil diperbarui!');
                                // Optionally, reset the form
                                $('#update-password-form')[0].reset();
                            } else {
                                alert(response.error || 'Gagal memperbarui password.');
                            }
                        },
                        error: function(xhr) {
                            // Handle error response
                            alert('Terjadi kesalahan');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
