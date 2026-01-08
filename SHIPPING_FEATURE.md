# Fitur Perhitungan Ongkos Kirim Dinamis

## Deskripsi
Fitur ini menghitung ongkos kirim secara otomatis berdasarkan kota dan provinsi tujuan pengiriman saat proses checkout.

## Komponen yang Dibuat/Dimodifikasi

### 1. Model: ShippingRate
**File:** `app/Models/ShippingRate.php`
- Menyimpan data tarif pengiriman per rute
- Method `calculateCost()`: Menghitung total biaya berdasarkan jarak
- Method `findByCities()`: Mencari tarif pengiriman berdasarkan kota asal dan tujuan

### 2. Migration: create_shipping_rates_table
**File:** `database/migrations/2024_12_24_000000_create_shipping_rates_table.php`
- Membuat tabel `shipping_rates` dengan struktur:
  - `origin_city`: Kota asal
  - `origin_province`: Provinsi asal
  - `destination_city`: Kota tujuan
  - `destination_province`: Provinsi tujuan
  - `distance_km`: Jarak dalam kilometer
  - `base_rate`: Tarif dasar
  - `rate_per_km`: Tarif per kilometer

### 3. Controller: ShippingController
**File:** `app/Http/Controllers/ShippingController.php`
- Method `calculateCost()`: API endpoint untuk perhitungan ongkos kirim
- Mencari data di database `shipping_rates`
- Fallback ke perhitungan default jika rute tidak ditemukan
- Mengembalikan response JSON dengan biaya dan jarak

### 4. Seeder: ShippingRateSeeder
**File:** `database/seeders/ShippingRateSeeder.php`
- Data seed untuk 15+ rute pengiriman dari Jakarta ke berbagai kota
- Mencakup: Jawa Barat, Jawa Tengah, Jawa Timur, Bali, Sumatra, Sulawesi, Kalimantan

### 5. API Route
**File:** `routes/api.php`
```
POST /api/shipping/calculate-cost
```
Menerima:
- `destination_city` (required): Kota tujuan
- `destination_province` (required): Provinsi tujuan

Mengembalikan:
```json
{
    "success": true,
    "cost": 25000,
    "cost_formatted": "Rp 25.000",
    "distance": "450 km"
}
```

### 6. Checkout View - Update
**File:** `resources/views/checkout/index.blade.php`
- Hidden input fields untuk menyimpan nilai subtotal, shipping, dan total
- Display fields yang diupdate secara real-time
- Event listener pada input city dan province

### 7. CheckoutController - Update
**File:** `app/Http/Controllers/CheckoutController.php`
- Tambahan method `calculateShippingCost()` untuk menghitung biaya pengiriman saat menyimpan order
- Method `getDefaultShippingCost()` untuk fallback tarif default per provinsi
- Biaya pengiriman sekarang disimpan di kolom `shipping_cost` dalam database

## Fitur-Fitur

### Real-time Calculation
✅ Menghitung ongkos kirim saat user mengisi kota dan provinsi
✅ Update total harga secara otomatis
✅ Display jarak dalam km (jika tersedia di database)

### Tarif Pengiriman
- **Base Rate**: Tarif dasar untuk setiap rute (mulai dari 5.000 - 60.000 Rp)
- **Rate per KM**: Biaya per kilometer (500 - 1.800 Rp/km)
- **Formula**: Total = Base Rate + (Distance × Rate per KM)

### Contoh Kalkulasi
Pengiriman dari Jakarta ke Bandung:
- Base Rate: 15.000 Rp
- Distance: 180 km
- Rate per KM: 800 Rp
- **Total: 15.000 + (180 × 800) = 159.000 Rp**

### Fallback Calculation
Jika rute tidak ada di database, sistem menggunakan tarif default per provinsi:
- DKI Jakarta: 10.000 Rp
- Jawa Barat: 15.000 Rp
- Jawa Tengah: 25.000 Rp
- Jawa Timur: 35.000 Rp
- Dan seterusnya...

## JavaScript Implementation

### Event Listeners
- `cityInput.addEventListener('change', calculateShipping)`: Saat city berubah
- `provinceInput.addEventListener('change', calculateShipping)`: Saat province berubah
- `cityInput.addEventListener('blur', calculateShipping)`: Saat fokus hilang dari city

### Functions
- `calculateShipping()`: Fetch API ke endpoint `/api/shipping/calculate-cost`
- `updateTotal()`: Update display grand total
- `formatCurrency()`: Format angka menjadi format Rupiah (Rp X.XXX.XXX)

## Cara Menggunakan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Seed Data Shipping Rates
```bash
php artisan db:seed --class=ShippingRateSeeder
```

### 3. Tambahkan Rute Pengiriman Baru
Dalam admin panel (perlu dibuat) atau melalui Tinker:
```php
php artisan tinker
>>> App\Models\ShippingRate::create([
    'origin_city' => 'Jakarta',
    'origin_province' => 'DKI Jakarta',
    'destination_city' => 'Bandung',
    'destination_province' => 'Jawa Barat',
    'distance_km' => 180,
    'base_rate' => 15000,
    'rate_per_km' => 800
]);
```

### 4. Update Tarif Existing
```php
$rate = ShippingRate::findByCities('Jakarta', 'DKI Jakarta', 'Surabaya', 'Jawa Timur');
$rate->update(['base_rate' => 40000, 'rate_per_km' => 1300]);
```

## Struktur Flow Checkout

```
User mengisi form checkout
    ↓
Input city/province berubah
    ↓
JavaScript trigger calculateShipping()
    ↓
Fetch ke /api/shipping/calculate-cost
    ↓
ShippingController mencari di database/fallback
    ↓
Return biaya pengiriman & jarak
    ↓
Update display shipping cost & grand total
    ↓
User submit form
    ↓
CheckoutController hitung ulang biaya (untuk validasi)
    ↓
Simpan order dengan shipping_cost yang sesuai
```

## Tips & Trik

### Menambah Rute Pengiriman Lengkap
Untuk akurasi lebih baik, tambahkan ke seeder:
- Kota-kota utama di setiap provinsi
- Jarak realistis (gunakan Google Maps API atau data real)
- Rate yang kompetitif dengan kurir lokal

### Menggunakan API Pihak Ketiga (Opsional)
Untuk integrasi lebih dalam, bisa menggunakan:
- **RajaOngkir API**: Integrasi dengan kurir Indonesia
- **Google Maps API**: Hitung jarak otomatis
- **Logistics API**: Custom logistics provider

### Performance Optimization
1. Cache shipping rates:
```php
$rates = Cache::remember('shipping_rates', 86400, function () {
    return ShippingRate::all();
});
```

2. Index database pada kolom `destination_city` dan `destination_province`

## Testing

### Manual Testing Checkout
1. Navigasi ke halaman checkout
2. Isi form shipping details
3. Ubah city dan province
4. Verifikasi shipping cost berubah sesuai pilihan
5. Cek total price terupdate dengan benar
6. Submit form dan verifikasi order tersimpan dengan shipping cost

### API Testing
```bash
curl -X POST http://localhost/api/shipping/calculate-cost \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"destination_city":"Bandung","destination_province":"Jawa Barat"}'
```

## Catatan Penting

⚠️ **CSRF Token**: JavaScript menggunakan meta tag `csrf-token` dari `<meta name="csrf-token">`
⚠️ **Authentication**: API endpoint memerlukan middleware `auth`
⚠️ **Currency**: Semua nilai dalam Rupiah (IDR)
⚠️ **Timezone**: Pastikan server timezone sesuai

---

Fitur ini sudah siap digunakan dan dapat dikembangkan lebih lanjut sesuai kebutuhan bisnis!
