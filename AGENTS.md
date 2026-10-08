# AGENTS.md — Laravel Asset & Frontend Guidelines

Dokumen ini berisi standar dan aturan wajib bagi AI Agent maupun Pengembang (Developer) yang bekerja pada repositori **hamana-erp**. Seluruh aturan ini bertujuan menjaga performa aplikasi, konsistensi struktur direktori, dan kemudahan pemeliharaan (*maintainability*).

---

## 1. Aturan Utama Lokasi Berkas (*Primary Directive*)

1. **DILARANG** menulis atau meletakkan berkas kustom CSS atau JavaScript secara langsung di dalam direktori `public/css/`, `public/js/`, atau sub-folder lain di `public/`.
2. **WAJIB** menulis seluruh kode kustom CSS, Tailwind, JavaScript, Vue, React, atau komponen frontend lainnya di dalam direktori `resources/`:
   - `resources/css/` — Untuk gaya visual, definisi Tailwind, dan stylesheet.
   - `resources/js/` — Untuk logika JavaScript, modul, dan integrasi UI.
3. Seluruh berkas di `resources/` **harus** diproses melalui **Vite** sebelum disajikan ke lingkungan produksi.

---

## 2. Pengecualian Direktori `public/`

Folder `public/` hanya diperbolehkan untuk menyimpan:
- Berkas statis murni yang tidak memerlukan kompilasi (misal: `favicon.ico`, `robots.txt`).
- Aset gambar/media statis bawaan aplikasi (`public/images/`, `public/icons/`).
- Berkas hasil kompilasi otomatis dari Vite (folder `public/build/`). Jangan memodifikasi isi folder `public/build/` secara manual!
- Pustaka pihak ketiga (*third-party vendor*) versi terkompilasi **hanya jika** pustaka tersebut tidak dapat diinstal melalui NPM.

---

## 3. Integrasi Vite & Blade Layouts

### A. Konfigurasi Entry Points (`vite.config.js`)
Setiap berkas JS atau CSS utama yang dibuat di `resources/` harus didaftarkan ke dalam file `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

### B. Penggunaan pada Blade Template
Gunakan direktif `@vite` pada bagian `<head>` di berkas Blade layout utama (misal: `resources/views/layouts/app.blade.php`):

```html
<!-- BENAR -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- SALAH - Dilarang memanggil langsung berkas di public/ atau resources/ tanpa direktif Vite -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
```

---

## 4. Manajemen Pustaka Pihak Ketiga (Packages)

1. Prioritaskan pemasangan pustaka frontend menggunakan **NPM**:
   ```bash
   npm install package-name
   ```
   Lalu *import* pustaka tersebut di dalam `resources/js/app.js` atau `resources/css/app.css`.
2. Hindari penggunaan CDN langsung pada file Blade kecuali untuk pengujian cepat (*prototyping* sementara).

---

## 5. Ringkasan Alur Kerja Pengkodingan (Workflow Checklist)

Sebelum menyelesaikan tugas atau *pull request* yang melibatkan frontend, AI Agent / Developer wajib memastikan:

- [ ] Tidak ada berkas JS/CSS kustom baru yang dibuat di direktori `public/`.
- [ ] Berkas baru di `resources/css/` atau `resources/js/` sudah di-import di entry point utama atau didaftarkan di `vite.config.js`.
- [ ] Template Blade telah memuat aset menggunakan `@vite(...)`.
- [ ] Perintah `npm run build` berjalan tanpa error saat menyiapkan rilis produksi.