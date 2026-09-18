<?php
session_start();
$logged_in = isset($_SESSION['status']) && $_SESSION['status'] == "login";
$nama      = $logged_in ? $_SESSION['nama'] : '';
$inisial   = $logged_in ? strtoupper(substr($nama, 0, 1)) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petunjuk – MyTabungan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue: #2563eb;
            --blue-light: #eff6ff;
            --green: #16a34a;
            --green-light: #f0fdf4;
            --red: #dc2626;
            --orange: #ea580c;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8faff;
            --white: #ffffff;
            --navbar-h: 64px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            height: var(--navbar-h);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            box-shadow: var(--shadow-sm);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 19px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.4px;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .nav-logo span { color: var(--blue); }
        .nav-spacer { flex: 1; }
        .nav-greeting {
            font-size: 14px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }
        .btn-nav {
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
            font-family: inherit;
            text-decoration: none;
            transition: background 0.2s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-back {
            background: var(--blue-light);
            color: var(--blue);
        }
        .btn-back:hover { background: #dbeafe; }
        .btn-logout {
            background: #fef2f2;
            color: var(--red);
        }
        .btn-logout:hover { background: #fee2e2; }

        .nav-greeting-text { display: inline; }

        @media (max-width: 600px) {
            .navbar { padding: 0 10px; gap: 6px; }
            .nav-logo { font-size: 16px; gap: 7px; }
            .nav-logo-icon { width: 30px; height: 30px; font-size: 13px; }
            .nav-logo span { color: var(--blue); }
            .nav-greeting-text { display: none; }
            .nav-greeting { gap: 0; }
            .btn-nav { padding: 7px 10px; font-size: 12px; }
        }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, #1e40af, #2563eb, #3b82f6);
            padding: 56px 24px 72px;
            text-align: center;
            position: relative;
            overflow: hidden;
            width: 100%;
            box-sizing: border-box;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            backdrop-filter: blur(4px);
        }
        .hero h1 {
            font-size: 36px;
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
            margin-bottom: 12px;
        }
        @media (max-width: 600px) {
            .hero { padding: 40px 16px 60px; }
            .hero h1 { font-size: 26px; letter-spacing: -0.5px; }
            .hero p { font-size: 14px; }
            .hero-badge { font-size: 11px; padding: 5px 12px; }
        }
        .hero p {
            color: rgba(255,255,255,0.8);
            font-size: 16px;
            max-width: 480px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .hero-deco {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .hero-deco-1 { width: 300px; height: 300px; top: -100px; right: -80px; }
        .hero-deco-2 { width: 180px; height: 180px; bottom: -60px; left: -40px; }

        @media (max-width: 480px) {
            .hero-deco-1 { width: 180px; height: 180px; top: -60px; right: -50px; }
            .hero-deco-2 { width: 120px; height: 120px; }
        }

        /* ── QUICK NAV ── */
        .quick-nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            padding: 0 24px;
            margin-top: -24px;
            position: relative;
            z-index: 10;
            max-width: 860px;
            margin-left: auto;
            margin-right: auto;
        }
        .quick-nav a {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 7px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.15s, box-shadow 0.15s, border-color 0.15s;
        }
        .quick-nav a:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--blue);
            color: var(--blue);
        }

        /* ── CONTAINER ── */
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 48px 20px 80px;
        }

        /* ── SECTION ── */
        .section {
            margin-bottom: 48px;
            animation: fadeUp 0.5s ease-out both;
        }
        .section:nth-child(1) { animation-delay: 0.05s; }
        .section:nth-child(2) { animation-delay: 0.1s; }
        .section:nth-child(3) { animation-delay: 0.15s; }
        .section:nth-child(4) { animation-delay: 0.2s; }
        .section:nth-child(5) { animation-delay: 0.25s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            scroll-margin-top: 80px;
        }
        .section-heading-icon {
            width: 46px; height: 46px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .icon-blue  { background: var(--blue-light); }
        .icon-green { background: var(--green-light); }
        .icon-red   { background: #fef2f2; }
        .icon-orange{ background: #fff7ed; }
        .icon-purple{ background: #faf5ff; }

        .section-heading h2 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }
        .section-heading p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── STEPS ── */
        .steps {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .step {
            display: flex;
            gap: 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .step:hover {
            border-color: #bfdbfe;
            box-shadow: 0 4px 16px rgba(37,99,235,0.08);
        }
        .step-num {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            font-size: 13px;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .step-num.green { background: linear-gradient(135deg, #16a34a, #22c55e); }
        .step-num.red   { background: linear-gradient(135deg, #dc2626, #ef4444); }
        .step-num.orange{ background: linear-gradient(135deg, #ea580c, #f97316); }

        .step-body h4 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .step-body p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }
        .step-body .chip {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-top: 8px;
        }
        .chip-green { background: var(--green-light); color: var(--green); }
        .chip-red   { background: #fef2f2; color: var(--red); }
        .chip-blue  { background: var(--blue-light); color: var(--blue); }
        .chip-orange{ background: #fff7ed; color: var(--orange); }

        /* ── FAQ ── */
        .faq-list { display: flex; flex-direction: column; gap: 10px; }

        .faq-item {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .faq-q {
            width: 100%;
            background: none;
            border: none;
            padding: 18px 20px;
            text-align: left;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: background 0.15s;
        }
        .faq-q:hover { background: #f8faff; }

        .faq-icon {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--blue-light);
            color: var(--blue);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            font-weight: 800;
            flex-shrink: 0;
            transition: transform 0.3s, background 0.2s;
        }

        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.35s ease;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.7;
            padding: 0 20px;
        }
        .faq-a.open {
            max-height: 300px;
            padding: 0 20px 18px;
        }
        .faq-item.active .faq-icon {
            transform: rotate(45deg);
            background: var(--blue);
            color: white;
        }

        /* ── TIPS GRID ── */
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
        }
        .tip-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .tip-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
        .tip-card .tip-icon { font-size: 28px; margin-bottom: 12px; }
        .tip-card h4 { font-size: 14px; font-weight: 800; margin-bottom: 6px; }
        .tip-card p  { font-size: 13px; color: var(--muted); line-height: 1.6; }

        /* ── GLOSSARY ── */
        .glossary {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }
        .glossary-row {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }
        .glossary-row:last-child { border-bottom: none; }
        .glossary-row:hover { background: #f8faff; }
        .glossary-term {
            width: 160px;
            flex-shrink: 0;
            padding: 16px 20px;
            font-size: 13px;
            font-weight: 800;
            color: var(--blue);
            border-right: 1px solid var(--border);
        }
        .glossary-def {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── CTA ── */
        .cta-box {
            background: linear-gradient(135deg, #1e40af, #2563eb, #3b82f6);
            border-radius: 20px;
            padding: 36px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-box::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
        }
        .cta-box h3 {
            font-size: 22px;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
            position: relative;
        }
        .cta-box p {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            margin-bottom: 20px;
            position: relative;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--blue);
            font-weight: 800;
            font-size: 15px;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
            position: relative;
        }
        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .hero h1 { font-size: 26px; }
            .glossary-term { width: 110px; font-size: 12px; }
            .quick-nav a { font-size: 12px; padding: 8px 12px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="<?php echo $logged_in ? 'dashboard.php' : 'login.php'; ?>" class="nav-logo">
        <div class="nav-logo-icon">💰</div>
        My<span>Tabungan</span>
    </a>
    <div class="nav-spacer"></div>
    <?php if ($logged_in): ?>
    <div class="nav-greeting">
        <div class="avatar"><?php echo $inisial; ?></div>
        <span class="nav-greeting-text">Halo, <strong><?php echo htmlspecialchars($nama); ?></strong>!</span>
    </div>
    <a href="dashboard.php" class="btn-nav btn-back">← Dashboard</a>
    <a href="logout.php" class="btn-nav btn-logout">Keluar</a>
    <?php else: ?>
    <a href="login.php" class="btn-nav btn-back">Masuk</a>
    <?php endif; ?>
</nav>

<!-- HERO -->
<div class="hero">
    <div class="hero-deco hero-deco-1"></div>
    <div class="hero-deco hero-deco-2"></div>
    <div class="hero-badge">📖 Panduan Penggunaan</div>
    <h1>Cara Pakai MyTabungan</h1>
    <p>Pelajari cara mencatat pemasukan, pengeluaran, dan memantau saldo tabunganmu dengan mudah.</p>
</div>

<!-- QUICK NAV -->
<div class="quick-nav">
    <a href="#mulai">🚀 Mulai</a>
    <a href="#pemasukan">📈 Pemasukan</a>
    <a href="#pengeluaran">📉 Pengeluaran</a>
    <a href="#hapus">🗑️ Hapus</a>
    <a href="#faq">❓ FAQ</a>
    <a href="#tips">💡 Tips</a>
    <a href="#glossary">📚 Istilah</a>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- 1. MEMULAI -->
    <div class="section" id="mulai">
        <div class="section-heading">
            <div class="section-heading-icon icon-blue">🚀</div>
            <div>
                <h2>Memulai MyTabungan</h2>
                <p>Daftar akun dan masuk hanya dalam beberapa langkah</p>
            </div>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-body">
                    <h4>Buka halaman Daftar</h4>
                    <p>Kunjungi <strong>daftar.php</strong> dan isi nama lengkap, email, serta password. Pastikan password minimal 6 karakter agar akunmu lebih aman.</p>
                    <span class="chip chip-blue">Gratis & Cepat</span>
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-body">
                    <h4>Masuk ke akunmu</h4>
                    <p>Setelah daftar, kamu akan diarahkan ke halaman <strong>Login</strong>. Masukkan email dan password yang tadi dibuat, lalu klik <em>Masuk Sekarang</em>.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-body">
                    <h4>Lihat Dashboard</h4>
                    <p>Setelah masuk, kamu langsung dibawa ke <strong>Dashboard</strong> — pusat kendali tabunganmu. Di sini kamu bisa melihat saldo, total pemasukan, total pengeluaran, dan semua riwayat transaksi.</p>
                    <span class="chip chip-green">Siap dipakai!</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TAMBAH PEMASUKAN -->
    <div class="section" id="pemasukan">
        <div class="section-heading">
            <div class="section-heading-icon icon-green">📈</div>
            <div>
                <h2>Mencatat Pemasukan</h2>
                <p>Catat setiap uang yang masuk agar saldo selalu akurat</p>
            </div>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-num green">1</div>
                <div class="step-body">
                    <h4>Klik tombol "➕ Tambah Pemasukan"</h4>
                    <p>Tombol hijau ini ada di bagian atas dashboard, tepat di bawah kartu saldo. Klik tombol tersebut untuk membuka form input.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num green">2</div>
                <div class="step-body">
                    <h4>Isi Nominal</h4>
                    <p>Masukkan jumlah uang yang masuk dalam angka (contoh: <strong>50000</strong> untuk Rp 50.000). Jangan tambahkan titik atau koma.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num green">3</div>
                <div class="step-body">
                    <h4>Isi Keterangan</h4>
                    <p>Tulis sumber pemasukannya, misalnya: <em>"Gaji bulanan"</em>, <em>"Jual barang bekas"</em>, atau <em>"Kiriman dari orang tua"</em>. Keterangan ini memudahkan kamu saat melihat riwayat nanti.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num green">4</div>
                <div class="step-body">
                    <h4>Klik "Simpan Transaksi"</h4>
                    <p>Transaksi akan langsung tersimpan dan saldo di dashboard otomatis bertambah. Kamu akan melihat notifikasi hijau <em>"Transaksi berhasil disimpan!"</em>.</p>
                    <span class="chip chip-green">Saldo otomatis update</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TAMBAH PENGELUARAN -->
    <div class="section" id="pengeluaran">
        <div class="section-heading">
            <div class="section-heading-icon icon-red">📉</div>
            <div>
                <h2>Mencatat Pengeluaran</h2>
                <p>Pantau ke mana perginya uangmu setiap saat</p>
            </div>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-num red">1</div>
                <div class="step-body">
                    <h4>Klik tombol "➖ Tambah Pengeluaran"</h4>
                    <p>Tombol merah ini ada di sebelah kanan tombol pemasukan. Klik untuk membuka form pengeluaran.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num red">2</div>
                <div class="step-body">
                    <h4>Isi Nominal & Keterangan</h4>
                    <p>Sama seperti pemasukan — isi jumlah angka dan keterangan pengeluarannya. Contoh: <em>"Beli makan siang"</em>, <em>"Bayar listrik"</em>, <em>"Beli pulsa"</em>.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num red">3</div>
                <div class="step-body">
                    <h4>Simpan</h4>
                    <p>Setelah disimpan, nominal akan dikurangi dari saldo. Transaksi muncul di riwayat dengan label merah <em>"↓ Keluar"</em>.</p>
                    <span class="chip chip-red">Saldo otomatis berkurang</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. HAPUS TRANSAKSI -->
    <div class="section" id="hapus">
        <div class="section-heading">
            <div class="section-heading-icon icon-orange">🗑️</div>
            <div>
                <h2>Menghapus Transaksi</h2>
                <p>Hapus catatan yang salah atau tidak diperlukan</p>
            </div>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-num orange">1</div>
                <div class="step-body">
                    <h4>Temukan transaksi di riwayat</h4>
                    <p>Scroll ke bawah di dashboard untuk melihat tabel <strong>Riwayat Transaksi</strong>. Semua transaksimu tampil di sini, dari yang terbaru.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num orange">2</div>
                <div class="step-body">
                    <h4>Klik ikon 🗑️ di kolom Aksi</h4>
                    <p>Setiap baris transaksi punya tombol hapus di ujung kanan. Klik tombol tersebut — akan muncul jendela konfirmasi.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num orange">3</div>
                <div class="step-body">
                    <h4>Konfirmasi penghapusan</h4>
                    <p>Klik <strong>"Ya, Hapus"</strong> untuk menghapus permanen. Klik <strong>"Batal"</strong> jika berubah pikiran. Setelah dihapus, saldo otomatis menyesuaikan.</p>
                    <span class="chip chip-orange">⚠️ Tidak bisa dikembalikan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. FAQ -->
    <div class="section" id="faq">
        <div class="section-heading">
            <div class="section-heading-icon icon-purple">❓</div>
            <div>
                <h2>Pertanyaan Umum (FAQ)</h2>
                <p>Jawaban untuk pertanyaan yang sering ditanyakan</p>
            </div>
        </div>
        <div class="faq-list">

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    Bagaimana cara keluar dari akun?
                    <div class="faq-icon">+</div>
                </button>
                <div class="faq-a">
                    Klik tombol <strong>Keluar</strong> yang ada di pojok kanan atas navbar. Kamu akan langsung keluar dan diarahkan ke halaman login.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    Apakah data saya aman?
                    <div class="faq-icon">+</div>
                </button>
                <div class="faq-a">
                    Data kamu tersimpan di database dan hanya bisa diakses oleh akun milikmu sendiri. Setiap transaksi yang ditampilkan difilter berdasarkan akun yang sedang login.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    Bisakah saya mengubah transaksi yang sudah disimpan?
                    <div class="faq-icon">+</div>
                </button>
                <div class="faq-a">
                    Saat ini fitur edit transaksi belum tersedia. Jika ada kesalahan, hapus transaksi yang salah lalu tambahkan ulang dengan data yang benar.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    Apa yang terjadi jika saya hapus akun?
                    <div class="faq-icon">+</div>
                </button>
                <div class="faq-a">
                    Semua data akun dan seluruh riwayat transaksimu akan dihapus <strong>secara permanen</strong> dari database. Tindakan ini tidak dapat dibatalkan, jadi pastikan kamu sudah yakin sebelum menghapus akun.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    Kenapa saldo saya minus?
                    <div class="faq-icon">+</div>
                </button>
                <div class="faq-a">
                    Saldo dihitung dari total pemasukan dikurangi total pengeluaran. Jika pengeluaran lebih besar dari pemasukan yang dicatat, saldo akan tampil negatif. Pastikan semua pemasukan sudah tercatat dengan lengkap.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    Bagaimana urutan transaksi di riwayat?
                    <div class="faq-icon">+</div>
                </button>
                <div class="faq-a">
                    Transaksi ditampilkan dari yang paling baru (terbaru di atas), sehingga catatan terakhirmu selalu mudah ditemukan di bagian atas tabel.
                </div>
            </div>

        </div>
    </div>

    <!-- 6. TIPS -->
    <div class="section" id="tips">
        <div class="section-heading">
            <div class="section-heading-icon icon-blue">💡</div>
            <div>
                <h2>Tips Mengelola Tabungan</h2>
                <p>Kebiasaan kecil yang bikin keuanganmu lebih sehat</p>
            </div>
        </div>
        <div class="tips-grid">
            <div class="tip-card">
                <div class="tip-icon">📅</div>
                <h4>Catat setiap hari</h4>
                <p>Jangan tunda-tunda. Catat pengeluaran sesegera mungkin setelah terjadi agar tidak ada yang terlewat.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">🔍</div>
                <h4>Keterangan yang jelas</h4>
                <p>Tulis keterangan yang spesifik, bukan hanya "belanja". Ini memudahkan kamu menganalisis pola keuanganmu nanti.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">📊</div>
                <h4>Pantau saldo rutin</h4>
                <p>Cek dashboard minimal seminggu sekali untuk memantau apakah pengeluaranmu masih dalam batas yang wajar.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">🎯</div>
                <h4>Catat semua pemasukan</h4>
                <p>Jangan lewatkan pemasukan sekecil apapun — uang hasil jual barang, dapat transfer, bonus, semuanya penting.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">🔐</div>
                <h4>Jaga keamanan akun</h4>
                <p>Gunakan password yang kuat dan jangan bagikan ke siapapun. Selalu logout jika menggunakan perangkat bersama.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">📝</div>
                <h4>Review akhir bulan</h4>
                <p>Lihat seluruh riwayat di akhir bulan untuk evaluasi — apakah pengeluaran sudah sesuai rencana?</p>
            </div>
        </div>
    </div>

    <!-- 7. GLOSSARY -->
    <div class="section" id="glossary">
        <div class="section-heading">
            <div class="section-heading-icon icon-green">📚</div>
            <div>
                <h2>Istilah di MyTabungan</h2>
                <p>Arti dari istilah-istilah yang digunakan di aplikasi ini</p>
            </div>
        </div>
        <div class="glossary">
            <div class="glossary-row">
                <div class="glossary-term">Saldo</div>
                <div class="glossary-def">Jumlah uang yang tersisa, dihitung dari total pemasukan dikurangi total pengeluaran.</div>
            </div>
            <div class="glossary-row">
                <div class="glossary-term">Pemasukan</div>
                <div class="glossary-def">Uang yang masuk ke tabunganmu, seperti gaji, kiriman, atau hasil penjualan.</div>
            </div>
            <div class="glossary-row">
                <div class="glossary-term">Pengeluaran</div>
                <div class="glossary-def">Uang yang keluar dari tabunganmu untuk membeli sesuatu atau membayar tagihan.</div>
            </div>
            <div class="glossary-row">
                <div class="glossary-term">Transaksi</div>
                <div class="glossary-def">Setiap pencatatan pemasukan atau pengeluaran yang kamu buat di aplikasi.</div>
            </div>
            <div class="glossary-row">
                <div class="glossary-term">Riwayat</div>
                <div class="glossary-def">Daftar semua transaksi yang pernah dicatat, diurutkan dari yang terbaru.</div>
            </div>
            <div class="glossary-row">
                <div class="glossary-term">Keterangan</div>
                <div class="glossary-def">Catatan singkat yang menjelaskan tujuan atau sumber dari sebuah transaksi.</div>
            </div>
            <div class="glossary-row">
                <div class="glossary-term">Nominal</div>
                <div class="glossary-def">Jumlah uang dalam satuan Rupiah (Rp) untuk setiap transaksi yang dicatat.</div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="cta-box">
        <h3>Sudah siap? Yuk mulai mencatat! 💰</h3>
        <p>Konsisten mencatat adalah kunci keuangan yang sehat.</p>
        <?php if ($logged_in): ?>
        <a href="dashboard.php" class="cta-btn">Buka Dashboard →</a>
        <?php else: ?>
        <a href="daftar.php" class="cta-btn">Daftar Sekarang →</a>
        <?php endif; ?>
    </div>

</div>

<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const ans  = item.querySelector('.faq-a');
    const isOpen = item.classList.contains('active');

    // Tutup semua
    document.querySelectorAll('.faq-item.active').forEach(el => {
        el.classList.remove('active');
        el.querySelector('.faq-a').classList.remove('open');
    });

    // Buka yang diklik (kecuali sudah terbuka)
    if (!isOpen) {
        item.classList.add('active');
        ans.classList.add('open');
    }
}

// Smooth scroll untuk quick nav
document.querySelectorAll('.quick-nav a').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>
</body>
</html>