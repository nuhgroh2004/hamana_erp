const menuData = [
    ["Dashboard", ["Ringkasan Eksekutif", "Dashboard Produksi", "Dashboard Penjualan", "Dashboard Keuangan"]],
    ["Penjualan & CRM", ["Lead & Peluang", "Pelanggan / Dealer", "Penawaran (Quotation)", "Sales Order", "Kontrak Unit", "Price List", "Komisi Sales", "Laporan Penjualan"]],
    ["Engineering & Desain", ["Spesifikasi Car Carrier", "Gambar Teknik", "Bill of Materials (BOM)", "Engineering Change (ECN)", "Perhitungan Beban & Kekuatan", "Dokumen Rancang Bangun", "Library Komponen"]],
    ["Unit & Chassis", ["Penerimaan Chassis", "Registrasi Unit (VIN)", "Job Card Unit", "Status Pengerjaan", "Serah Terima Unit", "Surat Uji Tipe / SRUT", "KIR & STNK", "Garansi Unit"]],
    ["Perencanaan Produksi", ["Master Production Schedule", "Perencanaan Kapasitas", "Kebutuhan Material (MRP)", "Jadwal Produksi", "Backlog Order"]],
    ["Manufaktur", ["Manufacturing Order", "Work Order", "Work Center", "Routing / Proses", "Potong & Bending Plat", "Pengelasan", "Perakitan Deck & Ramp", "Sistem Hidrolik", "Pengecatan", "Finishing & Aksesoris", "Subkontrak", "Scrap & Rework"]],
    ["Quality Control", ["Inspeksi Material Masuk", "Inspeksi Proses (IPQC)", "Inspeksi Las (WPS/NDT)", "Uji Hidrolik & Beban", "Final Inspection", "Non-Conformance (NCR)", "Tindakan Korektif (CAPA)", "Sertifikat & Kalibrasi"]],
    ["Pembelian", ["Permintaan Pembelian (PR)", "RFQ", "Purchase Order", "Vendor / Supplier", "Evaluasi Vendor", "Kontrak Subkon", "Laporan Pembelian"]],
    ["Inventori & Gudang", ["Stok Barang", "Penerimaan Barang", "Pengeluaran Barang", "Transfer Antar Gudang", "Lot / Serial Number", "Stock Opname", "Lokasi & Rak", "Landed Cost", "Valuasi Persediaan"]],
    ["Maintenance", ["Daftar Mesin & Alat", "Preventive Maintenance", "Corrective Maintenance", "Permintaan Perbaikan", "Sparepart", "Kalibrasi Alat"]],
    ["Logistik & Pengiriman", ["Surat Jalan", "Jadwal Pengiriman", "Armada & Driver", "Ekspedisi", "Pengantaran Unit"]],
    ["Akuntansi & Keuangan", ["Jurnal Umum", "Buku Besar", "Hutang (AP)", "Piutang (AR)", "Kas & Bank", "Faktur Pajak / e-Faktur", "Costing Produksi / HPP", "Anggaran (Budget)", "Laporan Keuangan"]],
    ["Aset Tetap", ["Daftar Aset", "Penyusutan", "Mutasi & Disposal"]],
    ["Proyek", ["Daftar Proyek", "Tugas & Timeline", "Timesheet", "Biaya Proyek"]],
    ["SDM & Payroll", ["Karyawan", "Absensi & Shift", "Lembur", "Cuti & Izin", "Payroll", "BPJS & Pajak PPh21", "Rekrutmen", "Pelatihan & Sertifikasi Welder", "Penilaian Kinerja"]],
    ["K3 & Lingkungan", ["Insiden & Kecelakaan Kerja", "Inspeksi K3", "APD", "Limbah B3", "Izin Kerja Panas"]],
    ["After Sales", ["Klaim Garansi", "Servis & Perbaikan", "Tiket Keluhan", "Suku Cadang Pelanggan"]],
    ["Dokumen & Legal", ["Dokumen Perusahaan", "Perizinan", "Kontrak", "Arsip Digital"]],
    ["Laporan & Analitik", ["Laporan Produksi", "Laporan Biaya", "Laporan Stok", "Laporan Kualitas", "Laporan Custom"]],
    ["Pengaturan", ["Perusahaan & Cabang", "Pengguna & Hak Akses", "Master Data", "Satuan Ukur", "Penomoran Dokumen", "Alur Persetujuan", "Integrasi & API", "Backup"]],
];

function initSidebar() {
    const sideEl = document.getElementById('side');
    const navEl = document.getElementById('nav');
    const qEl = document.getElementById('q');
    const crumbEl = document.getElementById('crumb');
    const titleEl = document.getElementById('title');
    const menuBtnEl = document.getElementById('menuBtn');
    const themeEl = document.getElementById('theme');

    if (!sideEl || !navEl || !qEl) return;

    let cur = ['Dashboard', ''];

    const isOpen = (group, filter) => Boolean(filter) || group === cur[0];

    function render(filter = '') {
        navEl.innerHTML = '';

        menuData.forEach(([group, items]) => {
            const list = items.filter((item) =>
                !filter
                || item.toLowerCase().includes(filter)
                || group.toLowerCase().includes(filter)
            );

            if (!list.length) return;

            const open = isOpen(group, filter);
            const wrap = document.createElement('div');
            wrap.className = 'grp' + (open ? ' open' : '');

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.append(group);

            const marker = document.createElement('i');
            marker.textContent = open ? '−' : '+';
            btn.append(marker);

            const listEl = document.createElement('ul');

            list.forEach((name) => {
                const li = document.createElement('li');
                const link = document.createElement('a');
                link.dataset.g = group;
                link.textContent = name;

                if (group === cur[0] && name === cur[1]) {
                    link.classList.add('on');
                }

                link.addEventListener('click', () => {
                    cur = [group, name];
                    if (crumbEl) crumbEl.textContent = group;
                    if (titleEl) titleEl.textContent = name;
                    navEl.querySelectorAll('a.on').forEach((el) => el.classList.remove('on'));
                    link.classList.add('on');
                    sideEl.classList.remove('show');
                });

                li.append(link);
                listEl.append(li);
            });

            btn.addEventListener('click', () => {
                wrap.classList.toggle('open');
                marker.textContent = wrap.classList.contains('open') ? '−' : '+';
            });

            wrap.append(btn, listEl);
            navEl.append(wrap);
        });
    }

    render();

    qEl.addEventListener('input', () => render(qEl.value.trim().toLowerCase()));

    if (menuBtnEl) {
        menuBtnEl.addEventListener('click', () => sideEl.classList.toggle('show'));
    }

    if (themeEl) {
        themeEl.addEventListener('click', () => {
            const root = document.documentElement;
            const isDark = getComputedStyle(root).getPropertyValue('--bg').trim() === '#1b1d21';
            root.dataset.theme = isDark ? 'light' : 'dark';
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSidebar);
} else {
    initSidebar();
}
