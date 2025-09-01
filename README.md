# 📲 Sistem Database WhatsApp Kabupaten Sidoarjo

Aplikasi web berbasis **Laravel** untuk manajemen dan pengiriman pesan WhatsApp ke **Organisasi Perangkat Daerah** dan **Aparatur Sipil Negara** di Kabupaten Sidoarjo. Mendukung pengiriman pesan **massal**, **penjadwalan**, serta **unggah media** dengan tampilan dashboard yang sederhana dan mudah digunakan.  

## ✨ Fitur

- Pilih nomor WhatsApp OPD dan ASN secara massal atau individual.
- Kirim pesan WhatsApp dengan format markdown dan preview.
- Upload media (gambar/video) untuk pesan.
- Penjadwalan pengiriman pesan.
- Dashboard riwayat pesan.

## ⚙️ Teknologi & Dependensi Utama

| Library / Tools         | Kegunaan                                 |
|------------------------ |------------------------------------------|
| Laravel 12              | Framework backend utama                  |
| PHP ^8.2              | Bahasa pemrograman dan requirement Laravel|
| MySQL                   | Database aplikasi                        |
| Bootstrap 5 (CDN)       | Desain UI responsif dan modern           |
| SimpleMDE (CDN)         | Editor markdown untuk pesan WhatsApp     |
| jQuery (CDN)            | Interaksi UI dan manipulasi DOM          |

## 🧪 Cara Menjalankan Proyek

### Prasyarat

- PHP ^8.2
- Composer
- MySQL
- Laravel 12

### Langkah Menjalankan Secara Lokal

1. **Clone Repositori**
    ```bash
    git clone https://github.com/nadiabillah/wasda.git
    cd wasda
    ```

2. **Install Dependensi PHP**
    ```bash
    composer install
    ```

3. **Buat Symbolic Link Storage**
    ```bash
    php artisan storage:link
    ```

4. **Setup File Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Migrasi dan Seeder Database**
    ```bash
    php artisan migrate
    php artisan db:seed --class=UsersSeeder
    php artisan db:seed --class=AsnSeeder
    ```

6. **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```

## 🛡️ Role Akses

- **OPD:** Kirim pesan WhatsApp terjadwal ke OPD/ASN.

## 📤 Fitur Pesan

- Pilih semua OPD/ASN dengan satu klik.
- Input nomor custom.
- Preview pesan WhatsApp sebelum dikirim.
- Penjadwalan pengiriman pesan.
