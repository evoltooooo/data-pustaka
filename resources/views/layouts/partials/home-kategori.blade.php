{{-- =========================== --}}
{{--     KATEGORI UTAMA         --}}
{{-- =========================== --}}

<section id="kategori-section" class="py-4">
    <div class="container text-center">
        <h2 class="mb-4">Pilih kategori yang menarik bagi Anda</h2>

    <div class="kategori-grid">

        <a href="{{ url('/koleksi?kategori=buku-paket') }}" class="kategori-card bg-purple" data-kategori="buku-paket">
            <i class="icon fas fa-book"></i>
            <p>Buku-Paket</p>
        </a>

        <a href="{{ url('/koleksi?kategori=ensiklopedia') }}" class="kategori-card bg-blue" data-kategori="ensiklopedia">
            <i class="icon fas fa-globe"></i>
            <p>Ensiklopedia</p>
        </a>

        <a href="{{ url('/koleksi?kategori=komik') }}" class="kategori-card bg-yellow" data-kategori="komik">
            <i class="icon fas fa-smile"></i>
            <p>Komik</p>
        </a>

        <button type="button" class="kategori-card bg-green btn-open-modal" aria-haspopup="dialog" aria-controls="kategoriModal">
            <i class="icon fas fa-th"></i>
            <p>Lainnya</p>
        </button>

    </div>
</div>

</section>

{{-- =============================== --}}
{{--         MODAL KATEGORI          --}}
{{-- =============================== --}}

<div id="kategoriModal" class="kategori-modal" role="dialog" aria-modal="true" aria-hidden="true" style="display:none;">
    <div class="kategori-modal-content">
        <button type="button" class="kategori-close" aria-label="Tutup">
    <i class="fas fa-times"></i>
</button>

        <h4 class="text-center mb-4">Semua Kategori</h4>

    <div class="modal-grid">

        <a href="{{ url('/koleksi?kategori=buku-paket') }}" class="kategori-card bg-purple" data-kategori="buku-paket">
            <i class="icon fas fa-book"></i>
            <p>Buku-Paket</p>
        </a>

        <a href="{{ url('/koleksi?kategori=ensiklopedia') }}" class="kategori-card bg-blue" data-kategori="ensiklopedia">
            <i class="icon fas fa-globe"></i>
            <p>Ensiklopedia</p>
        </a>

        <a href="{{ url('/koleksi?kategori=komik') }}" class="kategori-card bg-yellow" data-kategori="komik">
            <i class="icon fas fa-smile"></i>
            <p>Komik</p>
        </a>

        <a href="{{ url('/koleksi?kategori=majalah') }}" class="kategori-card bg-pink" data-kategori="majalah">
            <i class="icon fas fa-newspaper"></i>
            <p>Majalah</p>
        </a>

        <a href="{{ url('/koleksi?kategori=novel') }}" class="kategori-card bg-orange" data-kategori="novel">
            <i class="icon fas fa-book-open"></i>
            <p>Novel</p>
        </a>

        <a href="{{ url('/koleksi?kategori=referensi') }}" class="kategori-card bg-red" data-kategori="referensi">
            <i class="icon fas fa-folder-open"></i>
            <p>Referensi</p>
        </a>

        <a href="{{ url('/koleksi?kategori=lainnya') }}" class="kategori-card bg-green" data-kategori="lainnya">
            <i class="icon fas fa-th"></i>
            <p>Lainnya</p>
        </a>

    </div>
</div>


</div>

{{-- ========================= --}}
{{--      SCRIPT (INLINE)     --}}
{{-- ========================= --}}

<script>
(function(){
    const modal = document.getElementById('kategoriModal');
    const openBtns = document.querySelectorAll('.btn-open-modal');
    const closeBtn = modal ? modal.querySelector('.kategori-close') : null;

    function openModal() {
        if (!modal) return;
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
        // scroll ke atas modal content saat dibuka
        const content = modal.querySelector('.kategori-modal-content');
        if (content) content.scrollTop = 0;
    }

    function closeModal() {
        if (!modal) return;
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    }

    // open buttons (like 'Lainnya')
    openBtns.forEach(b => b.addEventListener('click', openModal));

    // close via close button
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    // close by clicking overlay (outside content)
    window.addEventListener('click', function(e){
        if (!modal) return;
        if (e.target === modal) closeModal();
    });

    // close with Esc
    window.addEventListener('keydown', function(e){
        if (!modal) return;
        if (e.key === 'Escape') closeModal();
    });

    // Accessibility: trap focus inside modal while open (basic)
    document.addEventListener('focus', function(e){
        if (!modal || modal.style.display === 'none') return;
        const content = modal.querySelector('.kategori-modal-content');
        if (content && !content.contains(e.target)) {
            // move focus back to content
            content.focus();
        }
    }, true);

})();
</script>
