# Dummy Data Information

## Overview
Sudah ditambahkan dummy data lengkap ke dalam database dengan struktur berikut:

### 1. UNIT (8 satuan)
- Piece (pcs) - Satuan barang
- Kilogram (kg) - Berat dalam kilogram
- Gram (g) - Berat dalam gram
- Liter (L) - Volume dalam liter
- Milliliter (ml) - Volume dalam milliliter
- Box (box) - Kemasan atau kotak
- Pack (pack) - Paket
- Dozen (dz) - 12 buah
- Meter (m) - Ukuran panjang
- Set (set) - Himpunan barang

### 2. CATEGORIES (12 kategori)
1. Elektronik
2. Fashion & Pakaian
3. Sepatu
4. Tas & Dompet
5. Aksesori
6. Furnitur
7. Rumah Tangga
8. Olahraga
9. Buku & Media
10. Mainan & Game
11. Kecantikan & Perawatan
12. Makanan & Minuman

### 3. PRODUCTS (48 produk)
Total 48 produk dengan detail lengkap:
- **SKU** - Kode unik produk
- **Nama Produk** - Nama deskriptif
- **Kategori** - Terkait dengan kategori di atas
- **Unit** - Satuan pengukuran
- **Stock** - Jumlah stok (bervariasi 3-100)
- **Stock Min** - Stok minimum
- **Harga** - Harga dalam Rupiah
- **Deskripsi** - Deskripsi produk lengkap
- **Kondisi** - Baru / Seperti Baru / Bekas - Bagus
- **Image** - Path ke foto produk
- **Is Active** - Status aktif

## Distribusi Produk per Kategori
- Elektronik: 4 produk (Smartphone, Laptop, Headphone, Tablet)
- Fashion & Pakaian: 4 produk (Kemeja, Jaket, T-shirt, Celana Jeans)
- Sepatu: 4 produk (Sneaker Nike, Sepatu Formal, Sandal, Boots)
- Tas & Dompet: 4 produk (Backpack, Briefcase, Dompet, Handbag)
- Aksesori: 4 produk (Jam Tangan, Gelang, Sunglasses, Kalung)
- Furnitur: 4 produk (Meja Makan, Sofa, Lemari, Ranjang)
- Rumah Tangga: 4 produk (Blender, Microwave, Setrika, Vacuum)
- Olahraga: 4 produk (Sepeda MTB, Yoga Mat, Dumbbel, Raket Tennis)
- Buku & Media: 4 produk (Novel, Komik, DVD, Buku Masak)
- Mainan & Game: 4 produk (Rubik's Cube, Game PS5, Board Game, Action Figure)
- Kecantikan & Perawatan: 4 produk (Skincare, Lipstick, Hair Serum, Perfume)
- Makanan & Minuman: 4 produk (Kopi, Teh, Coklat, Madu)

## Harga Range
- Terendah: Rp 75.000 (Rubik's Cube)
- Tertinggi: Rp 7.500.000 (Laptop HP Pavilion)
- Rata-rata: Rp 1.000.000 - Rp 2.000.000

## Kondisi Produk
- Baru: 10 produk
- Seperti Baru: 19 produk
- Bekas - Bagus: 19 produk

## Catatan Foto Produk
Semua produk sudah memiliki path foto di field `image`:
```
products/nama-produk.jpg
```

### Cara Menambahkan Foto Sebenarnya:

1. **Buat folder images** (jika belum ada):
   ```
   public/storage/images/products/
   ```

2. **Download atau upload foto** dengan nama sesuai field image pada database, contoh:
   - `public/storage/images/products/smartphone-samsung.jpg`
   - `public/storage/images/products/laptop-hp.jpg`
   - dll.

3. **Jika menggunakan Storage Symlink** (recommended):
   ```bash
   php artisan storage:link
   ```
   Kemudian upload foto ke:
   ```
   storage/app/public/products/
   ```
   Dan update field image menjadi:
   ```
   storage/products/nama-foto.jpg
   ```

4. **Display foto di view** (Blade):
   ```blade
   <img src="{{ asset('storage/images/products/' . $product->image) }}" alt="{{ $product->name }}">
   ```

## Cara Menjalankan Seeder

### Fresh Seeding (reset database dan seed ulang):
```bash
php artisan migrate:fresh --seed
```

### Seeding Saja (tanpa reset data lama):
```bash
php artisan db:seed
```

### Seeding Seeder Tertentu:
```bash
php artisan db:seed --class=ItemSeeder
php artisan db:seed --class=CategoriesSeeder
php artisan db:seed --class=UnitSeeder
```

## File Seeder Yang Diupdate
1. `database/seeders/CategoriesSeeder.php` - 12 kategori
2. `database/seeders/UnitSeeder.php` - 10 unit (sudah ada)
3. `database/seeders/ItemSeeder.php` - 48 produk
4. `database/seeders/DatabaseSeeder.php` - Main seeder

## Verifikasi Data

Untuk memverifikasi data yang telah di-seed, bisa menggunakan Tinker:

```bash
# Hitung total data
php artisan tinker
>>> App\Models\categories::count()
>>> App\Models\Unit::count()
>>> App\Models\item::count()
>>> exit
```

## Modifikasi Dummy Data

Jika ingin menambah/mengubah dummy data:

1. Edit file seeder di `database/seeders/`
2. Jalankan ulang migration dengan fresh:
   ```bash
   php artisan migrate:fresh --seed
   ```

Atau jika ingin menambah data tanpa reset, gunakan:
```bash
php artisan db:seed --class=ItemSeeder
```

---
**Last Updated**: 26 January 2026
