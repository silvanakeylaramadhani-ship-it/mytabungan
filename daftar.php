<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTabungan – Daftar</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue: #2563eb;
            --green: #16a34a;
            --green-hover: #15803d;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --bg: #f0fdf8;
            --white: #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 16px;
        }

        .bg-circle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-circle-1 {
            width: 550px; height: 550px;
            background: radial-gradient(circle, rgba(22,163,74,0.09) 0%, transparent 70%);
            top: -180px; right: -150px;
            animation: drift1 14s ease-in-out infinite;
        }
        .bg-circle-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(37,99,235,0.07) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            animation: drift2 11s ease-in-out infinite;
        }

        @keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-25px,20px)} }
        @keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-20px)} }

        .card {
            background: var(--white);
            border-radius: 28px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.03), 0 20px 60px rgba(22,163,74,0.10);
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease-out;
        }

        @media (max-width: 480px) {
            body { align-items: flex-start; padding: 12px; }
            .card { padding: 28px 22px; border-radius: 20px; margin: auto 0; }
            .logo-wrap { margin-bottom: 18px; }
            .logo-icon { width: 40px; height: 40px; font-size: 18px; border-radius: 12px; }
            .logo-text { font-size: 19px; }
            h2 { font-size: 22px; margin-bottom: 4px; }
            .subtitle { font-size: 13px; margin-bottom: 22px; }
            .form-group { margin-bottom: 14px; }
            input[type="email"], input[type="password"], input[type="text"] { padding: 11px 14px; font-size: 14px; }
            .btn-primary { padding: 13px; font-size: 14px; }
            .divider { margin: 18px 0; }
            .pw-strength { margin-top: 6px; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .logo-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(22,163,74,0.3);
        }

        .logo-text {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
        }
        .logo-text span { color: var(--green); }

        h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 30px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        .form-group { margin-bottom: 18px; }

        label {
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            display: block;
            margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text);
            background: #f8fffe;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }

        input:focus {
            border-color: var(--green);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(22,163,74,0.08);
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            color: var(--green);
            user-select: none;
            letter-spacing: 0.4px;
        }
        .toggle-pw:hover { opacity: 0.7; }

        /* Password strength */
        .pw-strength { margin-top: 8px; display: none; }
        .pw-bar-wrap { height: 4px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
        .pw-bar { height: 100%; border-radius: 4px; transition: width 0.3s, background 0.3s; width: 0; }
        .pw-label { font-size: 11px; color: var(--muted); margin-top: 4px; }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
            font-family: inherit;
            letter-spacing: 0.3px;
            margin-top: 8px;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(22,163,74,0.35);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(22,163,74,0.4);
        }
        .btn-primary:active { transform: translateY(0); }

        .footer-text {
            text-align: center;
            font-size: 13.5px;
            color: var(--muted);
            margin-top: 22px;
        }
        .footer-text a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 700;
        }
        .footer-text a:hover { text-decoration: underline; }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 24px 0;
        }
    </style>
</head>
<body>

<div class="bg-circle bg-circle-1"></div>
<div class="bg-circle bg-circle-2"></div>

<div class="card">
    <div class="logo-wrap">
        <div class="logo-icon">💰</div>
        <div class="logo-text">My<span>Tabungan</span></div>
    </div>

    <h2>Buat akun baru</h2>
    <p class="subtitle">Mulai kelola keuanganmu hari ini!</p>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-error">
        <?php if ($_GET['error'] === 'email_exists'): ?>
        ⚠️ Email sudah terdaftar. Silakan login.
        <?php else: ?>
        ⚠️ Pendaftaran gagal. Coba lagi.
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <form action="proses_daftar.php" method="POST">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukkan nama anda" required autocomplete="name">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="user@example.com" required autocomplete="email">
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrap">
                <input type="password" name="password" id="passInput" placeholder="Buat password baru" required autocomplete="new-password" oninput="checkStrength(this.value)">
                <span class="toggle-pw" onclick="togglePw('passInput', this)">LIHAT</span>
            </div>
            <div class="pw-strength" id="pwStrength">
                <div class="pw-bar-wrap"><div class="pw-bar" id="pwBar"></div></div>
                <div class="pw-label" id="pwLabel"></div>
            </div>
        </div>

        <button type="submit" class="btn-primary">Daftar Sekarang →</button>
    </form>

    <div class="divider"></div>

    <p class="footer-text">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

<script>
function togglePw(id, el) {
    const inp = document.getElementById(id);
    if (inp.type === 'password') {
        inp.type = 'text';
        el.textContent = 'SEMBUNYIKAN';
    } else {
        inp.type = 'password';
        el.textContent = 'LIHAT';
    }
}

function checkStrength(val) {
    const wrap = document.getElementById('pwStrength');
    const bar  = document.getElementById('pwBar');
    const lbl  = document.getElementById('pwLabel');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';

    let score = 0;
    if (val.length >= 6) score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { w: '20%', c: '#ef4444', t: 'Terlalu lemah' },
        { w: '40%', c: '#f97316', t: 'Lemah' },
        { w: '60%', c: '#eab308', t: 'Sedang' },
        { w: '80%', c: '#22c55e', t: 'Kuat' },
        { w: '100%', c: '#16a34a', t: 'Sangat kuat 💪' },
    ];
    const lvl = levels[Math.min(score - 1, 4)] || levels[0];
    bar.style.width = lvl.w;
    bar.style.background = lvl.c;
    lbl.textContent = lvl.t;
    lbl.style.color = lvl.c;
}
</script>
</body>
</html>