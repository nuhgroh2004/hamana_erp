<nav id="nav">
    <div class="grp{{ request()->is('dashboard/*') ? ' open' : '' }}" data-g="Dashboard">
        <button type="button">Dashboard<i>{{ request()->is('dashboard/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('dashboard/ringkasan-eksekutif') }}" class="{{ request()->is('dashboard/ringkasan-eksekutif') ? 'on' : '' }}">Ringkasan Eksekutif</a></li>
            <li><a href="{{ url('dashboard/dashboard-produksi') }}" class="{{ request()->is('dashboard/dashboard-produksi') ? 'on' : '' }}">Dashboard Produksi</a></li>
            <li><a href="{{ url('dashboard/dashboard-penjualan') }}" class="{{ request()->is('dashboard/dashboard-penjualan') ? 'on' : '' }}">Dashboard Penjualan</a></li>
            <li><a href="{{ url('dashboard/dashboard-keuangan') }}" class="{{ request()->is('dashboard/dashboard-keuangan') ? 'on' : '' }}">Dashboard Keuangan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('penjualan-dan-crm/*') ? ' open' : '' }}" data-g="Penjualan &amp; CRM">
        <button type="button">Penjualan &amp; CRM<i>{{ request()->is('penjualan-dan-crm/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('penjualan-dan-crm/lead-dan-peluang') }}" class="{{ request()->is('penjualan-dan-crm/lead-dan-peluang') ? 'on' : '' }}">Lead &amp; Peluang</a></li>
            <li><a href="{{ url('penjualan-dan-crm/pelanggan-dealer') }}" class="{{ request()->is('penjualan-dan-crm/pelanggan-dealer') ? 'on' : '' }}">Pelanggan / Dealer</a></li>
            <li><a href="{{ url('penjualan-dan-crm/penawaran-quotation') }}" class="{{ request()->is('penjualan-dan-crm/penawaran-quotation') ? 'on' : '' }}">Penawaran (Quotation)</a></li>
            <li><a href="{{ url('penjualan-dan-crm/sales-order') }}" class="{{ request()->is('penjualan-dan-crm/sales-order') ? 'on' : '' }}">Sales Order</a></li>
            <li><a href="{{ url('penjualan-dan-crm/kontrak-unit') }}" class="{{ request()->is('penjualan-dan-crm/kontrak-unit') ? 'on' : '' }}">Kontrak Unit</a></li>
            <li><a href="{{ url('penjualan-dan-crm/price-list') }}" class="{{ request()->is('penjualan-dan-crm/price-list') ? 'on' : '' }}">Price List</a></li>
            <li><a href="{{ url('penjualan-dan-crm/komisi-sales') }}" class="{{ request()->is('penjualan-dan-crm/komisi-sales') ? 'on' : '' }}">Komisi Sales</a></li>
            <li><a href="{{ url('penjualan-dan-crm/laporan-penjualan') }}" class="{{ request()->is('penjualan-dan-crm/laporan-penjualan') ? 'on' : '' }}">Laporan Penjualan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('engineering-dan-desain/*') ? ' open' : '' }}" data-g="Engineering &amp; Desain">
        <button type="button">Engineering &amp; Desain<i>{{ request()->is('engineering-dan-desain/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('engineering-dan-desain/spesifikasi-car-carrier') }}" class="{{ request()->is('engineering-dan-desain/spesifikasi-car-carrier') ? 'on' : '' }}">Spesifikasi Car Carrier</a></li>
            <li><a href="{{ url('engineering-dan-desain/gambar-teknik') }}" class="{{ request()->is('engineering-dan-desain/gambar-teknik') ? 'on' : '' }}">Gambar Teknik</a></li>
            <li><a href="{{ url('engineering-dan-desain/bill-of-materials-bom') }}" class="{{ request()->is('engineering-dan-desain/bill-of-materials-bom') ? 'on' : '' }}">Bill of Materials (BOM)</a></li>
            <li><a href="{{ url('engineering-dan-desain/engineering-change-ecn') }}" class="{{ request()->is('engineering-dan-desain/engineering-change-ecn') ? 'on' : '' }}">Engineering Change (ECN)</a></li>
            <li><a href="{{ url('engineering-dan-desain/perhitungan-beban-dan-kekuatan') }}" class="{{ request()->is('engineering-dan-desain/perhitungan-beban-dan-kekuatan') ? 'on' : '' }}">Perhitungan Beban &amp; Kekuatan</a></li>
            <li><a href="{{ url('engineering-dan-desain/dokumen-rancang-bangun') }}" class="{{ request()->is('engineering-dan-desain/dokumen-rancang-bangun') ? 'on' : '' }}">Dokumen Rancang Bangun</a></li>
            <li><a href="{{ url('engineering-dan-desain/library-komponen') }}" class="{{ request()->is('engineering-dan-desain/library-komponen') ? 'on' : '' }}">Library Komponen</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('unit-dan-chassis/*') ? ' open' : '' }}" data-g="Unit &amp; Chassis">
        <button type="button">Unit &amp; Chassis<i>{{ request()->is('unit-dan-chassis/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('unit-dan-chassis/penerimaan-chassis') }}" class="{{ request()->is('unit-dan-chassis/penerimaan-chassis') ? 'on' : '' }}">Penerimaan Chassis</a></li>
            <li><a href="{{ url('unit-dan-chassis/registrasi-unit-vin') }}" class="{{ request()->is('unit-dan-chassis/registrasi-unit-vin') ? 'on' : '' }}">Registrasi Unit (VIN)</a></li>
            <li><a href="{{ url('unit-dan-chassis/job-card-unit') }}" class="{{ request()->is('unit-dan-chassis/job-card-unit') ? 'on' : '' }}">Job Card Unit</a></li>
            <li><a href="{{ url('unit-dan-chassis/status-pengerjaan') }}" class="{{ request()->is('unit-dan-chassis/status-pengerjaan') ? 'on' : '' }}">Status Pengerjaan</a></li>
            <li><a href="{{ url('unit-dan-chassis/serah-terima-unit') }}" class="{{ request()->is('unit-dan-chassis/serah-terima-unit') ? 'on' : '' }}">Serah Terima Unit</a></li>
            <li><a href="{{ url('unit-dan-chassis/surat-uji-tipe-srut') }}" class="{{ request()->is('unit-dan-chassis/surat-uji-tipe-srut') ? 'on' : '' }}">Surat Uji Tipe / SRUT</a></li>
            <li><a href="{{ url('unit-dan-chassis/kir-dan-stnk') }}" class="{{ request()->is('unit-dan-chassis/kir-dan-stnk') ? 'on' : '' }}">KIR &amp; STNK</a></li>
            <li><a href="{{ url('unit-dan-chassis/garansi-unit') }}" class="{{ request()->is('unit-dan-chassis/garansi-unit') ? 'on' : '' }}">Garansi Unit</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('perencanaan-produksi/*') ? ' open' : '' }}" data-g="Perencanaan Produksi">
        <button type="button">Perencanaan Produksi<i>{{ request()->is('perencanaan-produksi/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('perencanaan-produksi/master-production-schedule') }}" class="{{ request()->is('perencanaan-produksi/master-production-schedule') ? 'on' : '' }}">Master Production Schedule</a></li>
            <li><a href="{{ url('perencanaan-produksi/perencanaan-kapasitas') }}" class="{{ request()->is('perencanaan-produksi/perencanaan-kapasitas') ? 'on' : '' }}">Perencanaan Kapasitas</a></li>
            <li><a href="{{ url('perencanaan-produksi/kebutuhan-material-mrp') }}" class="{{ request()->is('perencanaan-produksi/kebutuhan-material-mrp') ? 'on' : '' }}">Kebutuhan Material (MRP)</a></li>
            <li><a href="{{ url('perencanaan-produksi/jadwal-produksi') }}" class="{{ request()->is('perencanaan-produksi/jadwal-produksi') ? 'on' : '' }}">Jadwal Produksi</a></li>
            <li><a href="{{ url('perencanaan-produksi/backlog-order') }}" class="{{ request()->is('perencanaan-produksi/backlog-order') ? 'on' : '' }}">Backlog Order</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('manufaktur/*') ? ' open' : '' }}" data-g="Manufaktur">
        <button type="button">Manufaktur<i>{{ request()->is('manufaktur/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('manufaktur/manufacturing-order') }}" class="{{ request()->is('manufaktur/manufacturing-order') ? 'on' : '' }}">Manufacturing Order</a></li>
            <li><a href="{{ url('manufaktur/work-order') }}" class="{{ request()->is('manufaktur/work-order') ? 'on' : '' }}">Work Order</a></li>
            <li><a href="{{ url('manufaktur/work-center') }}" class="{{ request()->is('manufaktur/work-center') ? 'on' : '' }}">Work Center</a></li>
            <li><a href="{{ url('manufaktur/routing-proses') }}" class="{{ request()->is('manufaktur/routing-proses') ? 'on' : '' }}">Routing / Proses</a></li>
            <li><a href="{{ url('manufaktur/potong-dan-bending-plat') }}" class="{{ request()->is('manufaktur/potong-dan-bending-plat') ? 'on' : '' }}">Potong &amp; Bending Plat</a></li>
            <li><a href="{{ url('manufaktur/pengelasan') }}" class="{{ request()->is('manufaktur/pengelasan') ? 'on' : '' }}">Pengelasan</a></li>
            <li><a href="{{ url('manufaktur/perakitan-deck-dan-ramp') }}" class="{{ request()->is('manufaktur/perakitan-deck-dan-ramp') ? 'on' : '' }}">Perakitan Deck &amp; Ramp</a></li>
            <li><a href="{{ url('manufaktur/sistem-hidrolik') }}" class="{{ request()->is('manufaktur/sistem-hidrolik') ? 'on' : '' }}">Sistem Hidrolik</a></li>
            <li><a href="{{ url('manufaktur/pengecatan') }}" class="{{ request()->is('manufaktur/pengecatan') ? 'on' : '' }}">Pengecatan</a></li>
            <li><a href="{{ url('manufaktur/finishing-dan-aksesoris') }}" class="{{ request()->is('manufaktur/finishing-dan-aksesoris') ? 'on' : '' }}">Finishing &amp; Aksesoris</a></li>
            <li><a href="{{ url('manufaktur/subkontrak') }}" class="{{ request()->is('manufaktur/subkontrak') ? 'on' : '' }}">Subkontrak</a></li>
            <li><a href="{{ url('manufaktur/scrap-dan-rework') }}" class="{{ request()->is('manufaktur/scrap-dan-rework') ? 'on' : '' }}">Scrap &amp; Rework</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('quality-control/*') ? ' open' : '' }}" data-g="Quality Control">
        <button type="button">Quality Control<i>{{ request()->is('quality-control/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('quality-control/inspeksi-material-masuk') }}" class="{{ request()->is('quality-control/inspeksi-material-masuk') ? 'on' : '' }}">Inspeksi Material Masuk</a></li>
            <li><a href="{{ url('quality-control/inspeksi-proses-ipqc') }}" class="{{ request()->is('quality-control/inspeksi-proses-ipqc') ? 'on' : '' }}">Inspeksi Proses (IPQC)</a></li>
            <li><a href="{{ url('quality-control/inspeksi-las-wps-ndt') }}" class="{{ request()->is('quality-control/inspeksi-las-wps-ndt') ? 'on' : '' }}">Inspeksi Las (WPS/NDT)</a></li>
            <li><a href="{{ url('quality-control/uji-hidrolik-dan-beban') }}" class="{{ request()->is('quality-control/uji-hidrolik-dan-beban') ? 'on' : '' }}">Uji Hidrolik &amp; Beban</a></li>
            <li><a href="{{ url('quality-control/final-inspection') }}" class="{{ request()->is('quality-control/final-inspection') ? 'on' : '' }}">Final Inspection</a></li>
            <li><a href="{{ url('quality-control/non-conformance-ncr') }}" class="{{ request()->is('quality-control/non-conformance-ncr') ? 'on' : '' }}">Non-Conformance (NCR)</a></li>
            <li><a href="{{ url('quality-control/tindakan-korektif-capa') }}" class="{{ request()->is('quality-control/tindakan-korektif-capa') ? 'on' : '' }}">Tindakan Korektif (CAPA)</a></li>
            <li><a href="{{ url('quality-control/sertifikat-dan-kalibrasi') }}" class="{{ request()->is('quality-control/sertifikat-dan-kalibrasi') ? 'on' : '' }}">Sertifikat &amp; Kalibrasi</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('pembelian/*') ? ' open' : '' }}" data-g="Pembelian">
        <button type="button">Pembelian<i>{{ request()->is('pembelian/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('pembelian/permintaan-pembelian-pr') }}" class="{{ request()->is('pembelian/permintaan-pembelian-pr') ? 'on' : '' }}">Permintaan Pembelian (PR)</a></li>
            <li><a href="{{ url('pembelian/rfq') }}" class="{{ request()->is('pembelian/rfq') ? 'on' : '' }}">RFQ</a></li>
            <li><a href="{{ url('pembelian/purchase-order') }}" class="{{ request()->is('pembelian/purchase-order') ? 'on' : '' }}">Purchase Order</a></li>
            <li><a href="{{ url('pembelian/vendor-supplier') }}" class="{{ request()->is('pembelian/vendor-supplier') ? 'on' : '' }}">Vendor / Supplier</a></li>
            <li><a href="{{ url('pembelian/evaluasi-vendor') }}" class="{{ request()->is('pembelian/evaluasi-vendor') ? 'on' : '' }}">Evaluasi Vendor</a></li>
            <li><a href="{{ url('pembelian/kontrak-subkon') }}" class="{{ request()->is('pembelian/kontrak-subkon') ? 'on' : '' }}">Kontrak Subkon</a></li>
            <li><a href="{{ url('pembelian/laporan-pembelian') }}" class="{{ request()->is('pembelian/laporan-pembelian') ? 'on' : '' }}">Laporan Pembelian</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('inventori-dan-gudang/*') ? ' open' : '' }}" data-g="Inventori &amp; Gudang">
        <button type="button">Inventori &amp; Gudang<i>{{ request()->is('inventori-dan-gudang/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('inventori-dan-gudang/stok-barang') }}" class="{{ request()->is('inventori-dan-gudang/stok-barang') ? 'on' : '' }}">Stok Barang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/penerimaan-barang') }}" class="{{ request()->is('inventori-dan-gudang/penerimaan-barang') ? 'on' : '' }}">Penerimaan Barang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/pengeluaran-barang') }}" class="{{ request()->is('inventori-dan-gudang/pengeluaran-barang') ? 'on' : '' }}">Pengeluaran Barang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/transfer-antar-gudang') }}" class="{{ request()->is('inventori-dan-gudang/transfer-antar-gudang') ? 'on' : '' }}">Transfer Antar Gudang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/lot-serial-number') }}" class="{{ request()->is('inventori-dan-gudang/lot-serial-number') ? 'on' : '' }}">Lot / Serial Number</a></li>
            <li><a href="{{ url('inventori-dan-gudang/stock-opname') }}" class="{{ request()->is('inventori-dan-gudang/stock-opname') ? 'on' : '' }}">Stock Opname</a></li>
            <li><a href="{{ url('inventori-dan-gudang/lokasi-dan-rak') }}" class="{{ request()->is('inventori-dan-gudang/lokasi-dan-rak') ? 'on' : '' }}">Lokasi &amp; Rak</a></li>
            <li><a href="{{ url('inventori-dan-gudang/landed-cost') }}" class="{{ request()->is('inventori-dan-gudang/landed-cost') ? 'on' : '' }}">Landed Cost</a></li>
            <li><a href="{{ url('inventori-dan-gudang/valuasi-persediaan') }}" class="{{ request()->is('inventori-dan-gudang/valuasi-persediaan') ? 'on' : '' }}">Valuasi Persediaan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('maintenance/*') ? ' open' : '' }}" data-g="Maintenance">
        <button type="button">Maintenance<i>{{ request()->is('maintenance/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('maintenance/daftar-mesin-dan-alat') }}" class="{{ request()->is('maintenance/daftar-mesin-dan-alat') ? 'on' : '' }}">Daftar Mesin &amp; Alat</a></li>
            <li><a href="{{ url('maintenance/preventive-maintenance') }}" class="{{ request()->is('maintenance/preventive-maintenance') ? 'on' : '' }}">Preventive Maintenance</a></li>
            <li><a href="{{ url('maintenance/corrective-maintenance') }}" class="{{ request()->is('maintenance/corrective-maintenance') ? 'on' : '' }}">Corrective Maintenance</a></li>
            <li><a href="{{ url('maintenance/permintaan-perbaikan') }}" class="{{ request()->is('maintenance/permintaan-perbaikan') ? 'on' : '' }}">Permintaan Perbaikan</a></li>
            <li><a href="{{ url('maintenance/sparepart') }}" class="{{ request()->is('maintenance/sparepart') ? 'on' : '' }}">Sparepart</a></li>
            <li><a href="{{ url('maintenance/kalibrasi-alat') }}" class="{{ request()->is('maintenance/kalibrasi-alat') ? 'on' : '' }}">Kalibrasi Alat</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('logistik-dan-pengiriman/*') ? ' open' : '' }}" data-g="Logistik &amp; Pengiriman">
        <button type="button">Logistik &amp; Pengiriman<i>{{ request()->is('logistik-dan-pengiriman/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('logistik-dan-pengiriman/surat-jalan') }}" class="{{ request()->is('logistik-dan-pengiriman/surat-jalan') ? 'on' : '' }}">Surat Jalan</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/jadwal-pengiriman') }}" class="{{ request()->is('logistik-dan-pengiriman/jadwal-pengiriman') ? 'on' : '' }}">Jadwal Pengiriman</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/armada-dan-driver') }}" class="{{ request()->is('logistik-dan-pengiriman/armada-dan-driver') ? 'on' : '' }}">Armada &amp; Driver</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/ekspedisi') }}" class="{{ request()->is('logistik-dan-pengiriman/ekspedisi') ? 'on' : '' }}">Ekspedisi</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/pengantaran-unit') }}" class="{{ request()->is('logistik-dan-pengiriman/pengantaran-unit') ? 'on' : '' }}">Pengantaran Unit</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('akuntansi-dan-keuangan/*') ? ' open' : '' }}" data-g="Akuntansi &amp; Keuangan">
        <button type="button">Akuntansi &amp; Keuangan<i>{{ request()->is('akuntansi-dan-keuangan/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('akuntansi-dan-keuangan/jurnal-umum') }}" class="{{ request()->is('akuntansi-dan-keuangan/jurnal-umum') ? 'on' : '' }}">Jurnal Umum</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/buku-besar') }}" class="{{ request()->is('akuntansi-dan-keuangan/buku-besar') ? 'on' : '' }}">Buku Besar</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/hutang-ap') }}" class="{{ request()->is('akuntansi-dan-keuangan/hutang-ap') ? 'on' : '' }}">Hutang (AP)</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/piutang-ar') }}" class="{{ request()->is('akuntansi-dan-keuangan/piutang-ar') ? 'on' : '' }}">Piutang (AR)</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/kas-dan-bank') }}" class="{{ request()->is('akuntansi-dan-keuangan/kas-dan-bank') ? 'on' : '' }}">Kas &amp; Bank</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/faktur-pajak-e-faktur') }}" class="{{ request()->is('akuntansi-dan-keuangan/faktur-pajak-e-faktur') ? 'on' : '' }}">Faktur Pajak / e-Faktur</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/costing-produksi-hpp') }}" class="{{ request()->is('akuntansi-dan-keuangan/costing-produksi-hpp') ? 'on' : '' }}">Costing Produksi / HPP</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/anggaran-budget') }}" class="{{ request()->is('akuntansi-dan-keuangan/anggaran-budget') ? 'on' : '' }}">Anggaran (Budget)</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/laporan-keuangan') }}" class="{{ request()->is('akuntansi-dan-keuangan/laporan-keuangan') ? 'on' : '' }}">Laporan Keuangan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('aset-tetap/*') ? ' open' : '' }}" data-g="Aset Tetap">
        <button type="button">Aset Tetap<i>{{ request()->is('aset-tetap/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('aset-tetap/daftar-aset') }}" class="{{ request()->is('aset-tetap/daftar-aset') ? 'on' : '' }}">Daftar Aset</a></li>
            <li><a href="{{ url('aset-tetap/penyusutan') }}" class="{{ request()->is('aset-tetap/penyusutan') ? 'on' : '' }}">Penyusutan</a></li>
            <li><a href="{{ url('aset-tetap/mutasi-dan-disposal') }}" class="{{ request()->is('aset-tetap/mutasi-dan-disposal') ? 'on' : '' }}">Mutasi &amp; Disposal</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('proyek/*') ? ' open' : '' }}" data-g="Proyek">
        <button type="button">Proyek<i>{{ request()->is('proyek/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('proyek/daftar-proyek') }}" class="{{ request()->is('proyek/daftar-proyek') ? 'on' : '' }}">Daftar Proyek</a></li>
            <li><a href="{{ url('proyek/tugas-dan-timeline') }}" class="{{ request()->is('proyek/tugas-dan-timeline') ? 'on' : '' }}">Tugas &amp; Timeline</a></li>
            <li><a href="{{ url('proyek/timesheet') }}" class="{{ request()->is('proyek/timesheet') ? 'on' : '' }}">Timesheet</a></li>
            <li><a href="{{ url('proyek/biaya-proyek') }}" class="{{ request()->is('proyek/biaya-proyek') ? 'on' : '' }}">Biaya Proyek</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('sdm-dan-payroll/*') ? ' open' : '' }}" data-g="SDM &amp; Payroll">
        <button type="button">SDM &amp; Payroll<i>{{ request()->is('sdm-dan-payroll/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('sdm-dan-payroll/karyawan') }}" class="{{ request()->is('sdm-dan-payroll/karyawan') ? 'on' : '' }}">Karyawan</a></li>
            <li><a href="{{ url('sdm-dan-payroll/absensi-dan-shift') }}" class="{{ request()->is('sdm-dan-payroll/absensi-dan-shift') ? 'on' : '' }}">Absensi &amp; Shift</a></li>
            <li><a href="{{ url('sdm-dan-payroll/lembur') }}" class="{{ request()->is('sdm-dan-payroll/lembur') ? 'on' : '' }}">Lembur</a></li>
            <li><a href="{{ url('sdm-dan-payroll/cuti-dan-izin') }}" class="{{ request()->is('sdm-dan-payroll/cuti-dan-izin') ? 'on' : '' }}">Cuti &amp; Izin</a></li>
            <li><a href="{{ url('sdm-dan-payroll/payroll') }}" class="{{ request()->is('sdm-dan-payroll/payroll') ? 'on' : '' }}">Payroll</a></li>
            <li><a href="{{ url('sdm-dan-payroll/bpjs-dan-pajak-pph21') }}" class="{{ request()->is('sdm-dan-payroll/bpjs-dan-pajak-pph21') ? 'on' : '' }}">BPJS &amp; Pajak PPh21</a></li>
            <li><a href="{{ url('sdm-dan-payroll/rekrutmen') }}" class="{{ request()->is('sdm-dan-payroll/rekrutmen') ? 'on' : '' }}">Rekrutmen</a></li>
            <li><a href="{{ url('sdm-dan-payroll/pelatihan-dan-sertifikasi-welder') }}" class="{{ request()->is('sdm-dan-payroll/pelatihan-dan-sertifikasi-welder') ? 'on' : '' }}">Pelatihan &amp; Sertifikasi Welder</a></li>
            <li><a href="{{ url('sdm-dan-payroll/penilaian-kinerja') }}" class="{{ request()->is('sdm-dan-payroll/penilaian-kinerja') ? 'on' : '' }}">Penilaian Kinerja</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('k3-dan-lingkungan/*') ? ' open' : '' }}" data-g="K3 &amp; Lingkungan">
        <button type="button">K3 &amp; Lingkungan<i>{{ request()->is('k3-dan-lingkungan/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('k3-dan-lingkungan/insiden-dan-kecelakaan-kerja') }}" class="{{ request()->is('k3-dan-lingkungan/insiden-dan-kecelakaan-kerja') ? 'on' : '' }}">Insiden &amp; Kecelakaan Kerja</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/inspeksi-k3') }}" class="{{ request()->is('k3-dan-lingkungan/inspeksi-k3') ? 'on' : '' }}">Inspeksi K3</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/apd') }}" class="{{ request()->is('k3-dan-lingkungan/apd') ? 'on' : '' }}">APD</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/limbah-b3') }}" class="{{ request()->is('k3-dan-lingkungan/limbah-b3') ? 'on' : '' }}">Limbah B3</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/izin-kerja-panas') }}" class="{{ request()->is('k3-dan-lingkungan/izin-kerja-panas') ? 'on' : '' }}">Izin Kerja Panas</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('after-sales/*') ? ' open' : '' }}" data-g="After Sales">
        <button type="button">After Sales<i>{{ request()->is('after-sales/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('after-sales/klaim-garansi') }}" class="{{ request()->is('after-sales/klaim-garansi') ? 'on' : '' }}">Klaim Garansi</a></li>
            <li><a href="{{ url('after-sales/servis-dan-perbaikan') }}" class="{{ request()->is('after-sales/servis-dan-perbaikan') ? 'on' : '' }}">Servis &amp; Perbaikan</a></li>
            <li><a href="{{ url('after-sales/tiket-keluhan') }}" class="{{ request()->is('after-sales/tiket-keluhan') ? 'on' : '' }}">Tiket Keluhan</a></li>
            <li><a href="{{ url('after-sales/suku-cadang-pelanggan') }}" class="{{ request()->is('after-sales/suku-cadang-pelanggan') ? 'on' : '' }}">Suku Cadang Pelanggan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('dokumen-dan-legal/*') ? ' open' : '' }}" data-g="Dokumen &amp; Legal">
        <button type="button">Dokumen &amp; Legal<i>{{ request()->is('dokumen-dan-legal/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('dokumen-dan-legal/dokumen-perusahaan') }}" class="{{ request()->is('dokumen-dan-legal/dokumen-perusahaan') ? 'on' : '' }}">Dokumen Perusahaan</a></li>
            <li><a href="{{ url('dokumen-dan-legal/perizinan') }}" class="{{ request()->is('dokumen-dan-legal/perizinan') ? 'on' : '' }}">Perizinan</a></li>
            <li><a href="{{ url('dokumen-dan-legal/kontrak') }}" class="{{ request()->is('dokumen-dan-legal/kontrak') ? 'on' : '' }}">Kontrak</a></li>
            <li><a href="{{ url('dokumen-dan-legal/arsip-digital') }}" class="{{ request()->is('dokumen-dan-legal/arsip-digital') ? 'on' : '' }}">Arsip Digital</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('laporan-dan-analitik/*') ? ' open' : '' }}" data-g="Laporan &amp; Analitik">
        <button type="button">Laporan &amp; Analitik<i>{{ request()->is('laporan-dan-analitik/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('laporan-dan-analitik/laporan-produksi') }}" class="{{ request()->is('laporan-dan-analitik/laporan-produksi') ? 'on' : '' }}">Laporan Produksi</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-biaya') }}" class="{{ request()->is('laporan-dan-analitik/laporan-biaya') ? 'on' : '' }}">Laporan Biaya</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-stok') }}" class="{{ request()->is('laporan-dan-analitik/laporan-stok') ? 'on' : '' }}">Laporan Stok</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-kualitas') }}" class="{{ request()->is('laporan-dan-analitik/laporan-kualitas') ? 'on' : '' }}">Laporan Kualitas</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-custom') }}" class="{{ request()->is('laporan-dan-analitik/laporan-custom') ? 'on' : '' }}">Laporan Custom</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('pengaturan/*') ? ' open' : '' }}" data-g="Pengaturan">
        <button type="button">Pengaturan<i>{{ request()->is('pengaturan/*') ? '−' : '+' }}</i></button>
        <ul>
            <li><a href="{{ url('pengaturan/perusahaan-dan-cabang') }}" class="{{ request()->is('pengaturan/perusahaan-dan-cabang') ? 'on' : '' }}">Perusahaan &amp; Cabang</a></li>
            <li><a href="{{ url('pengaturan/pengguna-dan-hak-akses') }}" class="{{ request()->is('pengaturan/pengguna-dan-hak-akses') ? 'on' : '' }}">Pengguna &amp; Hak Akses</a></li>
            <li><a href="{{ url('pengaturan/master-data') }}" class="{{ request()->is('pengaturan/master-data') ? 'on' : '' }}">Master Data</a></li>
            <li><a href="{{ url('pengaturan/satuan-ukur') }}" class="{{ request()->is('pengaturan/satuan-ukur') ? 'on' : '' }}">Satuan Ukur</a></li>
            <li><a href="{{ url('pengaturan/penomoran-dokumen') }}" class="{{ request()->is('pengaturan/penomoran-dokumen') ? 'on' : '' }}">Penomoran Dokumen</a></li>
            <li><a href="{{ url('pengaturan/alur-persetujuan') }}" class="{{ request()->is('pengaturan/alur-persetujuan') ? 'on' : '' }}">Alur Persetujuan</a></li>
            <li><a href="{{ url('pengaturan/integrasi-dan-api') }}" class="{{ request()->is('pengaturan/integrasi-dan-api') ? 'on' : '' }}">Integrasi &amp; API</a></li>
            <li><a href="{{ url('pengaturan/backup') }}" class="{{ request()->is('pengaturan/backup') ? 'on' : '' }}">Backup</a></li>
        </ul>
    </div>
</nav>
