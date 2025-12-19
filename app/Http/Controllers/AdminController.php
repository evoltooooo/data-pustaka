<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use SweetAlert2\Laravel\Swal;

use function Flasher\Toastr\Prime\toastr;

class AdminController extends Controller
{
    public function index(){
        $buku_count = Buku::all()->count();
        $user_count = User::all()->count();

        $buku_sedang_dipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->where('status', 'dipinjam');
        })->count();

        // Hitung buku sudah dikembalikan
        $buku_sudah_dikembalikan = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->where('status', 'dikembalikan');
        })->count();

        $total_buku_dipinjam = $buku_sedang_dipinjam + $buku_sudah_dikembalikan;

        return view('admin.index', compact('buku_count','user_count', 'total_buku_dipinjam'));
    }

    public function buku_index(){
        $buku = Buku::all();
        return view('admin.buku' , compact('buku'));
    }

    private function generateNoPanggil($penulis, $judul, $volume, $tahun)
    {
        $kodePenulis = strtoupper(substr($penulis, 0, 3));
        $words = preg_split('/\s+/', trim($judul));
        $kodeJudul = '';
            foreach ($words as $w) {
                $kodeJudul .= strtoupper(substr($w, 0, 1));
            }

        $vol = strtoupper($volume);

        $count = Buku::whereRaw('UPPER(penulis) = ?', [strtoupper($penulis)])
                 ->whereRaw('UPPER(judul) = ?', [strtoupper($judul)])
                 ->where('volume', $volume)
                 ->where('tahun_terbit', $tahun)
                 ->count() + 1;

        $increment = str_pad($count, 3, '0', STR_PAD_LEFT);

        return "{$kodePenulis}-{$kodeJudul}-{$vol}-{$tahun}-{$increment}";
    }

    public function saveBuku(Request $request){
        $data_buku = $request -> validate([
            'judul' => 'nullable|min:1|string',
            'penulis' => 'nullable|min:1|string',
            'penerbit' => 'nullable|min:1|string',
            'negara' => 'nullable|min:1|string',
            'deskripsi' => 'nullable|string',
            'jenis' => 'nullable|min:1|string',
            'genre' => 'nullable|min:1|string',
            'no_panggil' => 'min:1|string',
            'volume' => 'nullable|min:1|string',
            'halaman' => 'nullable|min:1|string',
            'ukuran' => 'nullable|min:1|string',
            'bahasa' => 'nullable|min:1|string',
            'issn' => 'nullable|min:1|string',
            'tahun_terbit' => 'nullable|min:1',
            'cover' => 'max:1024|mimes:png,jpg,jpeg,webp|file',
            'stok' => 'max:1024|integer'
        ]);
        
        $data_buku['no_panggil'] = $this->generateNoPanggil(
            $request->penulis,
            $request->judul,
            $request->volume,
            $request->tahun_terbit
        );

        $data_buku['stok'] = 1;

        if($request->has('cover')){
            $path = 'uploads/cover/';
            $imageName = time().'.'.$request->cover->getClientOriginalExtension();
            $upload = $request->cover->move($path, $imageName);
            
            if($upload){
                $manager = new ImageManager(new Driver());
                $resizedPath = $path.'thumbnail/';
                if( !File::isDirectory($resizedPath)){
                    File::makeDirectory($resizedPath, 0777, true, true);
                }
                $thumb = $manager->read($path.$imageName);
                $imageW = 359;
                $imageH = 478;
                $thumb->cover($imageW,$imageH);

                $encode = $thumb->toWebp();
                $thumbName = 'thumb_' . time() . '.webp';
                $encode->save(public_path($resizedPath.$thumbName));
            }

            $data_buku['cover']  = time();
        }
        else{
            $defaultImage = 'defaultcover.jpeg';
            $data_buku['cover'] = $defaultImage;
        }
        Buku::create($data_buku);
        toastr()->success('Berhasil mendaftarkan buku');    
        return redirect()->route('buku.index');
    }

    public function editBuku(Buku $buku){
        $negara = [
            'AF' => 'Afghanistan',
            'AX' => 'Åland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia, Plurinational State of',
            'BQ' => 'Bonaire, Sint Eustatius and Saba',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, the Democratic Republic of the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => "Côte d'Ivoire",
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CW' => 'Curaçao',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => "Korea, Democratic People's Republic of",
            'KR' => 'Korea, Republic of',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => "Lao People's Democratic Republic",
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia, the former Yugoslav Republic of',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States of',
            'MD' => 'Moldova, Republic of',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Réunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthélemy',
            'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin (French part)',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SX' => 'Sint Maarten (Dutch part)',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'SS' => 'South Sudan',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan, Province of China',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania, United Republic of',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela, Bolivarian Republic of',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        ];
        
        $bahasa = [
            'af' => 'Afrikaans',
            'sq' => 'Albanian',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'hy' => 'Armenian',
            'az' => 'Azerbaijani',
            'eu' => 'Basque',
            'be' => 'Belarusian',
            'bn' => 'Bengali',
            'bs' => 'Bosnian',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            'ceb' => 'Cebuano',
            'ny' => 'Chichewa',
            'zh-CN' => 'Chinese',
            'co' => 'Corsican',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'eo' => 'Esperanto',
            'et' => 'Estonian',
            'tl' => 'Filipino',
            'fi' => 'Finnish',
            'fr' => 'French',
            'fy' => 'Frisian',
            'gl' => 'Galician',
            'ka' => 'Georgian',
            'de' => 'German',
            'el' => 'Greek',
            'gu' => 'Gujarati',
            'ht' => 'Haitian Creole',
            'ha' => 'Hausa',
            'haw' => 'Hawaiian',
            'iw' => 'Hebrew',
            'hi' => 'Hindi',
            'hmn' => 'Hmong',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'ig' => 'Igbo',
            'id' => 'Indonesian',
            'ga' => 'Irish',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'jw' => 'Javanese',
            'kn' => 'Kannada',
            'kk' => 'Kazakh',
            'km' => 'Khmer',
            'ko' => 'Korean',
            'ku' => 'Kurdish (Kurmanji)',
            'ky' => 'Kyrgyz',
            'lo' => 'Lao',
            'la' => 'Latin',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'lb' => 'Luxembourgish',
            'mk' => 'Macedonian',
            'mg' => 'Malagasy',
            'ms' => 'Malay',
            'ml' => 'Malayalam',
            'mt' => 'Maltese',
            'mi' => 'Maori',
            'mr' => 'Marathi',
            'mn' => 'Mongolian',
            'my' => 'Myanmar (Burmese)',
            'ne' => 'Nepali',
            'no' => 'Norwegian',
            'ps' => 'Pashto',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'pa' => 'Punjabi',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sm' => 'Samoan',
            'gd' => 'Scots Gaelic',
            'sr' => 'Serbian',
            'st' => 'Sesotho',
            'sn' => 'Shona',
            'sd' => 'Sindhi',
            'si' => 'Sinhala',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'so' => 'Somali',
            'es' => 'Spanish',
            'su' => 'Sundanese',
            'sw' => 'Swahili',
            'sv' => 'Swedish',
            'tg' => 'Tajik',
            'ta' => 'Tamil',
            'te' => 'Telugu',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'cy' => 'Welsh',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba',
            'zu' => 'Zulu'
        ];

        $bhs = $bahasa[$buku->bahasa] ?? 'Unknown';
        $ngr = $negara[$buku->negara] ?? 'Unknown';
        return view('admin.modals.editbookform' , compact('buku','bhs','ngr'));
    }

    public function updateBuku(Request $request , Buku $buku){
        $data_buku = $request -> validate([
            'judul' => 'min:1|string',
            'penulis' => 'min:1|string',
            'penerbit' => 'min:1|string',
            'negara' => 'min:1|string',
            'deskripsi' => 'nullable|string',
            'jenis' => 'min:1|string',
            'genre' => 'min:1|string',
            'no_panggil' => 'min:1|string',
            'volume' => 'min:1|string',
            'halaman' => 'min:1|string',
            'ukuran' => 'min:1|string',
            'bahasa' => 'min:1|string',
            'issn' => 'min:1|string',
            'tahun_terbit' => 'min:1',
            'cover' => 'max:1024|mimes:png,jpg,jpeg,webp|file'
        ]);
        
        $penulisChanged = strtoupper($buku->penulis) !== strtoupper($request->penulis);
        $volumeChanged  = $buku->volume !== $request->volume;
        $tahunChanged   = $buku->tahun_terbit != $request->tahun_terbit;

        if ($penulisChanged || $volumeChanged || $tahunChanged) {
        $data_buku['no_panggil'] = $this->generateNoPanggil(
            $request->penulis,
            $request->judul,
            $request->volume,
            $request->tahun_terbit
        );
        } else {
            $data_buku['no_panggil'] = $buku->no_panggil;
        }


        if($request->has('cover')){
            $path = 'uploads/cover/';
            $imageName = time().'.'.$request->cover->getClientOriginalExtension();
            $upload = $request->cover->move($path, $imageName);
            
            if($upload){
                $manager = new ImageManager(new Driver());
                $resizedPath = $path.'thumbnail/';
                if( !File::isDirectory($resizedPath)){
                    File::makeDirectory($resizedPath, 0777, true, true);
                }
                $thumb = $manager->read($path.$imageName);
                $imageW = 359;
                $imageH = 478;
                $thumb->cover($imageW,$imageH);

                $encode = $thumb->toWebp();
                $thumbName = 'thumb_' . time() . '.webp';
                $encode->save(public_path($resizedPath.$thumbName));
            }

            $data_buku['cover']  = time();
        }

        $buku -> update($data_buku);
        if($buku){
            toastr()->success('Berhasil mengupdate buku');
            return redirect()->route('buku.index');
        }
        else{
            toastr()->error('Gagal mengupdate buku');
            return $request -> all();
        }
    }

    public function deleteBuku(Buku $buku){
        
        $buku -> delete();
        toastr()->success('Berhasil menghapus buku');
        return redirect()->route('buku.index');
    }

    public function updatePeminjaman(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $statusBaru = $request->status;

        $peminjaman->status = $statusBaru;
        $peminjaman->save();

        // Ambil semua detail buku yang dipinjam
        $details = DetailPeminjaman::where('idPeminjaman', $id)->get();

        // JIKA STATUS MENJADI DIPINJAM
        if ($statusBaru == 'dipinjam') {

            foreach ($details as $detail) {
                $buku = Buku::find($detail->idBuku);
                if ($buku) {
                    $buku->stok = 0;   // stok habis
                    $buku->save();
                }
            }
        }

        // JIKA STATUS DIKEMBALIKAN
        if ($statusBaru == 'dikembalikan') {

            foreach ($details as $detail) {
                $buku = Buku::find($detail->idBuku);
                if ($buku) {
                    $buku->stok = 1;   // stok kembali tersedia
                    $buku->save();
                }
            }
        }

        // JIKA DITOLAK → stok tidak berubah sama sekali

        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}
