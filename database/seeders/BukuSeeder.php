<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Buku::factory()->create([
            'judul' => "BanG Dream! It's MyGO!!!!! Swaying in the Rain, Looking for the Sunshine",
            'penulis' => 'Yuama',
            'penerbit' => 'Bushiroad',
            'negara' => 'ja',
            'deskripsi' => '"I really believed that our meeting was a fateful one. It felt as if I had been enveloped by the spring sunlight and found a warm and irreplaceable place for myself. Yet..." This is the story of a certain lost girl, depicted from a new perspective.',
            'jenis' => 'komik',
            'genre' => 'romansa',
            'no_panggil' => 'YUA-BAN-1-2024-001',
            'volume' => '1',
            'halaman' => '114',
            'bahasa' => 'en',
            'issn' => '111-1-1111111-11',
            'tahun_terbit' => '2024',
            'cover' => '1763873401.webp',
            'stok' => 1
        ]);
        Buku::factory()->create([
            'judul' => "BanG Dream! It's MyGO!!!!! Swaying in the Rain, Looking for the Sunshine",
            'penulis' => 'Yuama',
            'penerbit' => 'Bushiroad',
            'negara' => 'ja',
            'deskripsi' => '"I really believed that our meeting was a fateful one. It felt as if I had been enveloped by the spring sunlight and found a warm and irreplaceable place for myself. Yet..." This is the story of a certain lost girl, depicted from a new perspective.',
            'jenis' => 'komik',
            'genre' => 'romansa',
            'no_panggil' => 'YUA-BAN-1-2024-003',
            'volume' => '1',
            'halaman' => '114',
            'bahasa' => 'en',
            'issn' => '111-1-1111111-11',
            'tahun_terbit' => '2024',
            'cover' => '1763873401.webp',
            'stok' => 1
        ]);
        Buku::factory()->create([
            'judul' => "BanG Dream! Ave Mujica -manuscriptus-",
            'penulis' => 'Hiroyama Pinfu',
            'penerbit' => 'Bushiroad',
            'negara' => 'ja',
            'deskripsi' => 'Welcome to the World of "Ave Mujica"―― “Give me the rest of your life?”',
            'jenis' => 'komik',
            'genre' => 'horror',
            'no_panggil' => 'HIR-BAN-1-2022-001',
            'volume' => '1',
            'halaman' => '70',
            'bahasa' => 'en',
            'issn' => '222-2-2-222222-2',
            'tahun_terbit' => '2024',
            'cover' => '1763885753.webp',
            'stok' => 1
        ]);
        Buku::factory()->create([
            'judul' => "Umineko WHEN THEY CRY Episode 6: Dawn of the Golden Witch",
            'penulis' => 'Ryukishi07',
            'penerbit' => 'Square Enix',
            'negara' => 'ja',
            'deskripsi' => 'Welcome to the World of "Ave Mujica"―― “Give me the rest of your life?”',
            'jenis' => 'komik',
            'genre' => 'misteri',
            'no_panggil' => 'RYU-UMI-1-2025-001',
            'volume' => '1',
            'halaman' => '70',
            'bahasa' => 'ja',
            'issn' => '333-3-3-333333-33',
            'tahun_terbit' => '2024',
            'cover' => '1763888274.jpg',
            'stok' => 1
        ]);
        Buku::factory()->create([
            'judul' => "The King in Yellow",
            'penulis' => 'Robert W. Chambers',
            'penerbit' => 'Square Enix',
            'negara' => 'en',
            'deskripsi' => '',
            'jenis' => 'novel',
            'genre' => 'Horror',
            'no_panggil' => 'ROB-THE-1-2025-001',
            'volume' => '1',
            'halaman' => '256   ',
            'bahasa' => 'en',
            'issn' => '444-4-4-444444-44',
            'tahun_terbit' => '2025',
            'cover' => '1763888857.webp',
            'stok' => 1
        ]);
    }
}
