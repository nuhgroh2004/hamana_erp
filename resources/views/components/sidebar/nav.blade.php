<nav id="nav">
    <div class="grp{{ request()->is('dashboard/*') ? ' open' : '' }}" data-g="Dashboard">
        <button type="button"><span class="material-symbols-outlined grp-icon">dashboard</span>Dashboard<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('dashboard/ringkasan-eksekutif') }}" class="{{ request()->is('dashboard/ringkasan-eksekutif') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">space_dashboard</span>Ringkasan Eksekutif</a></li>
            <li><a href="{{ url('dashboard/dashboard-produksi') }}" class="{{ request()->is('dashboard/dashboard-produksi') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">monitoring</span>Dashboard Produksi</a></li>
            <li><a href="{{ url('dashboard/dashboard-penjualan') }}" class="{{ request()->is('dashboard/dashboard-penjualan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">trending_up</span>Dashboard Penjualan</a></li>
            <li><a href="{{ url('dashboard/dashboard-keuangan') }}" class="{{ request()->is('dashboard/dashboard-keuangan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">savings</span>Dashboard Keuangan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('penjualan-dan-crm/*') ? ' open' : '' }}" data-g="Penjualan &amp; CRM">
        <button type="button"><span class="material-symbols-outlined grp-icon">trending_up</span>Penjualan &amp; CRM<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('penjualan-dan-crm/lead-dan-peluang') }}" class="{{ request()->is('penjualan-dan-crm/lead-dan-peluang') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">lightbulb</span>Lead &amp; Peluang</a></li>
            <li><a href="{{ url('penjualan-dan-crm/pelanggan-dealer') }}" class="{{ request()->is('penjualan-dan-crm/pelanggan-dealer') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">contacts</span>Pelanggan / Dealer</a></li>
            <li><a href="{{ url('penjualan-dan-crm/penawaran-quotation') }}" class="{{ request()->is('penjualan-dan-crm/penawaran-quotation') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">request_quote</span>Penawaran (Quotation)</a></li>
            <li><a href="{{ url('penjualan-dan-crm/sales-order') }}" class="{{ request()->is('penjualan-dan-crm/sales-order') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">receipt_long</span>Sales Order</a></li>
            <li><a href="{{ url('penjualan-dan-crm/kontrak-unit') }}" class="{{ request()->is('penjualan-dan-crm/kontrak-unit') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">gavel</span>Kontrak Unit</a></li>
            <li><a href="{{ url('penjualan-dan-crm/price-list') }}" class="{{ request()->is('penjualan-dan-crm/price-list') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">sell</span>Price List</a></li>
            <li><a href="{{ url('penjualan-dan-crm/komisi-sales') }}" class="{{ request()->is('penjualan-dan-crm/komisi-sales') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">percent</span>Komisi Sales</a></li>
            <li><a href="{{ url('penjualan-dan-crm/laporan-penjualan') }}" class="{{ request()->is('penjualan-dan-crm/laporan-penjualan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">query_stats</span>Laporan Penjualan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('engineering-dan-desain/*') ? ' open' : '' }}" data-g="Engineering &amp; Desain">
        <button type="button"><span class="material-symbols-outlined grp-icon">architecture</span>Engineering &amp; Desain<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('engineering-dan-desain/spesifikasi-car-carrier') }}" class="{{ request()->is('engineering-dan-desain/spesifikasi-car-carrier') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">description</span>Spesifikasi Car Carrier</a></li>
            <li><a href="{{ url('engineering-dan-desain/gambar-teknik') }}" class="{{ request()->is('engineering-dan-desain/gambar-teknik') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">draw</span>Gambar Teknik</a></li>
            <li><a href="{{ url('engineering-dan-desain/bill-of-materials-bom') }}" class="{{ request()->is('engineering-dan-desain/bill-of-materials-bom') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">list_alt</span>Bill of Materials (BOM)</a></li>
            <li><a href="{{ url('engineering-dan-desain/engineering-change-ecn') }}" class="{{ request()->is('engineering-dan-desain/engineering-change-ecn') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">autorenew</span>Engineering Change (ECN)</a></li>
            <li><a href="{{ url('engineering-dan-desain/perhitungan-beban-dan-kekuatan') }}" class="{{ request()->is('engineering-dan-desain/perhitungan-beban-dan-kekuatan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">calculate</span>Perhitungan Beban &amp; Kekuatan</a></li>
            <li><a href="{{ url('engineering-dan-desain/dokumen-rancang-bangun') }}" class="{{ request()->is('engineering-dan-desain/dokumen-rancang-bangun') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">article</span>Dokumen Rancang Bangun</a></li>
            <li><a href="{{ url('engineering-dan-desain/library-komponen') }}" class="{{ request()->is('engineering-dan-desain/library-komponen') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">widgets</span>Library Komponen</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('unit-dan-chassis/*') ? ' open' : '' }}" data-g="Unit &amp; Chassis">
        <button type="button"><span class="material-symbols-outlined grp-icon">directions_car</span>Unit &amp; Chassis<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('unit-dan-chassis/penerimaan-chassis') }}" class="{{ request()->is('unit-dan-chassis/penerimaan-chassis') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">inbox</span>Penerimaan Chassis</a></li>
            <li><a href="{{ url('unit-dan-chassis/registrasi-unit-vin') }}" class="{{ request()->is('unit-dan-chassis/registrasi-unit-vin') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">app_registration</span>Registrasi Unit (VIN)</a></li>
            <li><a href="{{ url('unit-dan-chassis/job-card-unit') }}" class="{{ request()->is('unit-dan-chassis/job-card-unit') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">work</span>Job Card Unit</a></li>
            <li><a href="{{ url('unit-dan-chassis/status-pengerjaan') }}" class="{{ request()->is('unit-dan-chassis/status-pengerjaan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">checklist</span>Status Pengerjaan</a></li>
            <li><a href="{{ url('unit-dan-chassis/serah-terima-unit') }}" class="{{ request()->is('unit-dan-chassis/serah-terima-unit') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">assignment_turned_in</span>Serah Terima Unit</a></li>
            <li><a href="{{ url('unit-dan-chassis/surat-uji-tipe-srut') }}" class="{{ request()->is('unit-dan-chassis/surat-uji-tipe-srut') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">verified_user</span>Surat Uji Tipe / SRUT</a></li>
            <li><a href="{{ url('unit-dan-chassis/kir-dan-stnk') }}" class="{{ request()->is('unit-dan-chassis/kir-dan-stnk') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">policy</span>KIR &amp; STNK</a></li>
            <li><a href="{{ url('unit-dan-chassis/garansi-unit') }}" class="{{ request()->is('unit-dan-chassis/garansi-unit') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">shield</span>Garansi Unit</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('perencanaan-produksi/*') ? ' open' : '' }}" data-g="Perencanaan Produksi">
        <button type="button"><span class="material-symbols-outlined grp-icon">calendar_month</span>Perencanaan Produksi<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('perencanaan-produksi/master-production-schedule') }}" class="{{ request()->is('perencanaan-produksi/master-production-schedule') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">event</span>Master Production Schedule</a></li>
            <li><a href="{{ url('perencanaan-produksi/perencanaan-kapasitas') }}" class="{{ request()->is('perencanaan-produksi/perencanaan-kapasitas') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">donut_small</span>Perencanaan Kapasitas</a></li>
            <li><a href="{{ url('perencanaan-produksi/kebutuhan-material-mrp') }}" class="{{ request()->is('perencanaan-produksi/kebutuhan-material-mrp') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">inventory</span>Kebutuhan Material (MRP)</a></li>
            <li><a href="{{ url('perencanaan-produksi/jadwal-produksi') }}" class="{{ request()->is('perencanaan-produksi/jadwal-produksi') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">event_note</span>Jadwal Produksi</a></li>
            <li><a href="{{ url('perencanaan-produksi/backlog-order') }}" class="{{ request()->is('perencanaan-produksi/backlog-order') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">pending</span>Backlog Order</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('manufaktur/*') ? ' open' : '' }}" data-g="Manufaktur">
        <button type="button"><span class="material-symbols-outlined grp-icon">factory</span>Manufaktur<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('manufaktur/manufacturing-order') }}" class="{{ request()->is('manufaktur/manufacturing-order') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">factory</span>Manufacturing Order</a></li>
            <li><a href="{{ url('manufaktur/work-order') }}" class="{{ request()->is('manufaktur/work-order') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">construction</span>Work Order</a></li>
            <li><a href="{{ url('manufaktur/work-center') }}" class="{{ request()->is('manufaktur/work-center') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">precision_manufacturing</span>Work Center</a></li>
            <li><a href="{{ url('manufaktur/routing-proses') }}" class="{{ request()->is('manufaktur/routing-proses') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">route</span>Routing / Proses</a></li>
            <li><a href="{{ url('manufaktur/potong-dan-bending-plat') }}" class="{{ request()->is('manufaktur/potong-dan-bending-plat') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">content_cut</span>Potong &amp; Bending Plat</a></li>
            <li><a href="{{ url('manufaktur/pengelasan') }}" class="{{ request()->is('manufaktur/pengelasan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">whatshot</span>Pengelasan</a></li>
            <li><a href="{{ url('manufaktur/perakitan-deck-dan-ramp') }}" class="{{ request()->is('manufaktur/perakitan-deck-dan-ramp') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">handyman</span>Perakitan Deck &amp; Ramp</a></li>
            <li><a href="{{ url('manufaktur/sistem-hidrolik') }}" class="{{ request()->is('manufaktur/sistem-hidrolik') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">water_drop</span>Sistem Hidrolik</a></li>
            <li><a href="{{ url('manufaktur/pengecatan') }}" class="{{ request()->is('manufaktur/pengecatan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">format_paint</span>Pengecatan</a></li>
            <li><a href="{{ url('manufaktur/finishing-dan-aksesoris') }}" class="{{ request()->is('manufaktur/finishing-dan-aksesoris') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">style</span>Finishing &amp; Aksesoris</a></li>
            <li><a href="{{ url('manufaktur/subkontrak') }}" class="{{ request()->is('manufaktur/subkontrak') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">groups</span>Subkontrak</a></li>
            <li><a href="{{ url('manufaktur/scrap-dan-rework') }}" class="{{ request()->is('manufaktur/scrap-dan-rework') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">delete</span>Scrap &amp; Rework</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('quality-control/*') ? ' open' : '' }}" data-g="Quality Control">
        <button type="button"><span class="material-symbols-outlined grp-icon">fact_check</span>Quality Control<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('quality-control/inspeksi-material-masuk') }}" class="{{ request()->is('quality-control/inspeksi-material-masuk') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">search</span>Inspeksi Material Masuk</a></li>
            <li><a href="{{ url('quality-control/inspeksi-proses-ipqc') }}" class="{{ request()->is('quality-control/inspeksi-proses-ipqc') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">rule</span>Inspeksi Proses (IPQC)</a></li>
            <li><a href="{{ url('quality-control/inspeksi-las-wps-ndt') }}" class="{{ request()->is('quality-control/inspeksi-las-wps-ndt') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">visibility</span>Inspeksi Las (WPS/NDT)</a></li>
            <li><a href="{{ url('quality-control/uji-hidrolik-dan-beban') }}" class="{{ request()->is('quality-control/uji-hidrolik-dan-beban') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">fitness_center</span>Uji Hidrolik &amp; Beban</a></li>
            <li><a href="{{ url('quality-control/final-inspection') }}" class="{{ request()->is('quality-control/final-inspection') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">task_alt</span>Final Inspection</a></li>
            <li><a href="{{ url('quality-control/non-conformance-ncr') }}" class="{{ request()->is('quality-control/non-conformance-ncr') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">warning</span>Non-Conformance (NCR)</a></li>
            <li><a href="{{ url('quality-control/tindakan-korektif-capa') }}" class="{{ request()->is('quality-control/tindakan-korektif-capa') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">check_circle</span>Tindakan Korektif (CAPA)</a></li>
            <li><a href="{{ url('quality-control/sertifikat-dan-kalibrasi') }}" class="{{ request()->is('quality-control/sertifikat-dan-kalibrasi') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">workspace_premium</span>Sertifikat &amp; Kalibrasi</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('pembelian/*') ? ' open' : '' }}" data-g="Pembelian">
        <button type="button"><span class="material-symbols-outlined grp-icon">shopping_cart</span>Pembelian<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('pembelian/permintaan-pembelian-pr') }}" class="{{ request()->is('pembelian/permintaan-pembelian-pr') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">add_shopping_cart</span>Permintaan Pembelian (PR)</a></li>
            <li><a href="{{ url('pembelian/rfq') }}" class="{{ request()->is('pembelian/rfq') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">mail</span>RFQ</a></li>
            <li><a href="{{ url('pembelian/purchase-order') }}" class="{{ request()->is('pembelian/purchase-order') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">shopping_bag</span>Purchase Order</a></li>
            <li><a href="{{ url('pembelian/vendor-supplier') }}" class="{{ request()->is('pembelian/vendor-supplier') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">store</span>Vendor / Supplier</a></li>
            <li><a href="{{ url('pembelian/evaluasi-vendor') }}" class="{{ request()->is('pembelian/evaluasi-vendor') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">star_rate</span>Evaluasi Vendor</a></li>
            <li><a href="{{ url('pembelian/kontrak-subkon') }}" class="{{ request()->is('pembelian/kontrak-subkon') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">handshake</span>Kontrak Subkon</a></li>
            <li><a href="{{ url('pembelian/laporan-pembelian') }}" class="{{ request()->is('pembelian/laporan-pembelian') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">receipt</span>Laporan Pembelian</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('inventori-dan-gudang/*') ? ' open' : '' }}" data-g="Inventori &amp; Gudang">
        <button type="button"><span class="material-symbols-outlined grp-icon">inventory_2</span>Inventori &amp; Gudang<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('inventori-dan-gudang/stok-barang') }}" class="{{ request()->is('inventori-dan-gudang/stok-barang') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">category</span>Stok Barang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/penerimaan-barang') }}" class="{{ request()->is('inventori-dan-gudang/penerimaan-barang') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">move_to_inbox</span>Penerimaan Barang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/pengeluaran-barang') }}" class="{{ request()->is('inventori-dan-gudang/pengeluaran-barang') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">remove_shopping_cart</span>Pengeluaran Barang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/transfer-antar-gudang') }}" class="{{ request()->is('inventori-dan-gudang/transfer-antar-gudang') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">swap_horiz</span>Transfer Antar Gudang</a></li>
            <li><a href="{{ url('inventori-dan-gudang/lot-serial-number') }}" class="{{ request()->is('inventori-dan-gudang/lot-serial-number') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">tag</span>Lot / Serial Number</a></li>
            <li><a href="{{ url('inventori-dan-gudang/stock-opname') }}" class="{{ request()->is('inventori-dan-gudang/stock-opname') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">summarize</span>Stock Opname</a></li>
            <li><a href="{{ url('inventori-dan-gudang/lokasi-dan-rak') }}" class="{{ request()->is('inventori-dan-gudang/lokasi-dan-rak') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">location_on</span>Lokasi &amp; Rak</a></li>
            <li><a href="{{ url('inventori-dan-gudang/landed-cost') }}" class="{{ request()->is('inventori-dan-gudang/landed-cost') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">payments</span>Landed Cost</a></li>
            <li><a href="{{ url('inventori-dan-gudang/valuasi-persediaan') }}" class="{{ request()->is('inventori-dan-gudang/valuasi-persediaan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">price_change</span>Valuasi Persediaan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('maintenance/*') ? ' open' : '' }}" data-g="Maintenance">
        <button type="button"><span class="material-symbols-outlined grp-icon">build</span>Maintenance<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('maintenance/daftar-mesin-dan-alat') }}" class="{{ request()->is('maintenance/daftar-mesin-dan-alat') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">format_list_bulleted</span>Daftar Mesin &amp; Alat</a></li>
            <li><a href="{{ url('maintenance/preventive-maintenance') }}" class="{{ request()->is('maintenance/preventive-maintenance') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">update</span>Preventive Maintenance</a></li>
            <li><a href="{{ url('maintenance/corrective-maintenance') }}" class="{{ request()->is('maintenance/corrective-maintenance') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">build</span>Corrective Maintenance</a></li>
            <li><a href="{{ url('maintenance/permintaan-perbaikan') }}" class="{{ request()->is('maintenance/permintaan-perbaikan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">report</span>Permintaan Perbaikan</a></li>
            <li><a href="{{ url('maintenance/sparepart') }}" class="{{ request()->is('maintenance/sparepart') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">hardware</span>Sparepart</a></li>
            <li><a href="{{ url('maintenance/kalibrasi-alat') }}" class="{{ request()->is('maintenance/kalibrasi-alat') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">adjust</span>Kalibrasi Alat</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('logistik-dan-pengiriman/*') ? ' open' : '' }}" data-g="Logistik &amp; Pengiriman">
        <button type="button"><span class="material-symbols-outlined grp-icon">local_shipping</span>Logistik &amp; Pengiriman<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('logistik-dan-pengiriman/surat-jalan') }}" class="{{ request()->is('logistik-dan-pengiriman/surat-jalan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">send</span>Surat Jalan</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/jadwal-pengiriman') }}" class="{{ request()->is('logistik-dan-pengiriman/jadwal-pengiriman') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">schedule</span>Jadwal Pengiriman</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/armada-dan-driver') }}" class="{{ request()->is('logistik-dan-pengiriman/armada-dan-driver') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">local_taxi</span>Armada &amp; Driver</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/ekspedisi') }}" class="{{ request()->is('logistik-dan-pengiriman/ekspedisi') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">airport_shuttle</span>Ekspedisi</a></li>
            <li><a href="{{ url('logistik-dan-pengiriman/pengantaran-unit') }}" class="{{ request()->is('logistik-dan-pengiriman/pengantaran-unit') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">done_all</span>Pengantaran Unit</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('akuntansi-dan-keuangan/*') ? ' open' : '' }}" data-g="Akuntansi &amp; Keuangan">
        <button type="button"><span class="material-symbols-outlined grp-icon">account_balance</span>Akuntansi &amp; Keuangan<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('akuntansi-dan-keuangan/jurnal-umum') }}" class="{{ request()->is('akuntansi-dan-keuangan/jurnal-umum') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">edit_note</span>Jurnal Umum</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/buku-besar') }}" class="{{ request()->is('akuntansi-dan-keuangan/buku-besar') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">menu_book</span>Buku Besar</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/hutang-ap') }}" class="{{ request()->is('akuntansi-dan-keuangan/hutang-ap') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">credit_card</span>Hutang (AP)</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/piutang-ar') }}" class="{{ request()->is('akuntansi-dan-keuangan/piutang-ar') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">attach_money</span>Piutang (AR)</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/kas-dan-bank') }}" class="{{ request()->is('akuntansi-dan-keuangan/kas-dan-bank') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">money</span>Kas &amp; Bank</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/faktur-pajak-e-faktur') }}" class="{{ request()->is('akuntansi-dan-keuangan/faktur-pajak-e-faktur') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">receipt_long</span>Faktur Pajak / e-Faktur</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/costing-produksi-hpp') }}" class="{{ request()->is('akuntansi-dan-keuangan/costing-produksi-hpp') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">functions</span>Costing Produksi / HPP</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/anggaran-budget') }}" class="{{ request()->is('akuntansi-dan-keuangan/anggaran-budget') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">account_balance_wallet</span>Anggaran (Budget)</a></li>
            <li><a href="{{ url('akuntansi-dan-keuangan/laporan-keuangan') }}" class="{{ request()->is('akuntansi-dan-keuangan/laporan-keuangan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">leaderboard</span>Laporan Keuangan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('aset-tetap/*') ? ' open' : '' }}" data-g="Aset Tetap">
        <button type="button"><span class="material-symbols-outlined grp-icon">apartment</span>Aset Tetap<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('aset-tetap/daftar-aset') }}" class="{{ request()->is('aset-tetap/daftar-aset') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">domain</span>Daftar Aset</a></li>
            <li><a href="{{ url('aset-tetap/penyusutan') }}" class="{{ request()->is('aset-tetap/penyusutan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">trending_down</span>Penyusutan</a></li>
            <li><a href="{{ url('aset-tetap/mutasi-dan-disposal') }}" class="{{ request()->is('aset-tetap/mutasi-dan-disposal') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">swap_vert</span>Mutasi &amp; Disposal</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('proyek/*') ? ' open' : '' }}" data-g="Proyek">
        <button type="button"><span class="material-symbols-outlined grp-icon">assignment</span>Proyek<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('proyek/daftar-proyek') }}" class="{{ request()->is('proyek/daftar-proyek') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">folder</span>Daftar Proyek</a></li>
            <li><a href="{{ url('proyek/tugas-dan-timeline') }}" class="{{ request()->is('proyek/tugas-dan-timeline') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">timeline</span>Tugas &amp; Timeline</a></li>
            <li><a href="{{ url('proyek/timesheet') }}" class="{{ request()->is('proyek/timesheet') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">timer</span>Timesheet</a></li>
            <li><a href="{{ url('proyek/biaya-proyek') }}" class="{{ request()->is('proyek/biaya-proyek') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">paid</span>Biaya Proyek</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('sdm-dan-payroll/*') ? ' open' : '' }}" data-g="SDM &amp; Payroll">
        <button type="button"><span class="material-symbols-outlined grp-icon">group</span>SDM &amp; Payroll<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('sdm-dan-payroll/karyawan') }}" class="{{ request()->is('sdm-dan-payroll/karyawan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">person</span>Karyawan</a></li>
            <li><a href="{{ url('sdm-dan-payroll/absensi-dan-shift') }}" class="{{ request()->is('sdm-dan-payroll/absensi-dan-shift') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">event_available</span>Absensi &amp; Shift</a></li>
            <li><a href="{{ url('sdm-dan-payroll/lembur') }}" class="{{ request()->is('sdm-dan-payroll/lembur') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">more_time</span>Lembur</a></li>
            <li><a href="{{ url('sdm-dan-payroll/cuti-dan-izin') }}" class="{{ request()->is('sdm-dan-payroll/cuti-dan-izin') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">beach_access</span>Cuti &amp; Izin</a></li>
            <li><a href="{{ url('sdm-dan-payroll/payroll') }}" class="{{ request()->is('sdm-dan-payroll/payroll') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">payments</span>Payroll</a></li>
            <li><a href="{{ url('sdm-dan-payroll/bpjs-dan-pajak-pph21') }}" class="{{ request()->is('sdm-dan-payroll/bpjs-dan-pajak-pph21') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">balance</span>BPJS &amp; Pajak PPh21</a></li>
            <li><a href="{{ url('sdm-dan-payroll/rekrutmen') }}" class="{{ request()->is('sdm-dan-payroll/rekrutmen') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">person_add</span>Rekrutmen</a></li>
            <li><a href="{{ url('sdm-dan-payroll/pelatihan-dan-sertifikasi-welder') }}" class="{{ request()->is('sdm-dan-payroll/pelatihan-dan-sertifikasi-welder') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">school</span>Pelatihan &amp; Sertifikasi Welder</a></li>
            <li><a href="{{ url('sdm-dan-payroll/penilaian-kinerja') }}" class="{{ request()->is('sdm-dan-payroll/penilaian-kinerja') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">reviews</span>Penilaian Kinerja</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('k3-dan-lingkungan/*') ? ' open' : '' }}" data-g="K3 &amp; Lingkungan">
        <button type="button"><span class="material-symbols-outlined grp-icon">health_and_safety</span>K3 &amp; Lingkungan<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('k3-dan-lingkungan/insiden-dan-kecelakaan-kerja') }}" class="{{ request()->is('k3-dan-lingkungan/insiden-dan-kecelakaan-kerja') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">emergency</span>Insiden &amp; Kecelakaan Kerja</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/inspeksi-k3') }}" class="{{ request()->is('k3-dan-lingkungan/inspeksi-k3') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">safety_check</span>Inspeksi K3</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/apd') }}" class="{{ request()->is('k3-dan-lingkungan/apd') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">masks</span>APD</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/limbah-b3') }}" class="{{ request()->is('k3-dan-lingkungan/limbah-b3') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">recycling</span>Limbah B3</a></li>
            <li><a href="{{ url('k3-dan-lingkungan/izin-kerja-panas') }}" class="{{ request()->is('k3-dan-lingkungan/izin-kerja-panas') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">local_fire_department</span>Izin Kerja Panas</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('after-sales/*') ? ' open' : '' }}" data-g="After Sales">
        <button type="button"><span class="material-symbols-outlined grp-icon">support_agent</span>After Sales<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('after-sales/klaim-garansi') }}" class="{{ request()->is('after-sales/klaim-garansi') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">verified</span>Klaim Garansi</a></li>
            <li><a href="{{ url('after-sales/servis-dan-perbaikan') }}" class="{{ request()->is('after-sales/servis-dan-perbaikan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">home_repair_service</span>Servis &amp; Perbaikan</a></li>
            <li><a href="{{ url('after-sales/tiket-keluhan') }}" class="{{ request()->is('after-sales/tiket-keluhan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">feedback</span>Tiket Keluhan</a></li>
            <li><a href="{{ url('after-sales/suku-cadang-pelanggan') }}" class="{{ request()->is('after-sales/suku-cadang-pelanggan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">extension</span>Suku Cadang Pelanggan</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('dokumen-dan-legal/*') ? ' open' : '' }}" data-g="Dokumen &amp; Legal">
        <button type="button"><span class="material-symbols-outlined grp-icon">description</span>Dokumen &amp; Legal<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('dokumen-dan-legal/dokumen-perusahaan') }}" class="{{ request()->is('dokumen-dan-legal/dokumen-perusahaan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">corporate_fare</span>Dokumen Perusahaan</a></li>
            <li><a href="{{ url('dokumen-dan-legal/perizinan') }}" class="{{ request()->is('dokumen-dan-legal/perizinan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">card_membership</span>Perizinan</a></li>
            <li><a href="{{ url('dokumen-dan-legal/kontrak') }}" class="{{ request()->is('dokumen-dan-legal/kontrak') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">draft</span>Kontrak</a></li>
            <li><a href="{{ url('dokumen-dan-legal/arsip-digital') }}" class="{{ request()->is('dokumen-dan-legal/arsip-digital') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">archive</span>Arsip Digital</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('laporan-dan-analitik/*') ? ' open' : '' }}" data-g="Laporan &amp; Analitik">
        <button type="button"><span class="material-symbols-outlined grp-icon">bar_chart</span>Laporan &amp; Analitik<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('laporan-dan-analitik/laporan-produksi') }}" class="{{ request()->is('laporan-dan-analitik/laporan-produksi') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">analytics</span>Laporan Produksi</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-biaya') }}" class="{{ request()->is('laporan-dan-analitik/laporan-biaya') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">show_chart</span>Laporan Biaya</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-stok') }}" class="{{ request()->is('laporan-dan-analitik/laporan-stok') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">warehouse</span>Laporan Stok</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-kualitas') }}" class="{{ request()->is('laporan-dan-analitik/laporan-kualitas') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">grading</span>Laporan Kualitas</a></li>
            <li><a href="{{ url('laporan-dan-analitik/laporan-custom') }}" class="{{ request()->is('laporan-dan-analitik/laporan-custom') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">tune</span>Laporan Custom</a></li>
        </ul>
    </div>
    <div class="grp{{ request()->is('pengaturan/*') ? ' open' : '' }}" data-g="Pengaturan">
        <button type="button"><span class="material-symbols-outlined grp-icon">settings</span>Pengaturan<span class="material-symbols-outlined grp-arrow">expand_more</span></button>
        <ul>
            <li><a href="{{ url('pengaturan/perusahaan-dan-cabang') }}" class="{{ request()->is('pengaturan/perusahaan-dan-cabang') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">apartment</span>Perusahaan &amp; Cabang</a></li>
            <li><a href="{{ url('pengaturan/pengguna-dan-hak-akses') }}" class="{{ request()->is('pengaturan/pengguna-dan-hak-akses') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">manage_accounts</span>Pengguna &amp; Hak Akses</a></li>
            <li><a href="{{ url('pengaturan/master-data') }}" class="{{ request()->is('pengaturan/master-data') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">database</span>Master Data</a></li>
            <li><a href="{{ url('pengaturan/satuan-ukur') }}" class="{{ request()->is('pengaturan/satuan-ukur') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">straighten</span>Satuan Ukur</a></li>
            <li><a href="{{ url('pengaturan/penomoran-dokumen') }}" class="{{ request()->is('pengaturan/penomoran-dokumen') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">numbers</span>Penomoran Dokumen</a></li>
            <li><a href="{{ url('pengaturan/alur-persetujuan') }}" class="{{ request()->is('pengaturan/alur-persetujuan') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">account_tree</span>Alur Persetujuan</a></li>
            <li><a href="{{ url('pengaturan/integrasi-dan-api') }}" class="{{ request()->is('pengaturan/integrasi-dan-api') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">api</span>Integrasi &amp; API</a></li>
            <li><a href="{{ url('pengaturan/backup') }}" class="{{ request()->is('pengaturan/backup') ? 'on' : '' }}"><span class="material-symbols-outlined menu-icon">backup</span>Backup</a></li>
        </ul>
    </div>
</nav>
