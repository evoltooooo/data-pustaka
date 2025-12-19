@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/peminjaman.css') }}">
@endpush

@section('content')

<div class="peminjaman-wrapper" style="padding-top: 110px";>


    <div class="page-container">

        <!-- PANEL UTAMA -->
        <div class="main-panel">
            <h2 class="table-title">Daftar Peminjaman</h2>

            <div class="book-table">

                <div class="book-row header">
                    <input type="checkbox" id="check-all">
                    <span>Buku</span>
                    <span>No. Panggil</span>
                    <span>Aksi</span>
                </div>

                @foreach ($items as $i)
                <div class="book-row">
                    <input type="checkbox" class="check-item">

                    <div class="book-info">
                        <img src="{{ url('uploads/cover/thumbnail/thumb_'. $i->buku->cover .'.webp') }}">
                        <div>
                            <h5>{{ $i->buku->judul }}</h5>
                            <small>{{ $i->buku->penulis }}</small>
                        </div>
                    </div>

                   <span class="no-panggil">{{ $i->buku->no_panggil }}</span>
                    <a href="{{route('peminjaman.delete', $i->idCartItem) }}">
                        <button class="hapus-btn">Hapus</button>
                    </a>
                </div>
                @endforeach

            </div>
        </div>

        <!-- PANEL SIDEBAR -->
        <aside class="sidebar-detail">

            <h2>Ringkasan Peminjaman</h2>

            <div class="detail-section">
                <label>Total Item</label>
                <p class="detail-value"><strong>{{$item_count}} Buku</strong></p>
            </div>

            <div class="detail-section">
                <label for="tanggal_pinjam">Tanggal Peminjaman</label>
                <input type="date" id="tanggal_pinjam" class="detail-input form-control">

                <label for="tanggal_kembali" class="mt-3">Batas Pengembalian</label>
                <input type="date" id="batas_tanggal_kembali" class="detail-input form-control" readonly>

                <input type="hidden" id="tanggal_pinjam_hidden">
                <input type="hidden" id="batas_tanggal_kembali_hidden">
            </div>

            <div class="detail-section note">
                <small>Jika melewati batas pengembalian, Anda dapat dikenakan denda.</small>
            </div>
                <button type="button" class="btn-konfirmasi" id="openModal">
                    Konfirmasi Peminjaman
                </button>
        </aside>

    </div>
</div>

<div class="modal fade" id="konfirmModal" tabindex="1" aria-labelledby="konfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="pinjamModalLabel">Konfirmasi Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                Apakah Anda telah yakin ingin meminjam?
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <form id="modalSubmitForm" action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="tanggal_pinjam" id="modal_tanggal_pinjam">
                    <input type="hidden" name="batas_tanggal_kembali" id="modal_batas_kembali">

                    <button type="submit" class="btn btn-success btn-submit mr-5">Ya</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto tanggal kembali
document.getElementById("tanggal_pinjam").addEventListener("change", function () {
    let pinjamDate = new Date(this.value);
    if (!isNaN(pinjamDate.getTime())) {

        pinjamDate.setDate(pinjamDate.getDate() + 14);
        let hari = String(pinjamDate.getDate()).padStart(2, '0');
        let bulan = String(pinjamDate.getMonth() + 1).padStart(2, '0');
        let tahun = pinjamDate.getFullYear();

        let formatted = `${tahun}-${bulan}-${hari}`;

        let tampilFormat = `${tahun}-${bulan}-${hari}`;

        document.getElementById("batas_tanggal_kembali").value = tampilFormat;

        document.getElementById("tanggal_pinjam_hidden").value = this.value;
        document.getElementById("batas_tanggal_kembali_hidden").value = formatted;
    }
});

// CHECKBOX SELECT ALL
document.addEventListener("DOMContentLoaded", () => {
    const checkAll = document.getElementById('check-all');
    const items = document.querySelectorAll('.check-item');

    if (!checkAll) return;

    checkAll.addEventListener('change', () => {
        items.forEach(i => i.checked = checkAll.checked);
    });

    items.forEach(i => {
        i.addEventListener('change', () => {
            checkAll.checked = [...items].every(x => x.checked);
        });
    });
});

document.getElementById("openModal").addEventListener("click", function () {

    // copy hidden input ke modal (agar data tetap terkirim)
    let tglPinjam = document.getElementById("tanggal_pinjam_hidden").value;
    let tglKembali = document.getElementById("batas_tanggal_kembali_hidden").value;

    document.getElementById("modal_tanggal_pinjam").value = tglPinjam;
    document.getElementById("modal_batas_kembali").value = tglKembali;

    // tampilkan modal
    $("#konfirmModal").modal("show");  
});

// $(".btn-pinjam").click(function () {
//         $("#pinjamModal").modal("show");
//     });
</script>
@endpush
