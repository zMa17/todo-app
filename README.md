# 📝 Todo App — Dokumentasi Proyek

> Aplikasi manajemen tugas (todo list) berbasis web yang dibangun menggunakan Laravel dan SQLite.

---

## 📋 Daftar Isi

- [Deskripsi Proyek](#deskripsi-proyek)
- [📐 Teknis Aplikasi (Instruksi Tugas)](#-teknis-aplikasi-instruksi-tugas)
- [Teknologi yang Dipakai](#teknologi-yang-dipakai)
- [Struktur Database](#struktur-database)
- [Fitur yang Sudah Diimplementasikan](#fitur-yang-sudah-diimplementasikan)
- [Coding Style & Konvensi](#coding-style--konvensi)
- [Cara Menjalankan Proyek](#cara-menjalankan-proyek)
- [Halaman & Route](#halaman--route)
- [Roadmap](#roadmap)
- [Yang Belum Diimplementasikan](#yang-belum-diimplementasikan)
- [Checklist](#checklist)

---

## 📌 Deskripsi Proyek

**Todo App** adalah aplikasi manajemen tugas berbasis web yang memungkinkan pengguna untuk mencatat, mengelola, dan memantau tugas sehari-hari. Aplikasi ini dibangun sebagai proyek tugas kuliah dengan tujuan mengimplementasikan operasi CRUD lengkap beserta berbagai tipe input pada form.

Aplikasi ini dirancang untuk **single user** terlebih dahulu, namun struktur database sudah disiapkan agar bisa dikembangkan menjadi **multi-user** di masa mendatang tanpa perlu mengubah skema tabel.

---

## 📐 Teknis Aplikasi (Instruksi Tugas)

Berikut adalah spesifikasi teknis yang diberikan sebagai instruksi tugas, beserta status implementasinya.

| # | Ketentuan | Status |
|---|---|---|
| 1 | Aplikasi memiliki fungsi CRUD (Create, Read, Update, Delete) | ✅ |
| 2 | Aplikasi berbasis web menggunakan PHP / Laravel | ✅ |
| 3 | Menerima input **TextField** | ✅ `judul`, `deskripsi` |
| 4 | Menerima input **Dropdown** | ✅ `kategori` |
| 5 | Menerima input **Radio Button** | ✅ `prioritas` (low / medium / high) |
| 6 | Menerima input **Checkbox** | ✅ `tags` |
| 7 | Menerima input **Switch / Toggle** | ✅ `is_completed` |
| 8 | Menerima input **Date** (kalender) | ✅ `tanggal_deadline` |
| 9 | Menyimpan data ke database lokal SQLite | ✅ |
| 10 | Create & Update: semua field wajib diisi, tampilkan pesan error jika kosong | ✅ |
| 11 | Read: ditampilkan dalam bentuk list / tabel | ✅ |
| 12 | Delete: tampilkan alert konfirmasi terlebih dahulu | ✅ |

---

## 🛠️ Teknologi yang Dipakai

| Kategori | Teknologi |
|---|---|
| Framework | Laravel (PHP) |
| Database | SQLite |
| Local Server | Laragon |
| Frontend | Laravel Blade (HTML murni, belum di-styling) |
| ORM | Eloquent |

---

## 🗄️ Struktur Database

### Tabel `kategoris`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary Key |
| nama | string | Nama kategori |
| warna | string | Kode warna (hex) |
| created_at | timestamp | |
| updated_at | timestamp | |

### Tabel `tags`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary Key |
| nama | string | Nama tag |
| warna | string | Kode warna (hex) |
| created_at | timestamp | |
| updated_at | timestamp | |

### Tabel `todos`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary Key |
| user_id | bigint (nullable) | FK ke `users` — untuk future multi-user |
| kategori_id | bigint | FK ke `kategoris` |
| judul | string | Judul todo |
| deskripsi | text | Deskripsi todo |
| tanggal_deadline | date | Tanggal deadline |
| prioritas | enum | `low`, `medium`, `high` |
| is_completed | boolean | Status selesai atau belum |
| created_at | timestamp | |
| updated_at | timestamp | |

### Tabel `todo_tags` (Pivot)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary Key |
| todo_id | bigint | FK ke `todos` |
| tag_id | bigint | FK ke `tags` |

### Relasi
- `Kategori` → `Todo` : **hasMany** (satu kategori punya banyak todo)
- `Todo` ↔ `Tag` : **Many-to-Many** via tabel pivot `todo_tags`
- `User` → `Todo` : **hasMany** (disiapkan untuk multi-user, belum aktif)

---

## ✅ Fitur yang Sudah Diimplementasikan

### CRUD Kategori
- Tambah kategori baru (nama + warna)
- Lihat daftar kategori
- Edit kategori
- Hapus kategori dengan konfirmasi

### CRUD Tag
- Tambah tag baru (nama + warna)
- Lihat daftar tag
- Edit tag
- Hapus tag dengan konfirmasi

### CRUD Todo
- Tambah todo baru dengan form lengkap
- Lihat daftar semua todo dalam bentuk tabel
- Edit todo (data lama otomatis ter-prefill di form)
- Hapus todo dengan alert konfirmasi browser native

### Tipe Input yang Diimplementasikan
| Tipe Input | Digunakan Untuk |
|---|---|
| TextField | Judul & Deskripsi |
| Date Picker | Tanggal Deadline |
| Dropdown | Pilih Kategori |
| Radio Button | Pilih Prioritas (Low / Medium / High) |
| Checkbox | Pilih Tags (bisa lebih dari satu) |
| Switch / Toggle | Status selesai (`is_completed`) |

### Validasi Form
- Semua field wajib diisi (sesuai instruksi tugas)
- Pesan error dalam Bahasa Indonesia
- Validasi di sisi server (Laravel) dan sisi browser (`required` HTML)
- Nilai lama tetap muncul di form setelah validasi gagal (menggunakan `old()`)

---

## 🎨 Coding Style & Konvensi

- Menggunakan **Resource Controller** (`-r`) dengan method `show` dihapus karena tidak dipakai
- Route menggunakan `Route::resource()->except(['show'])`
- Penulisan data ke database lebih memilih cara **konvensional** (eksplisit per kolom) dibanding `$request->all()`
- Untuk relasi Many-to-Many, tag disimpan menggunakan `sync()`
- Model `TodoTag` tidak dibuat karena Laravel handle pivot otomatis lewat `belongsToMany`
- Penamaan file view mengikuti konvensi folder: `todos/index`, `todos/create`, `todos/edit`
- Kolom `$fillable` di setiap model didefinisikan secara eksplisit

---

## 🚀 Cara Menjalankan Proyek

### Prasyarat
- PHP >= 8.x
- Composer
- Laragon (atau server lokal lainnya)

### Langkah Instalasi

```bash
# 1. Clone atau download proyek

# 2. Install dependencies
composer install

# 3. Copy file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Pastikan konfigurasi database di .env sudah mengarah ke SQLite
# DB_CONNECTION=sqlite

# 6. Jalankan migration
php artisan migrate

# 7. Jalankan server
php artisan serve
```

---

## 🗺️ Halaman & Route

| Method | Route | Controller@Method | Keterangan |
|---|---|---|---|
| GET | `/kategoris` | `KategoriController@index` | Daftar kategori |
| GET | `/kategoris/create` | `KategoriController@create` | Form tambah kategori |
| POST | `/kategoris` | `KategoriController@store` | Simpan kategori baru |
| GET | `/kategoris/{id}/edit` | `KategoriController@edit` | Form edit kategori |
| PUT | `/kategoris/{id}` | `KategoriController@update` | Update kategori |
| DELETE | `/kategoris/{id}` | `KategoriController@destroy` | Hapus kategori |
| GET | `/tags` | `TagController@index` | Daftar tag |
| GET | `/tags/create` | `TagController@create` | Form tambah tag |
| POST | `/tags` | `TagController@store` | Simpan tag baru |
| GET | `/tags/{id}/edit` | `TagController@edit` | Form edit tag |
| PUT | `/tags/{id}` | `TagController@update` | Update tag |
| DELETE | `/tags/{id}` | `TagController@destroy` | Hapus tag |
| GET | `/todos` | `TodoController@index` | Daftar todo |
| GET | `/todos/create` | `TodoController@create` | Form tambah todo |
| POST | `/todos` | `TodoController@store` | Simpan todo baru |
| GET | `/todos/{id}/edit` | `TodoController@edit` | Form edit todo |
| PUT | `/todos/{id}` | `TodoController@update` | Update todo |
| DELETE | `/todos/{id}` | `TodoController@destroy` | Hapus todo |

---

## 🔮 Roadmap

- [ ] Styling tampilan menggunakan **Tailwind CSS** dengan tema dark mode (mirip tampilan default Laravel)
- [ ] Implementasi **multi-user** dengan autentikasi (Login & Register) menggunakan Laravel Breeze
- [ ] Aktifkan kolom `user_id` di tabel `todos` setelah fitur auth selesai
- [ ] Filter dan pencarian todo di halaman index
- [ ] Modal dialog yang lebih proper untuk konfirmasi delete (menggantikan `confirm()` browser)

---

## 🗃️ Yang Belum Diimplementasikan

- Autentikasi pengguna (Login / Register / Logout)
- Fitur filter todo berdasarkan kategori, tag, atau prioritas
- Pagination di halaman daftar todo
- Seeder untuk data dummy kategori dan tag
- Tampilan detail todo (halaman show)

---

## ☑️ Checklist

### Sesuai Instruksi Tugas
- [x] CRUD lengkap (Create, Read, Update, Delete)
- [x] Berbasis web menggunakan PHP / Laravel
- [x] Database lokal SQLite
- [x] Input: TextField ✅ Dropdown ✅ Radio ✅ Checkbox ✅ Switch ✅ Date ✅
- [x] Validasi semua field wajib diisi
- [x] Pesan error ditampilkan ke user
- [x] Read ditampilkan dalam bentuk list/tabel
- [x] Delete dengan alert konfirmasi

### Kualitas Kode
- [x] Relasi antar model sudah didefinisikan
- [x] Foreign key dengan `constrained()` di migration
- [x] `$fillable` didefinisikan di semua model
- [x] Validasi di controller (server-side)
- [ ] Validasi HTML `required` di semua form (perlu dicek ulang)
- [ ] Pesan error Bahasa Indonesia di semua controller (perlu diterapkan ke Kategori & Tag)

---

> Dokumentasi ini dibuat berdasarkan progres pengerjaan proyek. Diperbarui terakhir: Mei 2026.