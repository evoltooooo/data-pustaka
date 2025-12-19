@extends('layouts.adminapp')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="callout bg-dark callout-warning">
                    <h5 class="font-weight-bold"><i class="fas fa-handshake pr-3"></i>Menunggu Konfirmasi</h5>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="callout bg-dark callout-warning">
                    <!-- /.card-header -->
                        <table id="pending_table" class="table table-dark table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Peminjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $nomor => $rows)
                            
                            <tr>
                                @php
                                    $first = $rows->first();
                                @endphp
                                <td>{{$loop -> iteration}}</td>
                                <td>{{$nomor}}</td>
                                <td>{{$first->user->name}}</td>
                                <td>{{$first->tanggal_pinjam}}</td>
                                <td>
                                    <a>
                                        <button class="btn btn-primary btn-konfirmasi"
                                        data-id="{{ $first->idPeminjaman }}" 
                                        data-nomor="{{ $nomor }}"
                                        data-nama="{{ $first->user->name }}"
                                        data-tglpinjam="{{ $first->tanggal_pinjam }}"
                                        data-batas="{{ $first->batas_tanggal_kembali }}"
                                        data-detail="{{ $rows->flatMap(function($r){
                                                return $r->details->map(function($d){
                                                    return [
                                                        'judul' => $d->buku->judul ?? 'Buku tidak ditemukan',
                                                        'no_panggil' => $d->buku->no_panggil ?? '-'
                                                    ];
                                                });
                                            })->values()->toJson() }}">
                                            Konfirmasi
                                        </button>
                                    </a>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                        </table>
                    <!-- /.card-body -->
                 </div>
            </div>

            <div class="col-sm-12 mt-4">
                <div class="callout bg-dark callout-info">
                    <h5 class="font-weight-bold"><i class="fas fa-handshake pr-3"></i>Data Peminjaman</h5>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="callout bg-dark callout-info">
                    <!-- /.card-header -->
                        <table id="detail_table"  class="table table-dark table-bordered table-hover ml-auto">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Peminjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($non_pending as $nomor => $rows)
                            <tr>
                                @php
                                    $first = $rows->first();
                                @endphp
                                <td>{{$loop -> iteration}}</td>
                                <td>{{$nomor}}</td>
                                <td>{{ $first->user->name }}</td>
                                <td>{{ $first->tanggal_pinjam }}</td>
                                <td>{{ $first->tanggal_kembali ?? '-' }}</td>
                                <td>
                                    @if ($first->status == 'dipinjam')
                                        <span class="badge badge-success">Dipinjam</span>
                                    @elseif ($first->status == 'ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif ($first->status == 'dikembalikan')
                                        <span class="badge badge-success">Dikembalikan</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $first->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-detail"
                                    data-nomor="{{ $nomor }}"
                                    data-nama="{{ $first->user->name }}"
                                    data-tglpinjam="{{ $first->tanggal_pinjam }}"
                                    data-tglkembali="{{ $first->tanggal_kembali }}"
                                    data-batas="{{ $first->batas_tanggal_kembali }}"
                                    data-detail="{{ $rows->flatMap(function($r){
                                        return $r->details->map(function($d){
                                            return [
                                                'judul' => $d->buku->judul ?? 'Buku tidak ditemukan',
                                                'no_panggil' => $d->buku->no_panggil ?? '-'
                                            ];
                                        });
                                    })->values()->toJson() }}">
                                    Detail
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    <!-- /.card-body -->
                 </div>
            </div>

        </div>
    </div>


<div class="modal fade" id="konfirmModal" tabindex="1" aria-labelledby="konfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">

            <div class="modal-header">
                <h5 class="modal-title" id="">Konfirmasi Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Nomor Peminjaman:</strong></p>
                        <p><strong>Nama Peminjam:</strong></p>
                        <p><strong>Tanggal Peminjaman:</strong></p>
                        <p><strong>Batas Pengembalian:</strong></p>
                    </div>
                    <div class="col-sm-6">
                        <p><span id="modal-nomor"></span></p>
                        <p><span id="modal-nama"></span></p>
                        <p><span id="modal-tglpinjam"></span></p>
                        <p><span id="modal-batas"></span></p>
                    </div>
                </div>

                <hr>
                <p><strong>Daftar Buku:</strong></p>
                <ul id="modal-daftarbuku"></ul>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <form id="form-konfirm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idBuku" id="konfirmModal-idbuku">
                    <input type="hidden" id="modal-id" value="">
                    <button type="submit" class="btn btn-success btn-terima mr-3">Terima</button>
                    <button type="submit" class="btn btn-danger btn-tolak">Tolak</button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="1" aria-labelledby="konfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">

            <div class="modal-header">
                <h5 class="modal-title" id="">Detail Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Nomor Peminjaman:</strong></p>
                        <p><strong>Nama Peminjam:</strong></p>
                        <p><strong>Tanggal Peminjaman:</strong></p>
                        <p><strong>Batas Pengembalian:</strong></p>
                        <p><strong>Tanggal Pengembalian:</strong></p>
                    </div>
                    <div class="col-sm-6">
                        <p><span id="detail-nomor"></span></p>
                        <p><span id="detail-nama"></span></p>
                        <p><span id="detail-tglpinjam"></span></p>
                        <p><span id="detail-batas"></span></p>
                        <p><span id="detail-tglkembali"></span> <span id="detail-status"></span></p>
                    </div>
                </div>

                <hr>
                <p><strong>Daftar Buku:</strong></p>
                <ul id="detail-daftarbuku"></ul>
            </div>

        </div>
    </div>
</div>
</section>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script> 
    <script>
        $(document).ready( function () {
            $('#pending_table').DataTable();
            $('#detail_table').DataTable();
            

            $('.btn-konfirmasi').click(function () {
                // Ambil data dari tombol
                let nomor      = $(this).data("nomor");
                let nama       = $(this).data("nama");
                let tglPinjam  = $(this).data("tglpinjam");
                let batas      = $(this).data("batas");
                let detail     = $(this).data("detail"); // array dari laravel
                let id = $(this).data("id");
                $("#modal-id").val(id);

                // Isi ke modal
                $("#modal-nomor").text(nomor);
                $("#modal-nama").text(nama);
                $("#modal-tglpinjam").text(tglPinjam);
                $("#modal-batas").text(batas);

                // Isi daftar buku
                $("#modal-daftarbuku").empty();

                detail.forEach(function(item){
                    $("#modal-daftarbuku").append(`<li>${item.judul} ${item.no_panggil}</li>`);
                });

                $("#konfirmModal").modal("show");
            });

                $('.btn-terima').click(function () {
                    let id = $("#modal-id").val();
                    let url = "/manajemen/terima/" + id;
                    $("#form-konfirm").attr("action", url);
                });

                $('.btn-tolak').click(function () {
                    let id = $("#modal-id").val();
                    let url = "/manajemen/tolak/" + id;
                    $("#form-konfirm").attr("action", url);
                });

                $('.btn-detail').click(function () {
                    let nomor      = $(this).data("nomor");
                    let nama       = $(this).data("nama");
                    let tglPinjam  = $(this).data("tglpinjam");
                    let batas      = $(this).data("batas");
                    let tglKembali = $(this).data("tglkembali");
                    let detail     = $(this).data("detail");

                    // Isi modal
                    $("#detailModal #detail-nomor").text(nomor);
                    $("#detailModal #detail-nama").text(nama);
                    $("#detailModal #detail-tglpinjam").text(tglPinjam);
                    $("#detailModal #detail-batas").text(batas);
                    $("#detailModal #detail-tglkembali").text(tglKembali);
                    
                    let statusText = "";
                    let statusClass = "";

                    if (!tglKembali) {
                        statusText = "-";
                    } else {
                        let d1 = new Date(tglKembali);
                        let d2 = new Date(batas);

                        let diffTime = d1 - d2;
                        let diffDay = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDay > 0) {
                            statusText = `(Terlambat ${diffDay} hari).`;
                            statusClass = "text-danger"; 
                        } else {
                            statusText = "(Dikembalikan tepat waktu).";
                            statusClass = "text-success"; 
                        }
                    }

                    $("#detail-status").text(statusText).removeClass("text-danger text-success").addClass(statusClass);

                    // Isi daftar buku
                    $("#detailModal #detail-daftarbuku").empty();
                    detail.forEach(function(item){
                        $("#detailModal #detail-daftarbuku")
                            .append(`<li>${item.judul} (${item.no_panggil})</li>`);
                    });

                    $("#detailModal").modal("show");
                });
        } );
    </script>
@endsection