# PRD — Modul Rekrutmen

**Produk:** ERP Karoseri Car Carrier · **Modul:** SDM / Rekrutmen · **Stack:** Laravel (project existing, multi-modul) · **Status:** Draft v1.0

Referensi UI: prototipe `erp-rekrutmen-odoo.html` dan `desain.md` (gaya Odoo, sidebar saja, kotak, tanpa animasi).

## 1. Latar Belakang dan Tujuan

Proses rekrutmen saat ini tersebar di spreadsheet, chat, dan folder dokumen. Akibatnya status kandidat tidak jelas, jadwal interview bentrok, dan data karyawan harus diketik ulang setelah kandidat diterima. Perusahaan karoseri juga punya kebutuhan khusus: banyak posisi teknis (welder, fabricator, painter, operator CNC) yang wajib lewat tes praktik dan pengecekan sertifikat.

**Tujuan:**

- Satu sistem untuk seluruh siklus: permintaan tenaga kerja → lowongan → kandidat → seleksi → penawaran → onboarding.
- Kandidat yang diterima otomatis menjadi data karyawan di modul SDM, tanpa input ulang.
- Waktu rekrutmen (time-to-hire) dan biaya per hire bisa diukur.
- Semua perpindahan tahap tercatat (audit trail).

**Metrik keberhasilan (3 bulan setelah rilis):**

| Metrik | Target |
| --- | --- |
| Penggunaan sistem oleh HRD untuk semua lowongan baru | 100% |
| Time-to-hire rata-rata | turun 20% dari baseline |
| Data karyawan baru yang diinput ulang manual | 0 |
| Jadwal interview bentrok | 0 |

## 2. Ruang Lingkup

**Termasuk (In Scope):**

1. Permintaan Tenaga Kerja (MPP) dan alur persetujuan.
2. Lowongan kerja, termasuk halaman karier publik dan formulir lamaran.
3. Data kandidat, dokumen, dan sumber kandidat.
4. Pipeline seleksi 7 tahap (papan kanban) dan riwayat perpindahan tahap.
5. Tes teknis dan penilaian (termasuk tes praktik).
6. Jadwal dan penilaian interview.
7. Penawaran kerja (offering).
8. Talent pool.
9. Onboarding dengan daftar periksa.
10. Dashboard dan laporan.
11. Pengaturan: tahapan, template email, sumber kandidat.

**Tidak termasuk (Out of Scope, fase ini):**

- Integrasi job board eksternal (JobStreet, LinkedIn) lewat API. Fase 1 hanya mencatat sumber secara manual.
- Tes psikologi online dan video interview.
- Penggajian dan kontrak elektronik bertanda tangan digital (kontrak diunggah sebagai PDF).
- Aplikasi mobile native.

## 3. Peran dan Hak Akses

Gunakan sistem role dan permission yang sudah ada di project (misalnya Spatie Permission bila sudah dipakai). Jangan membuat sistem baru.

| Peran | Hak utama |
| --- | --- |
| Admin HRD | Semua fitur, termasuk pengaturan dan laporan |
| Recruiter | Kelola lowongan, kandidat, pipeline, jadwal, penawaran |
| Manajer Departemen | Ajukan MPP, lihat kandidat posisinya, isi penilaian interview user |
| Pewawancara / Penguji | Lihat jadwal sendiri dan isi penilaian |
| Direksi / Approver | Setujui MPP dan penawaran |
| Publik (tanpa login) | Lihat lowongan aktif dan kirim lamaran |

Daftar permission (format `recruitment.<resource>.<aksi>`): `job_request.view|create|approve`, `job_posting.view|create|update|publish|close`, `candidate.view|create|update|delete|export`, `application.move|reject`, `interview.view|schedule|score`, `offer.view|create|approve`, `talent_pool.view`, `onboarding.view|update`, `report.view`, `setting.manage`.

## 4. Alur Bisnis

1. Manajer departemen membuat **Permintaan Tenaga Kerja** → status Menunggu → disetujui atau ditolak oleh Approver.
2. MPP yang disetujui menjadi dasar **Lowongan** (kuota tidak boleh melebihi MPP). Lowongan berstatus Draft, Aktif, atau Ditutup.
3. Pelamar masuk dari halaman karier publik atau diinput recruiter. Sistem membuat **Kandidat** dan **Lamaran**.
4. Lamaran bergerak lewat tahap: **Baru → Screening → Tes Teknis → Interview HR → Interview User → Offering → Hired**. Dari tahap mana pun lamaran bisa **Ditolak** (wajib mengisi alasan).
5. Di tahap Offering, recruiter membuat **Penawaran** → Approver menyetujui → dikirim ke kandidat → kandidat Diterima atau Menolak.
6. Saat penawaran Diterima, lamaran menjadi Hired, kuota lowongan terisi, dan sistem membuat **Onboarding** serta draft data karyawan di modul SDM.
7. Kandidat yang ditolak tetapi berpotensi dapat dimasukkan ke **Talent Pool**.

**Aturan bisnis penting:**

- Tahap tidak boleh dilompati, kecuali oleh Admin HRD dengan alasan tercatat.
- Kandidat dengan email atau NIK yang sama tidak dibuat dua kali. Sistem menawarkan penggabungan.
- Satu kandidat boleh melamar ke beberapa lowongan, tetapi hanya satu lamaran aktif per lowongan.
- Lowongan otomatis Ditutup saat kuota terpenuhi atau batas daftar lewat.
- Posisi bertanda wajib sertifikat (misalnya Welder 6G) tidak bisa lanjut dari Tes Teknis tanpa dokumen sertifikat atau hasil tes praktik.
- Interview tidak boleh dijadwalkan bila pewawancara atau ruangan sudah terpakai di jam yang sama.

## 5. Kebutuhan Fungsional

Prioritas: **P0** wajib rilis pertama, **P1** penting, **P2** bila waktu cukup.

### 5.1 Permintaan Tenaga Kerja (MPP)

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-01 | Buat, ubah, dan batalkan permintaan (departemen, posisi, jumlah, alasan, target mulai). | P0 |
| FR-02 | Alur persetujuan berjenjang dengan catatan approver. | P0 |
| FR-03 | Notifikasi ke approver dan pemohon saat status berubah. | P1 |

### 5.2 Lowongan

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-10 | CRUD lowongan: posisi, departemen, lokasi, kuota, kualifikasi, deskripsi, batas daftar, prioritas. | P0 |
| FR-11 | Publikasi dan penutupan lowongan; halaman karier publik hanya menampilkan yang Aktif. | P0 |
| FR-12 | Formulir lamaran publik: data diri, pendidikan, pengalaman, unggah CV, KTP, ijazah, sertifikat. | P0 |
| FR-13 | Perlindungan spam pada formulir publik (rate limit dan captcha). | P1 |
| FR-14 | Tampilkan progres kuota (hired / kuota) dan jumlah pelamar. | P0 |

### 5.3 Kandidat

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-20 | Daftar kandidat dengan pencarian (nama, kota), filter posisi dan tahap, serta paginasi. | P0 |
| FR-21 | Detail kandidat: profil, dokumen, skor tes, catatan, riwayat tahap. | P0 |
| FR-22 | Tambah kandidat manual dan impor dari CSV. | P1 |
| FR-23 | Deteksi duplikat (email, NIK, nomor HP). | P1 |
| FR-24 | Ekspor daftar kandidat ke Excel. | P2 |

### 5.4 Pipeline Seleksi

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-30 | Papan kanban per tahap dengan filter posisi. | P0 |
| FR-31 | Pindah tahap lewat tombol di detail kandidat (drag and drop opsional di P2). | P0 |
| FR-32 | Tolak lamaran dengan alasan terstruktur (daftar alasan dari pengaturan). | P0 |
| FR-33 | Setiap perpindahan tercatat: siapa, kapan, dari tahap mana ke mana, alasan. | P0 |
| FR-34 | Email otomatis dari template saat pindah tahap atau ditolak (bisa dimatikan). | P1 |

### 5.5 Tes dan Interview

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-40 | Catat hasil tes teknis (jenis tes, skor, hasil lulus atau tidak, penguji, lampiran). | P0 |
| FR-41 | Jadwalkan interview: waktu, jenis, pewawancara, tempat. | P0 |
| FR-42 | Validasi bentrok jadwal pewawancara dan ruangan. | P0 |
| FR-43 | Formulir penilaian interview dengan kriteria berbobot dan rekomendasi (lanjut / tahan / tolak). | P1 |
| FR-44 | Notifikasi jadwal ke kandidat dan pewawancara. | P1 |

### 5.6 Penawaran dan Onboarding

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-50 | Buat penawaran: gaji pokok, tunjangan, tanggal mulai, masa berlaku, status. | P0 |
| FR-51 | Persetujuan penawaran oleh Approver, lalu tandai Diterima atau Ditolak. | P0 |
| FR-52 | Saat Diterima: buat onboarding dan draft karyawan di modul SDM. | P0 |
| FR-53 | Daftar periksa onboarding dari template (kontrak, dokumen, medical check-up, BPJS, APD, induksi K3, akun, mentor). | P0 |
| FR-54 | Cetak surat penawaran dalam PDF dari template. | P1 |

### 5.7 Talent Pool, Dashboard, Laporan, Pengaturan

| ID | Kebutuhan | Prioritas |
| --- | --- | --- |
| FR-60 | Masukkan atau keluarkan kandidat dari talent pool dengan tag keahlian. | P1 |
| FR-70 | Dashboard: lowongan aktif, total kandidat, interview minggu ini, offer pending, hired bulan ini, time-to-hire, funnel, aktivitas terbaru. | P0 |
| FR-71 | Laporan: kandidat per sumber, per tahap, time-to-hire, cost-per-hire, offer acceptance rate. | P1 |
| FR-80 | Pengaturan: tahapan, alasan penolakan, sumber kandidat, template email, template onboarding. | P1 |

## 6. Model Data

Semua tabel memakai prefiks `recruitment_`, `id` bigint, `timestamps`, dan `softDeletes` untuk data utama. Relasi ke tabel existing (departemen, jabatan, user, karyawan) memakai foreign key ke tabel yang sudah ada di project. Sesuaikan nama tabel dengan konvensi project.

| Tabel | Kolom utama |
| --- | --- |
| `job_requests` | code, department\_id, position\_id, requested\_by, quantity, reason, target\_date, status, approved\_by, approved\_at, notes |
| `job_postings` | job\_request\_id, title, department\_id, location, quota, description, requirements, requires\_certificate, deadline, priority, status, published\_at, closed\_at |
| `sources` | name, is\_active |
| `candidates` | name, email, phone, national\_id, birth\_date, city, education, experience\_years, source\_id, user\_id (nullable), is\_talent\_pool, talent\_tags (json), notes |
| `candidate_documents` | candidate\_id, type (cv, ktp, ijazah, sertifikat), path, original\_name, size |
| `applications` | candidate\_id, job\_posting\_id, current\_stage\_id, status (active, rejected, hired, withdrawn), rejected\_reason\_id, applied\_at, closed\_at |
| `stages` | name, order, is\_active, is\_final |
| `application_stage_logs` | application\_id, from\_stage\_id, to\_stage\_id, changed\_by, reason, created\_at |
| `assessments` | application\_id, type, score, passed, assessor\_id, notes, attachment\_path, assessed\_at |
| `interviews` | application\_id, type (hr, user), scheduled\_at, duration\_minutes, location, status, recommendation |
| `interview_participants` | interview\_id, user\_id, role |
| `interview_scores` | interview\_id, scorer\_id, criteria, score, weight, comment |
| `offers` | application\_id, base\_salary, allowance, start\_date, valid\_until, status, approved\_by, responded\_at |
| `onboardings` | application\_id, employee\_id (nullable), start\_date, status |
| `onboarding_tasks` | onboarding\_id, title, is\_done, done\_by, done\_at |
| `rejection_reasons` | name, is\_active |
| `email_templates` | key, subject, body, is\_active |

**Indeks wajib:** `applications (job_posting_id, current_stage_id)`, `applications (candidate_id, job_posting_id)` unik untuk lamaran aktif, `candidates (email)`, `candidates (national_id)`, `interviews (scheduled_at)`.

**Data pribadi:** NIK, tanggal lahir, dan dokumen kandidat adalah data pribadi (UU PDP). Akses dibatasi permission, file disimpan di disk privat, dan ada kebijakan penghapusan kandidat setelah masa retensi yang ditetapkan HRD.

## 7. Arsitektur Backend (Laravel)

**Asumsi:** project sudah memakai pemisahan per modul. Ikuti struktur yang sudah ada. Contoh di bawah memakai `app/Modules/Recruitment`. Bila project memakai paket modul (misalnya nwidart/laravel-modules) atau folder domain lain, pakai pola yang sama di tempat tersebut. Jangan menyentuh kode modul lain kecuali lewat titik integrasi di bagian 9.

```
Recruitment/
├── Http/
│   ├── Controllers/        # tipis, satu resource satu controller
│   ├── Requests/           # validasi (FormRequest)
│   └── Resources/          # transformasi respons API
├── Models/
├── Enums/                  # status, tipe, tahap
├── Actions/                # satu aksi bisnis satu kelas
├── Services/               # logika lintas aksi (dashboard, laporan)
├── Policies/
├── Events/ Listeners/ Notifications/ Jobs/
├── Database/ (migrations, seeders, factories)
├── routes/ (web.php, api.php)
└── Tests/ (Feature, Unit)
```

**Pembagian tanggung jawab:**

| Lapisan | Tugas | Dilarang |
| --- | --- | --- |
| Controller | Terima request, panggil Action atau Service, kembalikan respons | Query rumit, logika bisnis, validasi inline |
| FormRequest | Validasi dan otorisasi dasar | Logika bisnis |
| Action | Satu aksi bisnis (misalnya `MoveApplicationStage`), dibungkus transaksi DB | Mengakses objek Request |
| Service | Logika gabungan atau pembacaan berat (statistik, laporan) | Mengembalikan response HTTP |
| Policy | Aturan siapa boleh melakukan apa | Query data |
| Model | Relasi, scope, cast | Logika alur kerja |

**Daftar Action utama:** `SubmitJobRequest`, `ApproveJobRequest`, `PublishJobPosting`, `CloseJobPosting`, `ReceiveApplication` (formulir publik), `CreateCandidate`, `MergeDuplicateCandidate`, `MoveApplicationStage`, `RejectApplication`, `ScheduleInterview`, `RecordAssessment`, `CreateOffer`, `ApproveOffer`, `AcceptOffer` (memicu Hired, onboarding, dan draft karyawan), `MoveToTalentPool`.

**Enum:** `JobRequestStatus`, `JobPostingStatus`, `ApplicationStatus`, `InterviewType`, `OfferStatus`, `DocumentType`.

**Event dan listener:** `ApplicationStageChanged` → kirim email template dan catat log. `OfferAccepted` → buat onboarding dan draft karyawan. `InterviewScheduled` → notifikasi ke peserta. Pengiriman email dan notifikasi berjalan lewat queue.

**Praktik wajib:**

- Semua perubahan status memakai transaksi database dan menulis `application_stage_logs`.
- Hindari N+1: gunakan eager loading, uji dengan `Model::preventLazyLoading()` di lingkungan non-produksi.
- Daftar besar memakai paginasi dan filter di sisi server.
- Upload file: validasi mime dan ukuran (maks 5 MB per file), simpan di disk privat, unduh lewat route ber-otorisasi.
- Penomoran otomatis untuk kode MPP, misalnya `MPP-0001`.
- Seeder untuk tahapan, alasan penolakan, sumber, dan template onboarding bawaan.

## 8. Aturan Controller

**Aturan utama: satu file controller tidak boleh melebihi 250 baris.** Toleransi sedikit boleh sampai maksimum 260 baris. Di atas 260 baris, pull request tidak boleh digabung sebelum dipecah.

Cara menghitung: jumlah seluruh baris file, termasuk baris kosong, komentar, dan import (sama dengan hasil `wc -l`).

**Aturan pendukung:**

1. Satu controller melayani satu resource. Jangan membuat controller serba-guna.
2. Method controller maksimal sekitar 20 baris. Selebihnya pindah ke Action atau Service.
3. Validasi selalu lewat FormRequest, bukan `$request->validate()` di dalam controller.
4. Otorisasi lewat Policy (`$this->authorize()` atau middleware `can:`), bukan pengecekan role manual.
5. Aksi tambahan di luar CRUD (pindah tahap, tolak, setujui, terima penawaran) dibuat sebagai **single-action controller** (`__invoke`) atau controller terpisah.
6. Query filter, pencarian, dan agregasi ditaruh di scope model atau Service, bukan di controller.
7. Controller tidak boleh memanggil model modul lain secara langsung. Gunakan Service atau kontrak antarmodul.

**Pemetaan controller (rencana, semuanya harus di bawah batas):**

| Controller | Tanggung jawab |
| --- | --- |
| `JobRequestController` | CRUD MPP |
| `JobRequestApprovalController` | Setujui atau tolak MPP (invokable) |
| `JobPostingController` | CRUD lowongan |
| `JobPostingStatusController` | Publikasi dan tutup lowongan |
| `CandidateController` | CRUD dan daftar kandidat |
| `CandidateDocumentController` | Unggah dan unduh dokumen |
| `CandidateImportController` | Impor CSV |
| `ApplicationController` | Daftar, detail, dan papan pipeline |
| `ApplicationStageController` | Pindah tahap |
| `ApplicationRejectController` | Tolak lamaran |
| `AssessmentController` | Tes teknis |
| `InterviewController` | Jadwal interview |
| `InterviewScoreController` | Penilaian interview |
| `OfferController` | CRUD penawaran |
| `OfferDecisionController` | Setujui, terima, atau tolak penawaran |
| `TalentPoolController` | Talent pool |
| `OnboardingController` | Onboarding dan daftar periksa |
| `DashboardController` | Data dashboard |
| `ReportController` | Laporan |
| `SettingController` | Pengaturan master (atau dipecah per master bila membesar) |
| `Public/CareerController` | Halaman karier dan formulir lamaran publik |

**Penegakan otomatis (masuk CI):**

Pemeriksaan cepat di shell:

```bash
find app/Modules/Recruitment -path '*Controllers*' -name '*.php' | xargs wc -l | grep -v total | awk '$1>260{print; bad=1} END{exit bad}'
```

Pemeriksaan lewat Pest:

```php
it('controller rekrutmen tidak lebih dari 260 baris', function () {
    foreach (glob(app_path('Modules/Recruitment/Http/Controllers/{,*/}*.php'), GLOB_BRACE) as $file) {
        expect(count(file($file)))->toBeLessThanOrEqual(260);
    }
});
```

Sesuaikan path dengan struktur modul project. Controller yang mendekati 230 baris sudah harus dipertimbangkan untuk dipecah, jangan menunggu sampai melewati batas.

## 9. Integrasi dengan Modul Lain

Jangan mengubah modul lain. Sambungkan lewat Service atau kontrak (interface) dan event.

| Modul | Integrasi |
| --- | --- |
| Master Departemen dan Jabatan | Dibaca untuk MPP dan lowongan (hanya baca) |
| Pengguna dan Hak Akses | Memakai role dan permission yang ada, menambah permission rekrutmen lewat seeder |
| SDM / Karyawan | Event `OfferAccepted` membuat draft karyawan lewat service SDM, lalu menyimpan `employee_id` di onboarding |
| Notifikasi dan Email | Memakai mekanisme notifikasi dan queue yang sudah ada |
| Dokumen atau File | Memakai disk storage yang sudah dikonfigurasi, folder `recruitment/` |
| Audit Log | Bila project sudah punya, pakai juga untuk perubahan data penting |

Pertanyaan terbuka tentang integrasi ada di bagian 14.

## 10. Rancangan API dan Route

Prefiks web: `/recruitment`. Prefiks API: `/api/v1/recruitment`. Semua route di balik autentikasi project kecuali karier publik. Contoh endpoint (gaya REST, nama disesuaikan konvensi project):

| Metode | Path | Fungsi |
| --- | --- | --- |
| GET | `/dashboard` | Data KPI dan funnel |
| GET, POST | `/job-requests` | Daftar dan buat MPP |
| PUT | `/job-requests/{id}` | Ubah MPP |
| POST | `/job-requests/{id}/approve` | Setujui atau tolak MPP |
| GET, POST | `/job-postings` | Daftar dan buat lowongan |
| PUT | `/job-postings/{id}` | Ubah lowongan |
| POST | `/job-postings/{id}/publish` | Publikasi |
| POST | `/job-postings/{id}/close` | Tutup |
| GET, POST | `/candidates` | Daftar dan buat kandidat |
| GET, PUT | `/candidates/{id}` | Detail dan ubah |
| POST | `/candidates/{id}/documents` | Unggah dokumen |
| GET | `/candidates/{id}/documents/{doc}` | Unduh dokumen |
| POST | `/candidates/import` | Impor CSV |
| GET | `/applications` | Daftar dan papan pipeline (filter posisi) |
| POST | `/applications/{id}/move` | Pindah tahap |
| POST | `/applications/{id}/reject` | Tolak |
| POST | `/applications/{id}/assessments` | Catat tes |
| GET, POST | `/interviews` | Daftar dan jadwalkan |
| POST | `/interviews/{id}/scores` | Isi penilaian |
| GET, POST | `/offers` | Daftar dan buat penawaran |
| POST | `/offers/{id}/decision` | Setujui, terima, atau tolak |
| GET | `/talent-pool` | Daftar talent pool |
| POST | `/candidates/{id}/talent-pool` | Masuk atau keluar talent pool |
| GET, PATCH | `/onboardings/{id}` | Detail dan centang tugas |
| GET | `/reports/{type}` | Laporan |
| GET, POST | `/careers`, `/careers/{id}/apply` | Karier publik (tanpa login, rate limit) |

**Format respons API:** JSON lewat API Resource, paginasi memakai format standar Laravel, error validasi status 422 dengan pesan Bahasa Indonesia.

## 11. Kebutuhan Frontend

**Stack:** ikuti stack frontend yang sudah dipakai project (Blade, Livewire, Inertia dengan Vue atau React, atau lainnya). Jangan menambah framework baru. Gunakan layout, sidebar, dan komponen bersama yang sudah ada.

**Gaya:** mengikuti `desain.md` dan prototipe: sidebar saja tanpa navbar atas, sudut kotak, warna ungu `#714b67` dan teal `#017e84`, tanpa animasi dekoratif, mode terang dan gelap lewat CSS variable.

**Menu sidebar:** Dashboard, Permintaan Tenaga Kerja, Lowongan, Pipeline Kandidat, Daftar Kandidat, Jadwal Interview, Penawaran Kerja, Talent Pool, Onboarding, Laporan, dan Pengaturan Rekrutmen. Menu tampil sesuai permission pengguna.

**Halaman dan perilaku:**

| Halaman | Isi dan perilaku |
| --- | --- |
| Dashboard | Kartu KPI, funnel, lowongan prioritas, aktivitas terbaru |
| MPP | Tabel, form buat atau ubah, tombol setujui atau tolak untuk approver |
| Lowongan | Tabel dengan progres kuota, form lowongan, aksi publikasi dan tutup |
| Pipeline | Kanban 7 tahap, filter posisi, klik kartu membuka panel detail |
| Kandidat | Tabel dengan pencarian dan filter, paginasi, ekspor |
| Panel detail kandidat | Panel samping: profil, dokumen, skor tes, riwayat, tombol Lanjut, Jadwalkan, Tolak, Aktifkan Kembali |
| Interview | Daftar jadwal, form jadwal dengan validasi bentrok, form penilaian |
| Penawaran | Tabel, form, status persetujuan dan jawaban |
| Talent Pool | Tabel dengan tag keahlian |
| Onboarding | Daftar periksa per karyawan baru |
| Laporan | Grafik batang sederhana dan tabel ringkasan |
| Karier publik | Daftar lowongan aktif dan formulir lamaran, tanpa sidebar |

**Komponen bersama (dibuat sekali, dipakai ulang):** tabel data dengan paginasi, kartu KPI, tag status, panel samping, papan kanban, kotak filter, unggah file dengan validasi, konfirmasi aksi, toast pesan.

**Aturan FE:**

- Setiap aksi yang mengubah data menampilkan konfirmasi atau pesan hasil.
- Tombol aksi disembunyikan atau dinonaktifkan sesuai permission, tetapi validasi tetap di server.
- Tampilan responsif: pada layar kurang dari 800 px sidebar menjadi laci dan tabel bisa digulir ke samping.
- Semua teks antarmuka Bahasa Indonesia, format tanggal dan angka mengikuti lokal Indonesia.
- Aksesibilitas dasar: label pada input, fokus keyboard terlihat, kontras warna memadai.

## 12. Kebutuhan Non-Fungsional

| Aspek | Kebutuhan |
| --- | --- |
| Keamanan | Otorisasi di setiap endpoint, CSRF aktif, validasi file upload, rate limit formulir publik, tidak ada data pribadi di log |
| Privasi | Data kandidat sesuai UU PDP: akses dibatasi, retensi dan penghapusan terdokumentasi |
| Performa | Daftar dan pipeline memuat kurang dari 2 detik untuk 10.000 kandidat, dengan paginasi dan indeks |
| Audit | Seluruh perpindahan tahap dan keputusan penting tercatat dengan pelaku dan waktu |
| Ketersediaan | Email dan notifikasi lewat queue agar tidak memperlambat respons |
| Kompatibilitas | Browser modern (Chrome, Edge, Firefox, Safari dua versi terakhir) dan layar HP |
| Pemeliharaan | Ikuti PSR-12 (Laravel Pint), analisis statis (Larastan), dan aturan controller di bagian 8 |

## 13. Pengujian dan Rilis

**Pengujian:**

- **Unit:** setiap Action (aturan bisnis: lompat tahap, duplikat kandidat, kuota, bentrok jadwal).
- **Feature:** setiap endpoint dengan skenario berhasil, validasi gagal, dan akses ditolak per peran.
- **Arsitektur:** tes batas panjang controller (bagian 8).
- **Manual (UAT):** satu alur penuh dari MPP sampai karyawan terbentuk, dijalankan oleh HRD.
- Cakupan target untuk Action dan Policy: minimal 80%.

**Migrasi dan data awal:** seeder tahapan, alasan penolakan, sumber, template onboarding, dan permission. Impor data kandidat lama dari spreadsheet lewat fitur impor CSV (FR-22).

**Fase pengerjaan:**

| Fase | Isi | Perkiraan |
| --- | --- | --- |
| 1 | Fondasi: migrasi, model, enum, permission, seeder, layout dan komponen bersama | 1 minggu |
| 2 | MPP, lowongan, kandidat, formulir karier publik | 2 minggu |
| 3 | Pipeline, tes, interview, riwayat tahap | 2 minggu |
| 4 | Penawaran, onboarding, integrasi karyawan | 1,5 minggu |
| 5 | Dashboard, laporan, talent pool, pengaturan | 1,5 minggu |
| 6 | UAT, perbaikan, dokumentasi, rilis | 1 minggu |

Perkiraan waktu mengasumsikan satu tim kecil (1 BE, 1 FE, 1 QA paruh waktu) dan bisa berubah setelah struktur project dicek.

## 14. Risiko dan Pertanyaan Terbuka

**Risiko:**

| Risiko | Mitigasi |
| --- | --- |
| Benturan dengan struktur atau konvensi modul yang sudah ada | Kajian singkat struktur project sebelum Fase 1, ikuti pola modul terbaru |
| Data karyawan di modul SDM punya field wajib yang tidak ada di data kandidat | Draft karyawan dengan field minimal, sisanya dilengkapi HRD saat onboarding |
| Formulir publik diserang spam | Rate limit, captcha, validasi server |
| Controller membengkak karena banyak aksi | Aturan bagian 8 dan pemeriksaan CI |
| Kebocoran data pribadi kandidat | Disk privat, otorisasi unduhan, retensi data |

**Pertanyaan terbuka (perlu dijawab sebelum Fase 1):**

1. Stack frontend apa yang dipakai project saat ini (Blade, Livewire, Inertia, SPA)?
2. Struktur modul yang dipakai (folder `app/Modules`, paket modul, atau lainnya) dan contoh modul acuan.
3. Sistem role dan permission yang dipakai, serta apakah sudah ada audit log dan modul notifikasi.
4. Field wajib data karyawan di modul SDM dan cara membuat karyawan dari kode (service atau API internal).
5. Berapa lama masa retensi data kandidat yang ditolak?
6. Apakah MPP perlu persetujuan berjenjang lebih dari satu level?
7. Apakah halaman karier publik memakai domain atau subdomain yang sama dengan ERP?
