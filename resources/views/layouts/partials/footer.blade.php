<!-- Footer Background -->
<footer
    style="display: flex; justify-content: center;gap: 100px; padding: 30px 30px; background-color: #3A7CA5; color: #b0b7c1; flex-wrap: wrap;">

    <!-- Footer Detail -->
    <div style="max-width: 300px;">
        <p style="font-size: 18px; font-weight: bold;color:white; margin: 0;">Data Pustaka</p>
        <p class="contact-item">
            <i class="fas fa-map-marker-alt contact-icon"></i> Universitas Indonesia, Gedung Perpustakaan,
            Politeknik Negeri Jakarta, Kukusan, Beji, Depok City, West Java 16425
        </p>
        <iframe style="margin-top: 10px"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.1699021834083!2d106.82350997503886!3d-6.372053793618161!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ed4d4603d62b%3A0x4fca4e63035ce1e2!2sPoliteknik%20Negeri%20Jakarta%20Library!5e0!3m2!1sen!2sid!4v1761844802541!5m2!1sen!2sid"
            width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Footer Menu -->
    <div>
        <p style="font-weight:bold; color:white; margin-bottom:10px;">LAYANAN</p>
        <ul class="footer-nav" style="list-style:none; padding:0; margin:0; font-size:14px; line-height:1.8;">
            <a href="#" style="color:#fff; text-decoration:none; display:block;">Waktu Layanan</a>
            <a href="#" style="color:#fff; text-decoration:none; display:block;">Layanan Referensi</a>
            <a href="#" style="color:#fff; text-decoration:none; display:block;">Peraturan Perpustakaan</a>
            <a href="#" style="color:#fff; text-decoration:none; display:block;">Panduan</a>
        </ul>
    </div>

    <!-- Footer Kategori -->
    <div>
        <p style="font-weight:bold; color:white; margin-bottom:10px;">KATEGORI</p>
        <ul class="footer-nav" style="list-style:none; padding:0; margin:0; font-size:14px; line-height:1.8;">
           <a href="{{ url('/koleksi?kategori=buku-paket') }}" style="color:#fff; text-decoration:none; display:block;">Buku-Paket</a>

            <a href="{{ url('/koleksi?kategori=ensiklopedia') }}" style="color:#fff; text-decoration:none; display:block;">Ensiklopedia</a>

            <a href="{{ url('/koleksi?kategori=komik') }}" style="color:#fff; text-decoration:none; display:block;">Komik</a>

            <a href="{{ url('/koleksi?kategori=majalah') }}" style="color:#fff; text-decoration:none; display:block;">Majalah</a>

            <a href="{{ url('/koleksi?kategori=novel') }}" style="color:#fff; text-decoration:none; display:block;">Novel</a>

            <a href="{{ url('/koleksi?kategori=referensi') }}" style="color:#fff; text-decoration:none; display:block;">Referensi</a>

            <a href="{{ url('/koleksi?kategori=lainnya') }}" style="color:#fff; text-decoration:none; display:block;">Lainnya</a>

        </ul>
    </div>

    <!-- Footer SocMed -->
    <div style="overflow: visible;">
        <p style="font-weight:bold; color:white; margin-bottom:10px;">FOLLOW US</p>

        <div class="social-icon">
            <a href="#"><img src="{{ asset('images/facebook.png') }}" alt="Facebook"></a>
            <div class="social-preview">
                <img class="thumb" src="{{ asset('images/prabowo.jpeg') }}" alt="">
                <strong>Facebook</strong><br>
                Data Pustaka
            </div>
        </div>

        <div class="social-icon">
            <a href="#"><img src="{{ asset('images/twitter.png') }}" alt="X"></a>
            <div class="social-preview">
                <img class="thumb" src="{{ asset('images/prabowo2.jpeg') }}" alt="">
                <strong>X / Twitter</strong><br>
                @datapustaka
            </div>
        </div>

        <div class="social-icon">
            <a href="https://www.instagram.com/rifkyagungardian?igsh=djBqMzZvanIyaGNj">
                <img src="{{ asset('images/instagram.png') }}" alt="Instagram">
            </a>
            <div class="social-preview">
                <img class="thumb" src="{{ asset('images/jokowi.jpeg') }}" alt="">
                <strong>Instagram</strong><br>
                @datapustaka
            </div>
        </div>

        <div class="social-icon">
            <a href="#"><img src="{{ asset('images/tiktok.png') }}" alt="TikTok"></a>
            <div class="social-preview">
                <img class="thumb" src="{{ asset('images/perpus1.jpg') }}" alt="">
                <strong>TikTok</strong><br>
                @datapustaka
            </div>
        </div>
    </div>
</footer>

<!-- Footer Copyright -->
<div
    style="width:100%; text-align:center; border-top:1px solid #2c3e50; background-color:#3A7CA5; padding:15px 0; font-size:13px; color:#bbb;">
    © 2025 — ARSIP DATA PUSTAKA LIBRARY | Dibuat oleh:
    <a href="#" target="_blank" style="color:#fc0000; text-decoration:none;">RRK</a>
</div>

<!-- Script buat interaktif -->
<script>
    document.querySelectorAll('.contact-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>
