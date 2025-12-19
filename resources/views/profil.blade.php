        @extends ('layouts.app')

        @push('styles')
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const tabs = document.querySelectorAll(".loan-tab");

                    tabs.forEach(tab => {
                        tab.addEventListener("click", function() {

                            tabs.forEach(t => t.classList.remove("active"));

                            this.classList.add("active");
                        });
                    });
                });
            </script>
            <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
        @endpush

        @section('content')
            <div class="profil-page-wrapper">
                <div class="profile-container">

                    <div class="row mt-4">

                        <div class="col-md-12">
                            <div class="profile-section-title">
                                Page Profile
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row align-items-stretch">
                                <div class="col-md-4 mb-4 d-flex">
                                    <div class="profile-card-left w-100 h-100">
                                        <div class="profile-card-left-header">
                                            <div class="profile-avatar">
                                                <img src="{{ asset('uploads/profile/' . $user->photo) }}"
                                                    class="profile-avatar-img">
                                            </div>
                                        </div>

                                        <div class="profile-card-left-body">
                                            <h5 class="profile-title-left mb-3">{{ $user->name }}</h5>

                                            <div class="member-id-card mb-3">
                                                <div class="member-id-icon">
                                                    <i class="fas fa-id-card"></i>
                                                </div>

                                                <div class="member-id-text">
                                                    <strong>{{ $user->no_user }}</strong>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2">
                                                <button class="btn btn-outline-primary btn-sm profile-btn" data-toggle="modal"
                                                    data-target="#modalFoto">
                                                    Ubah Foto Profile
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 mb-4 d-flex">
                                    <div class="profile-card-right w-100 h-100">

                                        <div class="profile-card-right-header d-flex justify-content-between align-items-center">
                                            Profil Lengkap
                                            <button class="btn-edit-glass edit-btn">
                                                <i class = "fas fa-pen"> </i>
                                                Edit
                                            </button>
                                        </div>

                                        <div class="profile-card-right-body">

                                            <div class="profile-detail-row row">
                                                <div class="col-md-5 text-muted">Nama</div>
                                                <div class="col-md-7 mb-2">{{ $user->name }}</div>
                                            </div>

                                            <div class="profile-detail-row row">
                                                <div class="col-md-5 text-muted">Email</div>
                                                <div class="col-md-7 mb-2">{{ $user->email }}</div>
                                            </div>

                                            <div class="profile-detail-row row">
                                                <div class="col-md-5 text-muted">Nomor Telepon</div>
                                                <div class="col-md-7 mb-2">
                                                    @if (!$user->no_telp)
                                                        -
                                                    @else
                                                        {{ $user->no_telp }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <h4 class="subsection-title">Koleksi Dipinjam</h4>
                        </div>

                        <div class="col-md-12">
                            <div class="loan-card">
                                <div class="loan-card-body">
                                    <div class="loan-tabs">
                                    </div>

                                    <div class="loan-table-area">
                                        <table id="example2" class="table table-bordered table-hover ml-auto">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nomor Peminjaman</th>
                                                <th>Buku yang Dipinjam</th>
                                                <th>Tanggal Peminjaman</th>
                                                <th>Tanggal Kembali</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($peminjaman as $p)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>

                                                        <td>{{ $p->no_peminjaman }}</td>

                                                        <td class="cover-info">
                                                            @foreach ($p->details as $d)
                                                                <img class=""
                                                                    src="{{ url('uploads/cover/thumbnail/thumb_' . $d->buku->cover . '.webp') }}">
                                                                {{ $d->buku->judul }} <br>
                                                            @endforeach
                                                        </td>

                                                        <td>{{ $p->tanggal_pinjam }}</td>

                                                        <td>{{ $p->tanggal_kembali }}</td>

                                                        <td id="status">
                                                            @if ($p->status == 'pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                            @elseif ($p->status == 'dipinjam')
                                                                <span class="badge bg-primary">Sedang Dipinjam</span>
                                                                <span class="countdown"
                                                                    data-deadline="{{ $p->batas_tanggal_kembali }}">
                                                                </span>

                                                                {{-- @elseif ($p->status == 'jatuh_tempo')
                                                            <span class="badge bg-danger">Sudah Jatuh Tempo</span> --}}
                                                            @elseif ($p->status == 'dikembalikan')
                                                                <span class="badge bg-success">Dikembalikan</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($p->status == 'dipinjam')
                                                                <button class="btn btn-kembalikan btn-primary btn-confirm-return"
                                                                    data-id="{{ $p->idPeminjaman }}" type="button">
                                                                    Kembalikan
                                                                </button>
                                                            @else
                                                                <button class="btn btn-kembalikan btn-secondary" disabled>
                                                                    Kembalikan
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="loan-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body text-center">
                            <h1><i class="fas fa-info-circle"></i></h1>
                            <h5>Apakah Anda yakin ingin mengembalikan buku?</h5>
                            <small>Pastikan buku telah dikembalikan ke perpustakaan!</small>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <form id="returnForm" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success mr-3">Kembalikan</button>
                            </form>
                            <button class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalFoto" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('profil.updateFoto') }}" method="POST" enctype="multipart/form-data"
                        class="modal-content">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Foto Profil</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <label>Foto Baru</label>
                            <input type="file" name="photo" class="form-control" required accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP | Maks: 2MB</small>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="modal fade" id="modalEditProfile" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('profil.updateData') }}" method="POST" class="modal-content">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profil</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" 
                            value="{{ $user->name }}" required>

                        <label class="mt-3">Email</label>
                        <input type="email" name="email" class="form-control" 
                            value="{{ $user->email }}" required>

                        <label class="mt-3">Nomor Telepon</label>
                        <input type="text" name="no_telp" class="form-control" 
                            value="{{ $user->no_telp }}">

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>

                </form>
            </div>
        </div>

            <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#example2').DataTable();
                });
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    function updateCountdown() {
                        document.querySelectorAll(".countdown").forEach(function(el) {

                            let deadline = new Date(el.dataset.deadline).getTime();
                            let now = new Date().getTime();
                            let diff = deadline - now;

                            if (diff <= 0) {
                                el.innerHTML = "<span class='badge bg-danger'>Sudah Jatuh Tempo</span>";
                                return;
                            }

                            let days = Math.floor(diff / (1000 * 60 * 60 * 24));

                            el.innerHTML = `
                                <span class="badge bg-success">
                                    Waktu Pengembalian: ${days} hari
                                </span>
                            `;
                        });
                    }

                    updateCountdown();
                    setInterval(updateCountdown, 86400000);
                });

                document.addEventListener("DOMContentLoaded", function() {

                    document.querySelectorAll(".btn-confirm-return").forEach(btn => {
                        btn.addEventListener("click", function() {

                            let id = this.dataset.id;

                            document.getElementById("returnForm").action = "/profil/return/" + id;

                            $("#returnModal").modal("show");
                        });
                    });

                });

                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelector(".edit-btn").addEventListener("click", function() {
                        $("#modalEditProfile").modal("show");
                    });
                });
            </script>
@endsection
