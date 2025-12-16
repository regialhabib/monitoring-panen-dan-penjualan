# Monitoring Jeruk

Monitoring Jeruk adalah aplikasi web berbasis Laravel untuk memantau, mencatat, serta mengelola aktivitas panen dan penjualan jeruk.

## Fitur

- **Dashboard**: Statistik singkat aktivitas panen dan penjualan.  
- **Jenis Jeruk**: Kelola data jenis-jenis jeruk.
- **Riwayat Panen**: Catat hasil panen, waktu, dan jenis jeruk.
- **Riwayat Penjualan**: Pantau penjualan dari hasil panen.
- **Laporan**: Unduh laporan panen dan penjualan (untuk admin).
- **Profil**: Kelola profil pengguna.
- **Hak Akses**: Sistem user dan admin dengan wewenang berbeda.

## Instalasi

1. **Clone repositori**
   ```
   git clone https://github.com/username/monitoring-jeruk.git
   cd monitoring-jeruk
   ```

2. **Instal dependensi**
   ```
   composer install
   npm install && npm run dev
   ```

3. **Konfigurasi environment**
   ```
   cp .env.example .env
   php artisan key:generate
   ```
   Edit `.env` untuk pengaturan database.

4. **Migrasi dan seeder**
   ```
   php artisan migrate --seed
   ```

5. **Jalankan aplikasi**
   ```
   php artisan serve
   ```

## Hak Akses

- **Admin**: Kelola semua data, akses laporan.
- **User**: Input/lihat data panen, penjualan, dan profil.

## Kontribusi

Pull request sangat diterima! Silakan buka _issue_ untuk saran atau laporan bug.

## Lisensi

MIT

