    <?php

    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\AkunController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\KeranjangController;
    use App\Http\Controllers\KoleksiController;
    use App\Http\Controllers\PeminjamanController;
    use App\Models\Keranjang;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\BukuController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ManajemenPeminjamanController;
    use App\Http\Controllers\ProfilController;

    Route::redirect('/', '/login', 301);

    //Auth Page
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
        //Admin Page
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


        Route::get('/buku', [AdminController::class, 'buku_index'])->name('buku.index');
        Route::get('/buku/{buku}/edit', [AdminController::class, 'editBuku'])->name('editBuku');
        Route::get('/buku/add', function () {
            return view('admin.modals.addbookform');
        });
        Route::post('/insert', [AdminController::class, 'saveBuku'])->name('saveBuku');
        Route::put('/update/{buku}', [AdminController::class, 'updateBuku'])->name('updateBuku');
        Route::post('/delete/{buku}', [AdminController::class, 'deleteBuku'])->name('deleteBuku');

        Route::get('/manajemen', [ManajemenPeminjamanController::class, 'index'])->name('manajemen.index');
        Route::post('/manajemen/terima/{no}', [ManajemenPeminjamanController::class, 'terima'])->name('manajemen.terima');
        Route::post('/manajemen/tolak/{no}', [ManajemenPeminjamanController::class, 'tolak'])->name('manajemen.tolak');

        Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    });

    Route::group(['middleware' => ['auth', 'check_role:user,admin   ']], function () {
        //user Page
        Route::get('/waktu', function () {
            return view('waktu');
        })->name('waktu');

        Route::get('/peraturan', function () {
            return view('peraturan');
        })->name('peraturan');

        Route::get('/panduan', function () {
            return view('panduan');
        })->name('panduan');

        Route::get('/referensi', function () {
            return view('referensi');
        })->name('referensi');




        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::post('/home/rating/{buku}', [HomeController::class, 'rating'])->name('home.rating');

        Route::get('/koleksi', [KoleksiController::class, 'index'])->name('koleksi');
        Route::get('/koleksi/detail/{buku}', [KoleksiController::class, 'detail'])->name('detail');
        Route::post('/koleksi/rating/{buku}', [KoleksiController::class, 'rating'])->name('rating');
        Route::post('/koleksi/detail/add', [KoleksiController::class, 'addKeranjang'])->name('detail.add');

        // AJAX FILTER — HARUS BEGINI
        Route::get('/koleksi-filter', [KoleksiController::class, 'filter'])
            ->name('koleksi.filter');

        Route::get('/peminjaman', [KeranjangController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/delete{idCartItem}', [KeranjangController::class, 'remove'])->name('peminjaman.delete');
        Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');

        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::post('/profil/return/{idPeminjaman}', [PeminjamanController::class, 'return'])->name('peminjaman.return');
        Route::post('/profil/update-foto', [ProfilController::class, 'updateFoto'])->name('profil.updateFoto');
        Route::post('/profil/update-data', [ProfilController::class, 'updateData'])->name('profil.updateData');
    });

    use App\Http\Controllers\SearchController;

    Route::get('/search-demo', [SearchController::class, 'index'])->name('search.demo');
    Route::get('/search', [SearchController::class, 'search'])->name('search.do');
    Route::get('/search/suggest', [SearchController::class, 'suggest'])->name('search.suggest');
    Route::get('/search/history', [SearchController::class, 'history'])->name('search.history');
    Route::delete('/search/history', [SearchController::class, 'clearHistory'])->name('search.history.clear');
    Route::delete('/search/history/{id}', [SearchController::class, 'deleteHistory'])->name('search.history.delete');
