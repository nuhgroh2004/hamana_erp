# Desain UI — ERP Karoseri Car Carrier (Gaya Odoo)

Dokumen ini menjelaskan sistem desain dari `erp-karoseri-odoo.html`. Tujuannya agar halaman baru yang dibuat nanti tetap konsisten.

## 1. Prinsip

- **Sederhana dan fungsional.** Tanpa animasi dekoratif. Satu-satunya transisi adalah sidebar yang bergeser di layar kecil (0,15 detik).
- **Kotak.** Semua elemen memakai `border-radius: 0`, kecuali logo bulat di header sidebar.
- **Sidebar saja.** Tidak ada navbar atas. Semua navigasi ada di sidebar.
- **Mirip Odoo.** Ungu aubergine sebagai warna utama, teal sebagai aksen sekunder, latar terang dan bersih.
- **Satu file.** HTML, CSS, dan JS ada dalam satu berkas tanpa library eksternal.

## 2. Warna

Semua warna didefinisikan sebagai CSS variable di `:root`.

| Token | Terang | Gelap | Pemakaian |
|---|---|---|---|
| `--bg` | `#f9fafb` | `#1b1d21` | Latar halaman utama |
| `--side` | `#ffffff` | `#262a30` | Latar sidebar, kartu |
| `--ink` | `#212529` | `#e9ecef` | Teks utama |
| `--mut` | `#6c757d` | `#9aa1a9` | Teks sekunder, item menu |
| `--line` | `#d8dadd` | `#3a3f46` | Garis pemisah, border |
| `--acc` | `#714b67` | `#b78aab` | Warna utama (ungu Odoo) |
| `--accbg` | `#f1e8ef` | `#3a2a36` | Latar item menu aktif |
| `--teal` | `#017e84` | — | Aksen sekunder (garis atas kartu, hover tombol) |

Warna tambahan yang dipakai langsung:

- `#714b67` untuk latar header sidebar.
- `#e6d5e1` untuk teks kecil di header.
- `#ffffff` untuk logo dan teks header.

**Mode gelap** mengikuti pengaturan sistem (`prefers-color-scheme`). Tombol "Tema" di footer sidebar menimpa pengaturan itu lewat atribut `data-theme` pada `<html>`.

## 3. Tipografi

- **Font:** `Roboto`, lalu `Odoo Unicode Support Noto`, `Segoe UI`, `Helvetica`, `Arial`, `sans-serif`.
- Roboto tidak dimuat dari server, jadi font yang tampil mengikuti perangkat.

| Elemen | Ukuran | Berat |
|---|---|---|
| Teks dasar | 14 px (line-height 1,5) | 400 |
| Judul halaman (`h1`) | 24 px | 500 |
| Nama aplikasi di header | 16 px | 500 |
| Judul grup menu | 13 px | 500 |
| Item menu | 14 px | 400 (aktif: 600) |
| Teks kecil (breadcrumb, footer) | 11–12 px | 400 |

Judul grup menu **tidak** memakai huruf kapital, sesuai gaya Odoo.

## 4. Tata Letak

```
┌────────────┬──────────────────────────────┐
│  SIDEBAR   │  breadcrumb                  │
│  272 px    │  Judul halaman               │
│            │  ┌────────────────────────┐  │
│  header    │  │  area konten           │  │
│  pencarian │  └────────────────────────┘  │
│  menu      │                              │
│  footer    │                              │
└────────────┴──────────────────────────────┘
```

- `body` memakai `display: flex` setinggi layar penuh.
- Sidebar selebar **272 px** dan tidak menyusut. Bagian menunya bisa di-scroll sendiri.
- Area konten (`main`) mengisi sisa lebar, dengan padding **32 px** (20 px di HP).
- Tidak ada navbar. Konten langsung dimulai dari breadcrumb dan judul.

## 5. Komponen

### 5.1 Header sidebar
- Latar `#714b67`, teks putih, padding 12 × 16 px.
- Logo bulat putih 30 × 30 px berisi huruf "K" berwarna ungu.
- Dua baris teks: nama aplikasi dan subjudul "Spesialis Car Carrier".

### 5.2 Kolom pencarian
- Input selebar penuh dengan border 1 px `--line`.
- Saat fokus, border berubah ungu (`--acc`).
- Pencarian menyaring nama menu dan nama grup. Saat mencari, semua grup yang cocok terbuka otomatis.

### 5.3 Grup menu
- Berupa tombol selebar penuh dengan teks ungu, berat 500, padding 8 × 16 px.
- Penanda di kanan: `+` saat tertutup, `−` saat terbuka.
- Hover memberi latar gelap tipis (`rgba(0,0,0,.04)`).
- Hanya grup berisi menu aktif yang terbuka saat halaman dimuat.

### 5.4 Item menu
- Daftar di dalam grup, dengan garis vertikal 1 px di kiri dan indentasi 20 px.
- Padding 5 × 14 px, warna `--mut`.
- Hover: teks menjadi `--ink` dan latar tipis.
- **Aktif:** teks ungu, latar `--accbg`, garis kiri ungu 3 px, berat 600.

### 5.5 Footer sidebar
- Menampilkan versi dan peran pengguna ("v1.0 · Admin") di kiri.
- Tombol "Tema" di kanan. Hover tombol: latar teal, teks putih.

### 5.6 Kartu konten
- Latar `--side`, border 1 px `--line`, **garis atas teal 3 px**.
- Padding 48 × 24 px. Saat ini hanya berisi pesan placeholder.
- Bentuk yang sama dipakai untuk kartu KPI, tabel, dan formulir.

## 6. Perilaku

- **Klik grup:** membuka atau menutup grup tersebut.
- **Klik item:** menandai item sebagai aktif, mengganti breadcrumb (nama grup) dan judul halaman (nama menu). Tidak ada navigasi halaman.
- **Pencarian:** menyaring menu secara langsung saat mengetik.
- **Tombol Tema:** beralih terang/gelap.
- **Layar ≤ 760 px:** sidebar tersembunyi di kiri layar. Tombol "☰ Menu" muncul di atas konten untuk membukanya. Sidebar menutup lagi setelah satu menu dipilih.

## 7. Struktur Menu

Menu disimpan dalam array `M` di JavaScript. Formatnya `[namaGrup, [item, item, ...]]`. Untuk menambah menu, cukup edit array ini. Ada 20 grup:

1. Dashboard
2. Penjualan & CRM
3. Engineering & Desain
4. Unit & Chassis
5. Perencanaan Produksi
6. Manufaktur
7. Quality Control
8. Pembelian
9. Inventori & Gudang
10. Maintenance
11. Logistik & Pengiriman
12. Akuntansi & Keuangan
13. Aset Tetap
14. Proyek
15. SDM & Payroll
16. K3 & Lingkungan
17. After Sales
18. Dokumen & Legal
19. Laporan & Analitik
20. Pengaturan

Urutan mengikuti alur bisnis karoseri: penjualan → engineering → unit → produksi → kualitas → pengiriman, dengan fungsi pendukung (keuangan, SDM, dll.) di bagian bawah.

## 8. Panduan Membuat Halaman Baru

Gunakan aturan berikut agar konsisten dengan desain ini:

1. Selalu pakai CSS variable (`var(--acc)`, `var(--line)`, dst.), jangan tulis warna langsung. Dengan begitu mode gelap ikut bekerja.
2. Tetap `border-radius: 0`.
3. Bungkus blok konten dengan gaya kartu (bagian 5.6).
4. Tombol utama berlatar ungu `--acc` dengan teks putih. Tombol sekunder berlatar putih dengan border `--line`. Hover tombol sekunder memakai teal.
5. Tabel: header berlatar `--bg`, baris dipisah garis 1 px `--line`, tanpa warna selang-seling.
6. Status (misalnya "Draft", "Dalam Proses", "Selesai") memakai kotak kecil dengan latar muda dan teks gelap dari warna yang sama, tanpa sudut membulat.
7. Hindari bayangan, gradien, dan animasi.

## 9. Berkas Terkait

- `erp-karoseri-odoo.html` — implementasi gaya Odoo (dokumen ini).
- `erp-karoseri.html` — versi bergaya Claude/Anthropic (krem dan terakota), dengan struktur yang sama.
