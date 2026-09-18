<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$nama    = $_SESSION['nama'];

// Hitung saldo
$sql_masuk  = mysqli_query($koneksi, "SELECT SUM(nominal) as total FROM transaksi WHERE jenis='pemasukan' AND id_user='$id_user'");
$masuk      = (int)(mysqli_fetch_assoc($sql_masuk)['total'] ?? 0);

$sql_keluar = mysqli_query($koneksi, "SELECT SUM(nominal) as total FROM transaksi WHERE jenis='pengeluaran' AND id_user='$id_user'");
$keluar     = (int)(mysqli_fetch_assoc($sql_keluar)['total'] ?? 0);

$total_saldo = $masuk - $keluar;

// Semua transaksi
$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_user='$id_user' ORDER BY id DESC");
$total_tx  = mysqli_num_rows($transaksi);

// Inisial nama
$inisial = strtoupper(substr($nama, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – MyTabungan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue: #2563eb;
            --blue-light: #eff6ff;
            --green: #16a34a;
            --green-light: #f0fdf4;
            --red: #dc2626;
            --red-light: #fef2f2;
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
            gap: 8px;
            white-space: nowrap;
        }

        .nav-greeting-text { display: inline; }

        .avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .btn-logout {
            padding: 8px 16px;
            background: #fef2f2;
            color: var(--red);
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
        .btn-logout:hover { background: #fee2e2; }

        .btn-petunjuk {
            padding: 8px 16px;
            background: var(--blue-light);
            color: var(--blue);
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-petunjuk:hover { background: #dbeafe; }

        @media (max-width: 600px) {
            .navbar { padding: 0 10px; gap: 6px; }
            .nav-logo { font-size: 16px; gap: 7px; }
            .nav-logo-icon { width: 30px; height: 30px; font-size: 13px; }
            .nav-greeting-text { display: none; }
            .nav-greeting { gap: 0; }
            .btn-petunjuk { padding: 7px 10px; font-size: 12px; }
            .btn-logout   { padding: 7px 10px; font-size: 12px; }
        }

        /* ── LAYOUT ── */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 20px 60px;
        }

        /* ── ALERT ── */
        .toast {
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeIn 0.3s ease;
        }
        .toast-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .toast-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .toast-del     { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }

        @keyframes fadeIn { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

        /* ── SUMMARY CARDS ── */
        .cards-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 640px) {
            .cards-grid { grid-template-columns: 1fr; }
            .container { padding: 16px 12px 60px; }
            .card { padding: 18px; }
            .card-amount { font-size: 22px; }
        }

        .card {
            background: var(--white);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover { transform: translateY(-2px); box-shadow: var(--shadow); }

        .card-saldo {
            background: linear-gradient(135deg, #1e40af, #2563eb, #3b82f6);
            border: none;
            color: white;
        }

        .card-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            opacity: 0.75;
            margin-bottom: 10px;
        }

        .card-saldo .card-label { opacity: 0.8; color: white; }

        .card-amount {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .card-saldo .card-amount { color: white; }

        .card-masuk .card-amount { color: var(--green); }
        .card-keluar .card-amount { color: var(--red); }

        .card-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
        }
        .card-saldo .card-sub { color: rgba(255,255,255,0.7); }

        .card-icon {
            font-size: 28px;
            margin-bottom: 12px;
            line-height: 1;
        }

        /* ── ACTION BUTTONS ── */
        .actions {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        @media (max-width: 600px) {
            .actions { gap: 10px; }
            .btn-action { font-size: 14px; padding: 12px 14px; min-width: 0; }
        }

        .btn-action {
            flex: 1;
            min-width: 140px;
            padding: 14px 20px;
            border: none;
            border-radius: 14px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn-masuk {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            box-shadow: 0 4px 14px rgba(22,163,74,0.3);
        }
        .btn-masuk:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(22,163,74,0.4); }

        .btn-keluar {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            box-shadow: 0 4px 14px rgba(220,38,38,0.3);
        }
        .btn-keluar:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(220,38,38,0.4); }

        /* ── TRANSAKSI TABLE ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .tx-count {
            font-size: 13px;
            color: var(--muted);
            background: var(--border);
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .table-wrap {
            background: var(--white);
            border-radius: 20px;
            border: 1px solid var(--border);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            box-shadow: var(--shadow-sm);
        }

        table {
            width: 100%;
            min-width: 480px;
            border-collapse: collapse;
        }

        @media (max-width: 600px) {
            table { min-width: 0; width: 100%; }
            .th-nominal, .td-nominal { display: none; }
            .th-aksi, .td-aksi-col { width: 44px; }
            thead th, td { padding: 12px 10px; font-size: 13px; }
            .td-keterangan { max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        }

        thead th {
            padding: 14px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            background: #f8faff;
            border-bottom: 1px solid var(--border);
        }

        tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8faff; }

        td {
            padding: 16px 20px;
            font-size: 14px;
            vertical-align: middle;
        }

        .td-tanggal {
            color: var(--muted);
            font-size: 13px;
            white-space: nowrap;
        }

        .td-keterangan {
            font-weight: 600;
            max-width: 200px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .badge-masuk  { background: #f0fdf4; color: #16a34a; }
        .badge-keluar { background: #fef2f2; color: #dc2626; }

        .td-nominal {
            text-align: right;
            font-weight: 700;
            font-size: 15px;
            white-space: nowrap;
        }

        .td-aksi { text-align: center; }

        .btn-del {
            width: 34px; height: 34px;
            border: none;
            background: #fef2f2;
            color: var(--red);
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-del:hover { background: #fee2e2; transform: scale(1.1); }

        /* Empty state */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }
        .empty-state .icon { font-size: 52px; margin-bottom: 16px; }
        .empty-state h3 { font-size: 17px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .empty-state p  { color: var(--muted); font-size: 14px; }

        /* ── FOOTER / DANGER ZONE ── */
        .danger-zone {
            margin-top: 48px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .btn-hapus-akun {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--red);
            font-size: 13px;
            font-family: inherit;
            font-weight: 600;
            opacity: 0.6;
            transition: opacity 0.2s;
            text-decoration: underline;
            text-underline-offset: 3px;
        }
        .btn-hapus-akun:hover { opacity: 1; }

        /* ── MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.5);
            z-index: 200;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            animation: fadeIn 0.2s;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: var(--white);
            border-radius: 24px;
            padding: 36px 32px;
            width: 100%;
            max-width: 400px;
            margin: 20px;
            animation: slideUp 0.3s ease-out;
            box-shadow: 0 24px 80px rgba(0,0,0,0.2);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .modal h3 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .modal p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .modal-form label {
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            display: block;
            margin-bottom: 8px;
        }

        .modal-form input[type="number"],
        .modal-form input[type="text"] {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text);
            background: #fafbff;
            outline: none;
            margin-bottom: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .modal-form input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
        }

        .modal-form input.focus-green:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 4px rgba(22,163,74,0.08);
        }

        .modal-form input.focus-red:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 4px rgba(220,38,38,0.08);
        }

        .modal-btns {
            display: flex;
            gap: 10px;
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            background: #f1f5f9;
            color: var(--muted);
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-cancel:hover { background: #e2e8f0; }

        .btn-confirm {
            flex: 2;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            color: white;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-confirm:hover { opacity: 0.9; }
        .btn-confirm-green { background: linear-gradient(135deg, #16a34a, #22c55e); }
        .btn-confirm-red   { background: linear-gradient(135deg, #dc2626, #ef4444); }
        .btn-confirm-danger { background: linear-gradient(135deg, #7f1d1d, #dc2626); }

        /* Confirm hapus akun modal */
        .modal-danger-icon {
            width: 56px; height: 56px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="dashboard.php" class="nav-logo">
        <div class="nav-logo-icon">💰</div>
        MyTabungan</span>
    </a>
    <div class="nav-spacer"></div>
    <div class="nav-greeting">
        <div class="avatar"><?php echo $inisial; ?></div>
        <span class="nav-greeting-text">Halo, <strong><?php echo htmlspecialchars($nama); ?></strong>!</span>
    </div>
    <a href="petunjuk.php" class="btn-petunjuk">📖 Petunjuk</a>
    <a href="logout.php" class="btn-logout">Keluar</a>
</nav>

<!-- MAIN -->
<div class="container">

    <?php if (isset($_GET['success'])): ?>
    <div class="toast toast-success">✅ Transaksi berhasil disimpan!</div>
    <?php elseif (isset($_GET['deleted'])): ?>
    <div class="toast toast-del">🗑️ Transaksi berhasil dihapus.</div>
    <?php elseif (isset($_GET['error'])): ?>
    <div class="toast toast-error">❌ Terjadi kesalahan. Coba lagi.</div>
    <?php endif; ?>

    <!-- SUMMARY CARDS -->
    <div class="cards-grid">
        <div class="card card-saldo">
            <div class="card-icon">💳</div>
            <div class="card-label">Total Saldo</div>
            <div class="card-amount">Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?></div>
            <div class="card-sub"><?php echo $total_tx; ?> transaksi total</div>
        </div>

        <div class="card card-masuk">
            <div class="card-icon">📈</div>
            <div class="card-label">Total Masuk</div>
            <div class="card-amount" style="font-size:22px;">+Rp <?php echo number_format($masuk, 0, ',', '.'); ?></div>
            <div class="card-sub">Pemasukan</div>
        </div>

        <div class="card card-keluar">
            <div class="card-icon">📉</div>
            <div class="card-label">Total Keluar</div>
            <div class="card-amount" style="font-size:22px;">-Rp <?php echo number_format($keluar, 0, ',', '.'); ?></div>
            <div class="card-sub">Pengeluaran</div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="actions">
        <button class="btn-action btn-masuk" onclick="openModal('masuk')">
            ➕ Tambah Pemasukan
        </button>
        <button class="btn-action btn-keluar" onclick="openModal('keluar')">
            ➖ Tambah Pengeluaran
        </button>
    </div>

    <!-- RIWAYAT TRANSAKSI -->
    <div class="section-header">
        <div class="section-title">Riwayat Transaksi</div>
        <div class="tx-count"><?php echo $total_tx; ?> transaksi</div>
    </div>

    <div class="table-wrap">
        <?php if ($total_tx === 0): ?>
        <div class="empty-state">
            <div class="icon">🪙</div>
            <h3>Belum ada transaksi</h3>
            <p>Mulai catat pemasukan atau pengeluaranmu!</p>
        </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th class="th-nominal" style="text-align:right;">Nominal</th>
                    <th class="th-aksi" style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($transaksi, 0);
                while ($r = mysqli_fetch_array($transaksi)):
                    $isMasuk = ($r['jenis'] == 'pemasukan');
                ?>
                <tr>
                    <td class="td-tanggal"><?php echo date('d M Y', strtotime($r['tanggal'])); ?></td>
                    <td class="td-keterangan"><?php echo htmlspecialchars($r['keterangan']); ?></td>
                    <td>
                        <?php if ($isMasuk): ?>
                        <span class="badge badge-masuk">↑ Masuk</span>
                        <?php else: ?>
                        <span class="badge badge-keluar">↓ Keluar</span>
                        <?php endif; ?>
                    </td>
                    <td class="td-nominal" style="color:<?php echo $isMasuk ? '#16a34a' : '#dc2626'; ?>">
                        <?php echo ($isMasuk ? '+' : '-') . 'Rp ' . number_format($r['nominal'], 0, ',', '.'); ?>
                    </td>
                    <td class="td-aksi td-aksi-col">
                        <button class="btn-del" onclick="konfirmasiHapus(<?php echo $r['id']; ?>)" title="Hapus">🗑️</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <!-- DANGER ZONE -->
    <div class="danger-zone">
        <button class="btn-hapus-akun" onclick="openModalHapusAkun()">Hapus Akun Saya</button>
    </div>
</div>

<!-- MODAL: TAMBAH PEMASUKAN -->
<div class="modal-overlay" id="modalMasuk">
    <div class="modal">
        <h3>📈 Tambah Pemasukan</h3>
        <p>Catat uang yang masuk ke tabunganmu.</p>
        <form action="proses_transaksi.php" method="POST" class="modal-form">
            <input type="hidden" name="jenis" value="pemasukan">
            <label>Nominal (Rp)</label>
            <input type="number" name="nominal" placeholder="Contoh: 50000" required class="focus-green" min="1">
            <label>Keterangan</label>
            <input type="text" name="keterangan" placeholder="Contoh: Jual barang bekas" required class="focus-green">
            <div class="modal-btns">
                <button type="button" class="btn-cancel" onclick="closeModal('modalMasuk')">Batal</button>
                <button type="submit" class="btn-confirm btn-confirm-green">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: TAMBAH PENGELUARAN -->
<div class="modal-overlay" id="modalKeluar">
    <div class="modal">
        <h3>📉 Tambah Pengeluaran</h3>
        <p>Catat uang yang keluar dari tabunganmu.</p>
        <form action="proses_transaksi.php" method="POST" class="modal-form">
            <input type="hidden" name="jenis" value="pengeluaran">
            <label>Nominal (Rp)</label>
            <input type="number" name="nominal" placeholder="Contoh: 15000" required class="focus-red" min="1">
            <label>Keterangan</label>
            <input type="text" name="keterangan" placeholder="Contoh: Beli jajan" required class="focus-red">
            <div class="modal-btns">
                <button type="button" class="btn-cancel" onclick="closeModal('modalKeluar')">Batal</button>
                <button type="submit" class="btn-confirm btn-confirm-red">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: KONFIRMASI HAPUS TRANSAKSI -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal" style="max-width:360px;">
        <div class="modal-danger-icon">🗑️</div>
        <h3>Hapus Transaksi?</h3>
        <p>Transaksi ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
        <div class="modal-btns">
            <button type="button" class="btn-cancel" onclick="closeModal('modalHapus')">Batal</button>
            <a id="hapusLink" href="#" class="btn-confirm btn-confirm-red" style="display:flex;align-items:center;justify-content:center;text-decoration:none;">
                Ya, Hapus
            </a>
        </div>
    </div>
</div>

<!-- MODAL: KONFIRMASI HAPUS AKUN -->
<div class="modal-overlay" id="modalHapusAkun">
    <div class="modal" style="max-width:380px;">
        <div class="modal-danger-icon">⚠️</div>
        <h3 style="color:#dc2626;">Hapus Akun?</h3>
        <p>Semua data akun dan transaksimu akan dihapus <strong>secara permanen</strong>. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-btns">
            <button type="button" class="btn-cancel" onclick="closeModal('modalHapusAkun')">Batal</button>
            <a href="hapus_akun.php" class="btn-confirm btn-confirm-danger" style="display:flex;align-items:center;justify-content:center;text-decoration:none;">
                Ya, Hapus Akun
            </a>
        </div>
    </div>
</div>

<script>
function openModal(jenis) {
    if (jenis === 'masuk') {
        document.getElementById('modalMasuk').classList.add('open');
    } else {
        document.getElementById('modalKeluar').classList.add('open');
    }
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

function konfirmasiHapus(id) {
    document.getElementById('hapusLink').href = 'hapus.php?id=' + id;
    document.getElementById('modalHapus').classList.add('open');
}

function openModalHapusAkun() {
    document.getElementById('modalHapusAkun').classList.add('open');
}

// Tutup modal saat klik overlay
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
});

// Auto-hide toast
setTimeout(() => {
    const t = document.querySelector('.toast');
    if (t) t.style.opacity = '0', t.style.transition = 'opacity 0.5s', setTimeout(() => t.remove(), 500);
}, 3000);
</script>
</body>
</html>