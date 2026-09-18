<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTabungan – Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue: #2563eb;
            --blue-hover: #1d4ed8;
            --blue-light: #eff6ff;
            --green: #16a34a;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8faff;
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

        /* Decorative circles */
        .bg-circle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-circle-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(37,99,235,0.08) 0%, transparent 70%);
            top: -200px; left: -200px;
            animation: drift1 12s ease-in-out infinite;
        }
        .bg-circle-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(22,163,74,0.07) 0%, transparent 70%);
            bottom: -100px; right: -100px;
            animation: drift2 15s ease-in-out infinite;
        }
        .bg-circle-3 {
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(37,99,235,0.05) 0%, transparent 70%);
            bottom: 200px; left: 100px;
            animation: drift3 10s ease-in-out infinite;
        }

        @keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(30px,20px)} }
        @keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-20px,-30px)} }
        @keyframes drift3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(15px,-15px)} }

        .card {
            background: var(--white);
            border-radius: 28px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.03), 0 20px 60px rgba(37,99,235,0.10);
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
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }

        .logo-text {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .logo-text span { color: var(--blue); }

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
        .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            display: block;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

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
            background: #fafbff;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }

        input:focus {
            border-color: var(--blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            color: var(--blue);
            user-select: none;
            letter-spacing: 0.4px;
            transition: opacity 0.2s;
        }
        .toggle-pw:hover { opacity: 0.7; }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
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
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,0.4);
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
<div class="bg-circle bg-circle-3"></div>

<div class="card">
    <div class="logo-wrap">
        <div class="logo-icon">💰</div>
        <div class="logo-text">My<span>Tabungan</span></div>
    </div>

    <h2>Selamat datang!</h2>
    <p class="subtitle">Masuk untuk mengelola tabunganmu</p>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-error">⚠️ Email atau password salah. Coba lagi.</div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Pendaftaran berhasil! Silakan masuk.</div>
    <?php endif; ?>

    <form action="cek_login.php" method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="user@example.com" required autocomplete="email">
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrap">
                <input type="password" name="password" id="passInput" placeholder="Masukkan password" required autocomplete="current-password">
                <span class="toggle-pw" onclick="togglePw('passInput', this)">LIHAT</span>
            </div>
        </div>

        <button type="submit" class="btn-primary">Masuk Sekarang →</button>
    </form>

    <div class="divider"></div>

    <p class="footer-text">Belum punya akun? <a href="daftar.php">Daftar Sekarang</a></p>
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
</script>
</body>
</html>