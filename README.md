# 🎓 Sistem Informasi Mahasiswa

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![MongoDB](https://img.shields.io/badge/MongoDB-5.0%2B-green.svg)](https://www.mongodb.com)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Sebuah aplikasi web untuk manajemen data mahasiswa menggunakan PHP dan MongoDB. Aplikasi ini memungkinkan admin untuk mengelola data mahasiswa, jurusan, dan menghasilkan laporan dalam format PDF.

## 🚀 Fitur

- 🔐 Sistem autentikasi (login/register)
- 📝 CRUD data mahasiswa
- 🔍 Live search dengan AJAX
- 📁 Upload foto mahasiswa
- 📊 Export data ke PDF
- 🎨 Interface yang responsif
- 📱 Mobile-friendly design

## 💻 Teknologi yang Digunakan

- PHP 7.4+
- MongoDB 5.0+
- jQuery 3.7.1
- mPDF 8.2
- HTML5 & CSS3
- AJAX

## 📋 Prasyarat

Sebelum menjalankan aplikasi ini, pastikan Anda telah menginstall:

- PHP >= 7.4
- MongoDB Server
- Composer
- Web Server (Apache/Nginx)
- MongoDB Compass (optional, untuk manajemen database)

## 🛠️ Instalasi

1. Clone repository
   
```bash
git clone https://github.com/muhammadfariddd/Sistem-Informasi-Mahasiswa.git
cd Sistem-Informasi-Mahasiswa
```

2. Install dependencies

```bash
composer install
```

3. Import database dari folder `db`

Menggunakan mongoimport
```bash
mongoimport --db phpdasar --collection user --file db/phpdasar.user.json --jsonArray
mongoimport --db phpdasar --collection mahasiswa --file db/phpdasar.mahasiswa.json --jsonArray
mongoimport --db phpdasar --collection jurusan --file db/phpdasar.jurusan.json --jsonArray
```
Atau menggunakan MongoDB Compass:
1. Buka MongoDB Compass
2. Buat database 'phpdasar'
3. Import file JSON dari folder 'db' ke masing-masing collection

## 👨‍💻 Author

**Muhammad Farid**
- Email: ilhamfaridjepara@gmail.com
- GitHub: [@muhammadfariddd](https://github.com/muhammadfariddd)

## 🙏 Acknowledgments

- [MongoDB PHP Library](https://github.com/mongodb/mongo-php-library)
- [mPDF](https://github.com/mpdf/mpdf)
- [jQuery](https://jquery.com)
- [Font Awesome](https://fontawesome.com)

---
⭐ Jika project ini membantu, berikan starnya ya! [Star di GitHub](https://github.com/muhammadfariddd/Sistem-Informasi-Mahasiswa/)
