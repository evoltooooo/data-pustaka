<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\BukuRating;



class KoleksiController extends Controller
{
     // =====================================
    // FULL LANGUAGE LIST (untuk filter)
    // =====================================
    private $languageList = ['id' => 'Indonesian','en' => 'English',
        'af' => 'Afrikaans','sq' => 'Albanian','am' => 'Amharic','ar' => 'Arabic',
        'hy' => 'Armenian','az' => 'Azerbaijani','eu' => 'Basque','be' => 'Belarusian',
        'bn' => 'Bengali','bs' => 'Bosnian','bg' => 'Bulgarian','ca' => 'Catalan',
        'ceb' => 'Cebuano','ny' => 'Chichewa','zh-CN' => 'Chinese','co' => 'Corsican',
        'hr' => 'Croatian','cs' => 'Czech','da' => 'Danish','nl' => 'Dutch',
        'eo' => 'Esperanto','et' => 'Estonian','tl' => 'Filipino',
        'fi' => 'Finnish','fr' => 'French','fy' => 'Frisian','gl' => 'Galician',
        'ka' => 'Georgian','de' => 'German','el' => 'Greek','gu' => 'Gujarati',
        'ht' => 'Haitian Creole','ha' => 'Hausa','haw' => 'Hawaiian','iw' => 'Hebrew',
        'hi' => 'Hindi','hmn' => 'Hmong','hu' => 'Hungarian','is' => 'Icelandic',
        'ig' => 'Igbo','ga' => 'Irish','it' => 'Italian',
        'ja' => 'Japanese','jw' => 'Javanese','kn' => 'Kannada','kk' => 'Kazakh',
        'km' => 'Khmer','ko' => 'Korean','ku' => 'Kurdish','ky' => 'Kyrgyz',
        'lo' => 'Lao','la' => 'Latin','lv' => 'Latvian','lt' => 'Lithuanian',
        'lb' => 'Luxembourgish','mk' => 'Macedonian','mg' => 'Malagasy','ms' => 'Malay',
        'ml' => 'Malayalam','mt' => 'Maltese','mi' => 'Maori','mr' => 'Marathi',
        'mn' => 'Mongolian','my' => 'Burmese','ne' => 'Nepali','no' => 'Norwegian',
        'ps' => 'Pashto','fa' => 'Persian','pl' => 'Polish','pt' => 'Portuguese',
        'pa' => 'Punjabi','ro' => 'Romanian','ru' => 'Russian','sm' => 'Samoan',
        'gd' => 'Scots Gaelic','sr' => 'Serbian','st' => 'Sesotho','sn' => 'Shona',
        'sd' => 'Sindhi','si' => 'Sinhala','sk' => 'Slovak','sl' => 'Slovenian',
        'so' => 'Somali','es' => 'Spanish','su' => 'Sundanese','sw' => 'Swahili',
        'sv' => 'Swedish','tg' => 'Tajik','ta' => 'Tamil','te' => 'Telugu',
        'th' => 'Thai','tr' => 'Turkish','uk' => 'Ukrainian','ur' => 'Urdu',
        'uz' => 'Uzbek','vi' => 'Vietnamese','cy' => 'Welsh','xh' => 'Xhosa',
        'yi' => 'Yiddish','yo' => 'Yoruba','zu' => 'Zulu'
    ];
    private $listKategori = [
    "Buku-Paket", "Ensiklopedia", "Komik",
    "Majalah", "Novel", "Referensi", "Lainnya"
];

private $listGenre = [
    "Agama", "Anak & Remaja", "Biografi", "Bisnis & Ekonomi", "Cerpen",
    "Fantasi", "Fiksi", "Hobi & Keterampilan", "Horror", "Komedi",
    "Komputer & IT", "Misteri & Thriller", "Nonfiksi", "Pendidikan",
    "Petualangan", "Psikologi", "Puisi", "Sains", "Sains Populer",
    "Sejarah", "Slice of Life", "Sosial & Budaya", "Teknologi"
];


public function index(Request $request)
{
    $query = Buku::query();

    // ======================================
    // NORMALISASI STRING → ARRAY
    // ======================================
    foreach (['kategori', 'genre', 'bahasa'] as $field) {
        if ($request->has($field) && is_string($request->$field)) {
            $request->merge([$field => [$request->$field]]);
        }
    }

    // ======================================
    // FILTER
    // ======================================
    if (!empty($request->kategori)) {
        $query->whereIn('jenis', $request->kategori);
    }

    if (!empty($request->genre)) {
        $query->whereIn('genre', $request->genre);
    }

    if (!empty($request->bahasa)) {
        $query->whereIn('bahasa', $request->bahasa);
    }

    // ======================================
    // FILTER TAHUN
    // ======================================
    if ($request->filter_tahun) {
        $tahun = now()->year;

        if ($request->filter_tahun == 3) {
            $query->where('tahun_terbit', '>=', $tahun - 3);
        } elseif ($request->filter_tahun == 5) {
            $query->where('tahun_terbit', '>=', $tahun - 5);
        } elseif ($request->filter_tahun == '>5') {
            $query->where('tahun_terbit', '<=', $tahun - 5);
        }
    }

    // ======================================
    // SORTING
    // ======================================
    if ($request->sort) {
        switch ($request->sort) {
            case 'az':
                $query->orderBy('judul', 'asc');
                break;

            case 'za':
                $query->orderBy('judul', 'desc');
                break;

            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'rating':
                $query->withAvg('ratings', 'rating')
                      ->orderBy('ratings_avg_rating', 'desc');
                break;
        }
    }

    // ======================================
    // RESULT
    // ======================================
    $buku = $query->get();
    $jumlah = $buku->count();

    return view('koleksi', [
    'buku'             => $buku,
    'listKategori'     => $this->listKategori,
    'listGenre'        => $this->listGenre,
    'allLanguages'     => $this->languageList,
    'jumlah'           => $jumlah,
    'keyword'          => $request->q ?? "",
    'selectedKategori' => $request->kategori ?? []
]);

}




public function filter(Request $request)
{
    $query = Buku::query();

    // NORMALISASI STRING → ARRAY
    if ($request->has('kategori') && is_string($request->kategori)) {
        $request->merge(['kategori' => [$request->kategori]]);
    }
    if ($request->has('genre') && is_string($request->genre)) {
        $request->merge(['genre' => [$request->genre]]);
    }
    if ($request->has('bahasa') && is_string($request->bahasa)) {
        $request->merge(['bahasa' => [$request->bahasa]]);
    }

    // FILTER
    if ($request->kategori) {
        $query->whereIn('jenis', $request->kategori);
    }
    if ($request->genre) {
        $query->whereIn('genre', $request->genre);
    }
    if ($request->bahasa) {
        $query->whereIn('bahasa', $request->bahasa);
    }

    // TAHUN
    if ($request->filter_tahun) {
        $tahun = now()->year;

        if ($request->filter_tahun == 3) {
            $query->where('tahun_terbit', '>=', $tahun - 3);
        } elseif ($request->filter_tahun == 5) {
            $query->where('tahun_terbit', '>=', $tahun - 5);
        } elseif ($request->filter_tahun == '>5') {
            $query->where('tahun_terbit', '<=', $tahun - 5);
        }
    }

    // SORTING
    if ($request->sort) {
        switch ($request->sort) {
            case 'az': $query->orderBy('judul', 'asc'); break;
            case 'za': $query->orderBy('judul', 'desc'); break;
            case 'newest': $query->orderBy('created_at', 'desc'); break;
            case 'oldest': $query->orderBy('created_at', 'asc'); break;
            case 'rating':
                $query->withAvg('ratings', 'rating')
                      ->orderBy('ratings_avg_rating', 'desc');
                break;
        }
    }

    // RESULT
    $buku = $query->get();
    $jumlah = $buku->count();

    return view('layouts.partials.koleksi_items', [
        'buku'   => $buku,
        'jumlah' => $jumlah,
        'keyword'=> $request->q ?? ""
    ])->render();
}





    public function detail(Request $request, Buku $buku){
        $prefix = implode('-', array_slice(explode('-', $buku->no_panggil), 0, 4));

        $eksemplar = Buku::where('no_panggil', 'like', $prefix . '%')->get();

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

        $averageRating = $buku->ratings()->avg('rating') ?? 0;
        $userRating = $buku->userRating;
        $bhs = $bahasa[$buku->bahasa] ?? 'Unknown';
        $ngr = $negara[$buku->negara] ?? 'Unknown';

        $keranjangItem = KeranjangItem::whereHas('cart', function($q){
            $q->where('idUser', FacadesAuth::id());
        })
        ->pluck('idBuku')
        ->toArray();
        return view('detailbuku', compact('buku','bhs','averageRating','userRating','eksemplar','keranjangItem','ngr'));
    }
    public function rating(Request $request, Buku $buku)
    {
        $request->validate([
        'rating' => 'required|integer|min:1|max:5'
        ]);

        $userId = FacadesAuth::id();

        $rating = BukuRating::updateOrCreate(
            ['idUser' => $userId, 'idBuku' => $buku->idBuku],
            ['rating' => $request->rating]
        );

        // Recalculate average
        $averageRating = $buku->ratings()->avg('rating') ?? 0;

        return response()->json([
            'success' => true,
            'rating' => $rating->rating,
            'average' => $averageRating
        ]);
    }

    public function addKeranjang(Request $request)
    {
        $request->validate([
            'idBuku' => 'required|exists:buku,idBuku'
        ]);

        // Ambil atau buat keranjang user
        $cart = Keranjang::firstOrCreate(['idUser' => FacadesAuth::id()]);

        // Cek apakah buku sudah ada di keranjang
        $item = KeranjangItem::where('idCart', $cart->idCart)
                        ->where('idBuku', $request->idBuku)
                        ->first();

        if ($item) {
            $item->save();
        } else {
            KeranjangItem::create([
                'idCart' => $cart->idCart,
                'idBuku' => $request->idBuku
            ]);
        }
        
        toastr()->success('Buku berhasil ditambahkan ke Daftar Peminjaman.');
        return redirect()->route('detail',['buku' => $request->idBuku]);
    }
}
