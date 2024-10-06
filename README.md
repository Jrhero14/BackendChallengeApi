# Ecommerce Mini Warehouse

Ecommerce Mini Warehouse
Ecommerce Mini Warehouse adalah sebuah aplikasi backend yang dirancang untuk mengelola data produk dan ulasan (review) di dalam sistem e-commerce skala kecil. Aplikasi ini menyediakan fitur CRUD (Create, Read, Update, Delete) untuk produk dan ulasan, yang memungkinkan administrator dan pengguna untuk berinteraksi dengan data secara efisien.

### Fitur Utama:
1. Manajemen Produk:

- Fitur untuk mengelola daftar produk di warehouse e-commerce, termasuk menambah, melihat, memperbarui, dan menghapus produk.
- Setiap produk memiliki informasi detail seperti nama, deskripsi, harga, dan stok yang tersedia.
- Fitur pencarian produk di admin panel memudahkan administrator untuk mengelola data produk.

2. Manajemen Ulasan (Review):

- Pengguna dapat memberikan ulasan pada setiap produk yang tersedia, yang mencakup komentar dan rating.
- Fitur CRUD untuk review memudahkan pengelolaan ulasan yang ditulis oleh pengguna.
- Setiap ulasan akan terkait dengan produk tertentu, yang memungkinkan administrator untuk melihat feedback pelanggan terhadap produk tersebut.

### Arsitektur dan Teknologi:
- REST API: Aplikasi ini menggunakan arsitektur RESTful API, sehingga mudah diakses oleh berbagai klien seperti aplikasi web, mobile, atau integrasi dengan sistem lain.
- Autentikasi dan Otorisasi: Aplikasi mendukung autentikasi menggunakan JWT Bearer Token untuk melindungi akses ke endpoint.
- Database: Semua data produk dan review disimpan dalam database relasional menggunakan MySQL.
- Framework: Backend dibangun dengan menggunakan framework Laravel 8.


## Relasi Database

<img src="https://i.ibb.co.com/djp4Qcw/Backend-Challange-ERD.png">

Relasi database utama yang dibuat adalah entity Products dan Reviews, sedangkan entity Users sebagai tambahan dan termasuk entity
bawaan dari Laravel juga terkait dengan fitur autentikasi. Hubungan relasi setiap entitas dijelaskan sebagai berikut:
1. Product <-> Review : One To Many (Has Many)
- Setiap product memiliki lebih dari satu review.

2. User <-> Products : One To Many (Has Many)
- Setiap user bisa memiliki (menjual) lebih dari 1 product.

3. User <-> Review : One To Many (Has Many)
- Setiap user bisa memiliki komentar lebih dari satu untuk setiap product yang direview.

## Environment Variables

To run this project, you will need to add the following database environment variables to your .env file

`DB_CONNECTION = mysql`

`DB_HOST = 127.0.0.1/localhost`

`DB_PORT = 3306`

`DB_DATABASE = backendchallange`

`DB_USERNAME = root`

`DB_PASSWORD = `

## Installation

Install with composer

- Clone Project
```bash
  git clone https://github.com/Jrhero14/BackendChallengeApi
  cd BackendChallengeApi
```

- Import sql file
```bash
  mysql -u username -p backendchallange < database/backup/mysql_backup.sql
```
Atau Anda bisa melakukan import manual melalui database client seperti phpmyadmin, tableplus, dll

- Install dependency with Composer
```bash
  composer install
```

- Run Project
```bash
  php artisan serve
```


## Screenshot Aplikasi

- Login Admin
```bash
  Url: /admin
  Default User Admin:
  - email: admin@jeremi.com
  - password: mimin123
```
<img src="https://i.ibb.co.com/LknC7JJ/Screenshot-2024-10-05-165429.png">

- CRUD Products

<img src="https://i.ibb.co.com/qnkwnbM/Screenshot-2024-10-05-165358.png">

- CRUD Review

<img src="https://i.ibb.co.com/pfgc0x2/Screenshot-2024-10-05-165415.png">

- User Management

<img src="https://i.ibb.co.com/sRzMh9d/Screenshot-2024-10-05-165422.png">

- Testing API using Postman

<img src="https://i.ibb.co.com/nzzmndZ/Screenshot-2024-10-05-165927.png" alt="Screenshot-2024-10-05-165927" border="0">

## Detail API Documentation

[Postman Documentation](https://documenter.getpostman.com/view/34986320/2sAXxMesfm)

## Tech Stack and Dependency

### Main Framework

- Laravel 8

### Database and ORM

- MySQL
- Laravel Eloquent ORM

### Dependency

- Filament 2.x
- tymon/jwt-auth

### NOTE:
- Jika Anda ingin mencoba aplikasi ini di lokal enviroment disarankan untuk melakukan restore database default yang ada di project ini.
file .sql backup terdapat di folder "database/backup/backendchallange.sql" dan lakukan restore melalui database client di lokal enviroment
kalian masing-masing.

## Contact Me

- [My Github](https://github.com/Jrhero14)
- [Jeremi.herodian.a43@gmail.com](Jeremi.herodian.a43@gmail.com)

