<nav id="nav">
    @php
        $navPath = ltrim((string) parse_url(\LaravelLocalization::getNonLocalizedURL(request()->path()), PHP_URL_PATH), '/');
        $isSuper = auth()->user()?->role === 'superadmin';
    @endphp
    <div class="grp{{ Str::is('dashboard/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Dashboard') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">dashboard</span>{{ __('Dashboard') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('dashboard/ringkasan-eksekutif') }}" class="{{ Str::is('dashboard/ringkasan-eksekutif', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">space_dashboard</span>{{ __('Ringkasan Eksekutif') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('dashboard/dashboard-produksi') }}" class="{{ Str::is('dashboard/dashboard-produksi', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">monitoring</span>{{ __('Dashboard Produksi') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('dashboard/dashboard-penjualan') }}" class="{{ Str::is('dashboard/dashboard-penjualan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">trending_up</span>{{ __('Dashboard Penjualan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('dashboard/dashboard-keuangan') }}" class="{{ Str::is('dashboard/dashboard-keuangan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">savings</span>{{ __('Dashboard Keuangan') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('penjualan-dan-crm/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Penjualan & CRM') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">trending_up</span>{{ __('Penjualan & CRM') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/lead-dan-peluang') }}" class="{{ Str::is('penjualan-dan-crm/lead-dan-peluang', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">lightbulb</span>{{ __('Lead & Peluang') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/pelanggan-dealer') }}" class="{{ Str::is('penjualan-dan-crm/pelanggan-dealer', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">contacts</span>{{ __('Pelanggan / Dealer') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/penawaran-quotation') }}" class="{{ Str::is('penjualan-dan-crm/penawaran-quotation', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">request_quote</span>{{ __('Penawaran (Quotation)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/sales-order') }}" class="{{ Str::is('penjualan-dan-crm/sales-order', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">receipt_long</span>{{ __('Sales Order') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/kontrak-unit') }}" class="{{ Str::is('penjualan-dan-crm/kontrak-unit', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">gavel</span>{{ __('Kontrak Unit') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/price-list') }}" class="{{ Str::is('penjualan-dan-crm/price-list', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">sell</span>{{ __('Price List') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/komisi-sales') }}" class="{{ Str::is('penjualan-dan-crm/komisi-sales', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">percent</span>{{ __('Komisi Sales') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('penjualan-dan-crm/laporan-penjualan') }}" class="{{ Str::is('penjualan-dan-crm/laporan-penjualan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">query_stats</span>{{ __('Laporan Penjualan') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('engineering-dan-desain/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Engineering & Desain') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">architecture</span>{{ __('Engineering & Desain') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/spesifikasi-car-carrier') }}" class="{{ Str::is('engineering-dan-desain/spesifikasi-car-carrier', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">description</span>{{ __('Spesifikasi Car Carrier') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/gambar-teknik') }}" class="{{ Str::is('engineering-dan-desain/gambar-teknik', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">draw</span>{{ __('Gambar Teknik') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/bill-of-materials-bom') }}" class="{{ Str::is('engineering-dan-desain/bill-of-materials-bom', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">list_alt</span>{{ __('Bill of Materials (BOM)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/engineering-change-ecn') }}" class="{{ Str::is('engineering-dan-desain/engineering-change-ecn', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">autorenew</span>{{ __('Engineering Change (ECN)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/perhitungan-beban-dan-kekuatan') }}" class="{{ Str::is('engineering-dan-desain/perhitungan-beban-dan-kekuatan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">calculate</span>{{ __('Perhitungan Beban & Kekuatan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/dokumen-rancang-bangun') }}" class="{{ Str::is('engineering-dan-desain/dokumen-rancang-bangun', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">article</span>{{ __('Dokumen Rancang Bangun') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('engineering-dan-desain/library-komponen') }}" class="{{ Str::is('engineering-dan-desain/library-komponen', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">widgets</span>{{ __('Library Komponen') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('unit-dan-chassis/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Unit & Chassis') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">directions_car</span>{{ __('Unit & Chassis') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/penerimaan-chassis') }}" class="{{ Str::is('unit-dan-chassis/penerimaan-chassis', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">inbox</span>{{ __('Penerimaan Chassis') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/registrasi-unit-vin') }}" class="{{ Str::is('unit-dan-chassis/registrasi-unit-vin', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">app_registration</span>{{ __('Registrasi Unit (VIN)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/job-card-unit') }}" class="{{ Str::is('unit-dan-chassis/job-card-unit', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">work</span>{{ __('Job Card Unit') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/status-pengerjaan') }}" class="{{ Str::is('unit-dan-chassis/status-pengerjaan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">checklist</span>{{ __('Status Pengerjaan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/serah-terima-unit') }}" class="{{ Str::is('unit-dan-chassis/serah-terima-unit', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">assignment_turned_in</span>{{ __('Serah Terima Unit') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/surat-uji-tipe-srut') }}" class="{{ Str::is('unit-dan-chassis/surat-uji-tipe-srut', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">verified_user</span>{{ __('Surat Uji Tipe / SRUT') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/kir-dan-stnk') }}" class="{{ Str::is('unit-dan-chassis/kir-dan-stnk', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">policy</span>{{ __('KIR & STNK') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('unit-dan-chassis/garansi-unit') }}" class="{{ Str::is('unit-dan-chassis/garansi-unit', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">shield</span>{{ __('Garansi Unit') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('perencanaan-produksi/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Perencanaan Produksi') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">calendar_month</span>{{ __('Perencanaan Produksi') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('perencanaan-produksi/master-production-schedule') }}" class="{{ Str::is('perencanaan-produksi/master-production-schedule', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">event</span>{{ __('Master Production Schedule') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('perencanaan-produksi/perencanaan-kapasitas') }}" class="{{ Str::is('perencanaan-produksi/perencanaan-kapasitas', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">donut_small</span>{{ __('Perencanaan Kapasitas') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('perencanaan-produksi/kebutuhan-material-mrp') }}" class="{{ Str::is('perencanaan-produksi/kebutuhan-material-mrp', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">inventory</span>{{ __('Kebutuhan Material (MRP)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('perencanaan-produksi/jadwal-produksi') }}" class="{{ Str::is('perencanaan-produksi/jadwal-produksi', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">event_note</span>{{ __('Jadwal Produksi') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('perencanaan-produksi/backlog-order') }}" class="{{ Str::is('perencanaan-produksi/backlog-order', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">pending</span>{{ __('Backlog Order') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('manufaktur/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Manufaktur') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">factory</span>{{ __('Manufaktur') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/manufacturing-order') }}" class="{{ Str::is('manufaktur/manufacturing-order', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">factory</span>{{ __('Manufacturing Order') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/work-order') }}" class="{{ Str::is('manufaktur/work-order', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">construction</span>{{ __('Work Order') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/work-center') }}" class="{{ Str::is('manufaktur/work-center', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">precision_manufacturing</span>{{ __('Work Center') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/routing-proses') }}" class="{{ Str::is('manufaktur/routing-proses', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">route</span>{{ __('Routing / Proses') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/potong-dan-bending-plat') }}" class="{{ Str::is('manufaktur/potong-dan-bending-plat', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">content_cut</span>{{ __('Potong & Bending Plat') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/pengelasan') }}" class="{{ Str::is('manufaktur/pengelasan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">whatshot</span>{{ __('Pengelasan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/perakitan-deck-dan-ramp') }}" class="{{ Str::is('manufaktur/perakitan-deck-dan-ramp', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">handyman</span>{{ __('Perakitan Deck & Ramp') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/sistem-hidrolik') }}" class="{{ Str::is('manufaktur/sistem-hidrolik', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">water_drop</span>{{ __('Sistem Hidrolik') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/pengecatan') }}" class="{{ Str::is('manufaktur/pengecatan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">format_paint</span>{{ __('Pengecatan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/finishing-dan-aksesoris') }}" class="{{ Str::is('manufaktur/finishing-dan-aksesoris', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">style</span>{{ __('Finishing & Aksesoris') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/subkontrak') }}" class="{{ Str::is('manufaktur/subkontrak', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">groups</span>{{ __('Subkontrak') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('manufaktur/scrap-dan-rework') }}" class="{{ Str::is('manufaktur/scrap-dan-rework', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">delete</span>{{ __('Scrap & Rework') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('quality-control/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Quality Control') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">fact_check</span>{{ __('Quality Control') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/inspeksi-material-masuk') }}" class="{{ Str::is('quality-control/inspeksi-material-masuk', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">search</span>{{ __('Inspeksi Material Masuk') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/inspeksi-proses-ipqc') }}" class="{{ Str::is('quality-control/inspeksi-proses-ipqc', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">rule</span>{{ __('Inspeksi Proses (IPQC)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/inspeksi-las-wps-ndt') }}" class="{{ Str::is('quality-control/inspeksi-las-wps-ndt', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">visibility</span>{{ __('Inspeksi Las (WPS/NDT)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/uji-hidrolik-dan-beban') }}" class="{{ Str::is('quality-control/uji-hidrolik-dan-beban', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">fitness_center</span>{{ __('Uji Hidrolik & Beban') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/final-inspection') }}" class="{{ Str::is('quality-control/final-inspection', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">task_alt</span>{{ __('Final Inspection') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/non-conformance-ncr') }}" class="{{ Str::is('quality-control/non-conformance-ncr', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">warning</span>{{ __('Non-Conformance (NCR)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/tindakan-korektif-capa') }}" class="{{ Str::is('quality-control/tindakan-korektif-capa', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">check_circle</span>{{ __('Tindakan Korektif (CAPA)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('quality-control/sertifikat-dan-kalibrasi') }}" class="{{ Str::is('quality-control/sertifikat-dan-kalibrasi', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">workspace_premium</span>{{ __('Sertifikat & Kalibrasi') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('pembelian/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Pembelian') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">shopping_cart</span>{{ __('Pembelian') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/permintaan-pembelian-pr') }}" class="{{ Str::is('pembelian/permintaan-pembelian-pr', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">add_shopping_cart</span>{{ __('Permintaan Pembelian (PR)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/rfq') }}" class="{{ Str::is('pembelian/rfq', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">mail</span>{{ __('RFQ') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/purchase-order') }}" class="{{ Str::is('pembelian/purchase-order', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">shopping_bag</span>{{ __('Purchase Order') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/vendor-supplier') }}" class="{{ Str::is('pembelian/vendor-supplier', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">store</span>{{ __('Vendor / Supplier') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/evaluasi-vendor') }}" class="{{ Str::is('pembelian/evaluasi-vendor', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">star_rate</span>{{ __('Evaluasi Vendor') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/kontrak-subkon') }}" class="{{ Str::is('pembelian/kontrak-subkon', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">handshake</span>{{ __('Kontrak Subkon') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pembelian/laporan-pembelian') }}" class="{{ Str::is('pembelian/laporan-pembelian', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">receipt</span>{{ __('Laporan Pembelian') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('inventori-dan-gudang/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Inventori & Gudang') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">inventory_2</span>{{ __('Inventori & Gudang') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/stok-barang') }}" class="{{ Str::is('inventori-dan-gudang/stok-barang', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">category</span>{{ __('Stok Barang') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/penerimaan-barang') }}" class="{{ Str::is('inventori-dan-gudang/penerimaan-barang', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">move_to_inbox</span>{{ __('Penerimaan Barang') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/pengeluaran-barang') }}" class="{{ Str::is('inventori-dan-gudang/pengeluaran-barang', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">remove_shopping_cart</span>{{ __('Pengeluaran Barang') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/transfer-antar-gudang') }}" class="{{ Str::is('inventori-dan-gudang/transfer-antar-gudang', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">swap_horiz</span>{{ __('Transfer Antar Gudang') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/lot-serial-number') }}" class="{{ Str::is('inventori-dan-gudang/lot-serial-number', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">tag</span>{{ __('Lot / Serial Number') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/stock-opname') }}" class="{{ Str::is('inventori-dan-gudang/stock-opname', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">summarize</span>{{ __('Stock Opname') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/lokasi-dan-rak') }}" class="{{ Str::is('inventori-dan-gudang/lokasi-dan-rak', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">location_on</span>{{ __('Lokasi & Rak') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/landed-cost') }}" class="{{ Str::is('inventori-dan-gudang/landed-cost', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">payments</span>{{ __('Landed Cost') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('inventori-dan-gudang/valuasi-persediaan') }}" class="{{ Str::is('inventori-dan-gudang/valuasi-persediaan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">price_change</span>{{ __('Valuasi Persediaan') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('maintenance/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Maintenance') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">build</span>{{ __('Maintenance') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('maintenance/daftar-mesin-dan-alat') }}" class="{{ Str::is('maintenance/daftar-mesin-dan-alat', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">format_list_bulleted</span>{{ __('Daftar Mesin & Alat') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('maintenance/preventive-maintenance') }}" class="{{ Str::is('maintenance/preventive-maintenance', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">update</span>{{ __('Preventive Maintenance') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('maintenance/corrective-maintenance') }}" class="{{ Str::is('maintenance/corrective-maintenance', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">build</span>{{ __('Corrective Maintenance') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('maintenance/permintaan-perbaikan') }}" class="{{ Str::is('maintenance/permintaan-perbaikan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">report</span>{{ __('Permintaan Perbaikan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('maintenance/sparepart') }}" class="{{ Str::is('maintenance/sparepart', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">hardware</span>{{ __('Sparepart') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('maintenance/kalibrasi-alat') }}" class="{{ Str::is('maintenance/kalibrasi-alat', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">adjust</span>{{ __('Kalibrasi Alat') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('logistik-dan-pengiriman/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Logistik & Pengiriman') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">local_shipping</span>{{ __('Logistik & Pengiriman') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('logistik-dan-pengiriman/surat-jalan') }}" class="{{ Str::is('logistik-dan-pengiriman/surat-jalan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">send</span>{{ __('Surat Jalan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('logistik-dan-pengiriman/jadwal-pengiriman') }}" class="{{ Str::is('logistik-dan-pengiriman/jadwal-pengiriman', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">schedule</span>{{ __('Jadwal Pengiriman') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('logistik-dan-pengiriman/armada-dan-driver') }}" class="{{ Str::is('logistik-dan-pengiriman/armada-dan-driver', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">local_taxi</span>{{ __('Armada & Driver') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('logistik-dan-pengiriman/ekspedisi') }}" class="{{ Str::is('logistik-dan-pengiriman/ekspedisi', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">airport_shuttle</span>{{ __('Ekspedisi') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('logistik-dan-pengiriman/pengantaran-unit') }}" class="{{ Str::is('logistik-dan-pengiriman/pengantaran-unit', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">done_all</span>{{ __('Pengantaran Unit') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('akuntansi-dan-keuangan/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Akuntansi & Keuangan') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">account_balance</span>{{ __('Akuntansi & Keuangan') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/jurnal-umum') }}" class="{{ Str::is('akuntansi-dan-keuangan/jurnal-umum', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">edit_note</span>{{ __('Jurnal Umum') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/buku-besar') }}" class="{{ Str::is('akuntansi-dan-keuangan/buku-besar', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">menu_book</span>{{ __('Buku Besar') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/hutang-ap') }}" class="{{ Str::is('akuntansi-dan-keuangan/hutang-ap', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">credit_card</span>{{ __('Hutang (AP)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/piutang-ar') }}" class="{{ Str::is('akuntansi-dan-keuangan/piutang-ar', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">attach_money</span>{{ __('Piutang (AR)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/kas-dan-bank') }}" class="{{ Str::is('akuntansi-dan-keuangan/kas-dan-bank', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">money</span>{{ __('Kas & Bank') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/faktur-pajak-e-faktur') }}" class="{{ Str::is('akuntansi-dan-keuangan/faktur-pajak-e-faktur', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">receipt_long</span>{{ __('Faktur Pajak / e-Faktur') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/costing-produksi-hpp') }}" class="{{ Str::is('akuntansi-dan-keuangan/costing-produksi-hpp', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">functions</span>{{ __('Costing Produksi / HPP') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/anggaran-budget') }}" class="{{ Str::is('akuntansi-dan-keuangan/anggaran-budget', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">account_balance_wallet</span>{{ __('Anggaran (Budget)') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('akuntansi-dan-keuangan/laporan-keuangan') }}" class="{{ Str::is('akuntansi-dan-keuangan/laporan-keuangan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">leaderboard</span>{{ __('Laporan Keuangan') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('aset-tetap/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Aset Tetap') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">apartment</span>{{ __('Aset Tetap') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('aset-tetap/daftar-aset') }}" class="{{ Str::is('aset-tetap/daftar-aset', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">domain</span>{{ __('Daftar Aset') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('aset-tetap/penyusutan') }}" class="{{ Str::is('aset-tetap/penyusutan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">trending_down</span>{{ __('Penyusutan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('aset-tetap/mutasi-dan-disposal') }}" class="{{ Str::is('aset-tetap/mutasi-dan-disposal', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">swap_vert</span>{{ __('Mutasi & Disposal') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('proyek/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Proyek') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">assignment</span>{{ __('Proyek') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('proyek/daftar-proyek') }}" class="{{ Str::is('proyek/daftar-proyek', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">folder</span>{{ __('Daftar Proyek') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('proyek/tugas-dan-timeline') }}" class="{{ Str::is('proyek/tugas-dan-timeline', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">timeline</span>{{ __('Tugas & Timeline') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('proyek/timesheet') }}" class="{{ Str::is('proyek/timesheet', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">timer</span>{{ __('Timesheet') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('proyek/biaya-proyek') }}" class="{{ Str::is('proyek/biaya-proyek', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">paid</span>{{ __('Biaya Proyek') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('sdm-dan-payroll/*', $navPath) ? ' open' : '' }}" data-g="{{ __('SDM & Payroll') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">group</span>{{ __('SDM & Payroll') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/karyawan') }}" class="{{ Str::is('sdm-dan-payroll/karyawan*', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">person</span>{{ __('Karyawan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/absensi-dan-shift') }}" class="{{ Str::is('sdm-dan-payroll/absensi-dan-shift', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">event_available</span>{{ __('Absensi & Shift') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/lembur') }}" class="{{ Str::is('sdm-dan-payroll/lembur', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">more_time</span>{{ __('Lembur') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/cuti-dan-izin') }}" class="{{ Str::is('sdm-dan-payroll/cuti-dan-izin', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">beach_access</span>{{ __('Cuti & Izin') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/payroll') }}" class="{{ Str::is('sdm-dan-payroll/payroll', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">payments</span>{{ __('Payroll') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/bpjs-dan-pajak-pph21') }}" class="{{ Str::is('sdm-dan-payroll/bpjs-dan-pajak-pph21', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">balance</span>{{ __('BPJS & Pajak PPh21') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/rekrutmen') }}" class="{{ Str::is('sdm-dan-payroll/rekrutmen', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">person_add</span>{{ __('Rekrutmen') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/pelatihan-dan-sertifikasi-welder') }}" class="{{ Str::is('sdm-dan-payroll/pelatihan-dan-sertifikasi-welder', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">school</span>{{ __('Pelatihan & Sertifikasi Welder') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('sdm-dan-payroll/penilaian-kinerja') }}" class="{{ Str::is('sdm-dan-payroll/penilaian-kinerja', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">reviews</span>{{ __('Penilaian Kinerja') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('k3-dan-lingkungan/*', $navPath) ? ' open' : '' }}" data-g="{{ __('K3 & Lingkungan') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">health_and_safety</span>{{ __('K3 & Lingkungan') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('k3-dan-lingkungan/insiden-dan-kecelakaan-kerja') }}" class="{{ Str::is('k3-dan-lingkungan/insiden-dan-kecelakaan-kerja', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">emergency</span>{{ __('Insiden & Kecelakaan Kerja') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('k3-dan-lingkungan/inspeksi-k3') }}" class="{{ Str::is('k3-dan-lingkungan/inspeksi-k3', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">safety_check</span>{{ __('Inspeksi K3') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('k3-dan-lingkungan/apd') }}" class="{{ Str::is('k3-dan-lingkungan/apd', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">masks</span>{{ __('APD') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('k3-dan-lingkungan/limbah-b3') }}" class="{{ Str::is('k3-dan-lingkungan/limbah-b3', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">recycling</span>{{ __('Limbah B3') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('k3-dan-lingkungan/izin-kerja-panas') }}" class="{{ Str::is('k3-dan-lingkungan/izin-kerja-panas', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">local_fire_department</span>{{ __('Izin Kerja Panas') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('after-sales/*', $navPath) ? ' open' : '' }}" data-g="{{ __('After Sales') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">support_agent</span>{{ __('After Sales') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('after-sales/klaim-garansi') }}" class="{{ Str::is('after-sales/klaim-garansi', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">verified</span>{{ __('Klaim Garansi') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('after-sales/servis-dan-perbaikan') }}" class="{{ Str::is('after-sales/servis-dan-perbaikan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">home_repair_service</span>{{ __('Servis & Perbaikan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('after-sales/tiket-keluhan') }}" class="{{ Str::is('after-sales/tiket-keluhan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">feedback</span>{{ __('Tiket Keluhan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('after-sales/suku-cadang-pelanggan') }}" class="{{ Str::is('after-sales/suku-cadang-pelanggan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">extension</span>{{ __('Suku Cadang Pelanggan') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('dokumen-dan-legal/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Dokumen & Legal') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">description</span>{{ __('Dokumen & Legal') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('dokumen-dan-legal/dokumen-perusahaan') }}" class="{{ Str::is('dokumen-dan-legal/dokumen-perusahaan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">corporate_fare</span>{{ __('Dokumen Perusahaan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('dokumen-dan-legal/perizinan') }}" class="{{ Str::is('dokumen-dan-legal/perizinan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">card_membership</span>{{ __('Perizinan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('dokumen-dan-legal/kontrak') }}" class="{{ Str::is('dokumen-dan-legal/kontrak', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">draft</span>{{ __('Kontrak') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('dokumen-dan-legal/arsip-digital') }}" class="{{ Str::is('dokumen-dan-legal/arsip-digital', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">archive</span>{{ __('Arsip Digital') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('laporan-dan-analitik/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Laporan & Analitik') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">bar_chart</span>{{ __('Laporan & Analitik') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('laporan-dan-analitik/laporan-produksi') }}" class="{{ Str::is('laporan-dan-analitik/laporan-produksi', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">analytics</span>{{ __('Laporan Produksi') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('laporan-dan-analitik/laporan-biaya') }}" class="{{ Str::is('laporan-dan-analitik/laporan-biaya', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">show_chart</span>{{ __('Laporan Biaya') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('laporan-dan-analitik/laporan-stok') }}" class="{{ Str::is('laporan-dan-analitik/laporan-stok', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">warehouse</span>{{ __('Laporan Stok') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('laporan-dan-analitik/laporan-kualitas') }}" class="{{ Str::is('laporan-dan-analitik/laporan-kualitas', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">grading</span>{{ __('Laporan Kualitas') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('laporan-dan-analitik/laporan-custom') }}" class="{{ Str::is('laporan-dan-analitik/laporan-custom', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">tune</span>{{ __('Laporan Custom') }}</a></li>
        </ul>
    </div>
    <div class="grp{{ Str::is('pengaturan/*', $navPath) ? ' open' : '' }}" data-g="{{ __('Pengaturan') }}">
        <button type="button"><span class="material-symbols-outlined grp-icon">settings</span>{{ __('Pengaturan') }}<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/umum') }}" class="{{ Str::is('pengaturan/umum', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">tune</span>{{ __('Umum') }}</a></li>
            @if ($isSuper)
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/perusahaan-dan-cabang') }}" class="{{ Str::is('pengaturan/perusahaan-dan-cabang', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">apartment</span>{{ __('Perusahaan & Cabang') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/pengguna-dan-hak-akses') }}" class="{{ Str::is('pengaturan/pengguna-dan-hak-akses', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">manage_accounts</span>{{ __('Pengguna & Hak Akses') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/master-data') }}" class="{{ Str::is('pengaturan/master-data', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">database</span>{{ __('Master Data') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/satuan-ukur') }}" class="{{ Str::is('pengaturan/satuan-ukur', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">straighten</span>{{ __('Satuan Ukur') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/penomoran-dokumen') }}" class="{{ Str::is('pengaturan/penomoran-dokumen', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">numbers</span>{{ __('Penomoran Dokumen') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/alur-persetujuan') }}" class="{{ Str::is('pengaturan/alur-persetujuan', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">account_tree</span>{{ __('Alur Persetujuan') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/integrasi-dan-api') }}" class="{{ Str::is('pengaturan/integrasi-dan-api', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">api</span>{{ __('Integrasi & API') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeURL('pengaturan/backup') }}" class="{{ Str::is('pengaturan/backup', $navPath) ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">backup</span>{{ __('Backup') }}</a></li>
            @endif
        </ul>
    </div>
</nav>
