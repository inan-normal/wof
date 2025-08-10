<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$output = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokens_raw = trim($_POST['tokens'] ?? '');
    $hedef_kullanici_id = trim($_POST['user_id'] ?? '');
    $mesaj = trim($_POST['message'] ?? '');
    $adet = intval($_POST['adet'] ?? 1);

    if (empty($tokens_raw)) {
        $error = "En az 1 token girilmeli.";
    } elseif (empty($hedef_kullanici_id)) {
        $error = "Hedef kullanıcı ID boş olamaz.";
    } elseif (empty($mesaj)) {
        $error = "Mesaj boş olamaz.";
    } elseif ($adet < 1) {
        $error = "Gönderilecek mesaj adeti 1 veya daha büyük olmalı.";
    } else {
        $tokens = array_filter(array_map('trim', explode("\n", $tokens_raw)));
        $tokens_json = json_encode(array_values($tokens), JSON_UNESCAPED_UNICODE);
        $tokens_base64 = base64_encode($tokens_json);

        $python = 'python'; // Gerekirse tam python yolu: C:\\Python39\\python.exe
        $script = 'dm_bot.py';

        $cmd = "$python $script " . escapeshellarg($tokens_base64) . ' ' . escapeshellarg($hedef_kullanici_id) . ' ' . escapeshellarg($mesaj) . ' ' . escapeshellarg($adet) . " 2>&1";
        $output = shell_exec($cmd);

        if ($output === null) {
            $error = "Botlar başlatılamadı veya çıktı alınamadı.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Discord DM Bot Başlat</title>
<style>
    body { background:#000; color:#0f0; font-family: monospace; padding:20px; margin:0; }
    textarea, input, button { width: 100%; margin-top: 10px; background:#111; border:1px solid #0f0; color:#0f0; padding:10px; font-size:16px; box-sizing: border-box; }
    pre { background:#111; border:1px solid #0f0; padding:15px; margin-top:20px; white-space: pre-wrap; }
    label { display: block; margin-top: 15px; }
    .sidebar {
        background: #111;
        position: fixed;
        top: 0; left: 0;
        height: 100vh;
        width: 220px;
        padding: 15px;
        box-sizing: border-box;
        overflow-y: auto;
    }
    .sidebar h3 {
        color: #0f0;
        margin-top: 0;
        margin-bottom: 20px;
        font-weight: normal;
    }
    .sidebar a {
        display: block;
        padding: 8px 12px;
        color: #ccc;
        text-decoration: none;
        border-bottom: 1px solid #333;
        transition: background 0.3s, color 0.3s;
    }
    .sidebar a:hover {
        background: #333;
        color: #0f0;
    }
    .content {
        margin-left: 240px;
        padding: 20px;
    }
</style>
</head>
<body>

<div class="sidebar">
    <h3>📂 KATEGORİLER</h3>
    <?php include 'kategori.php'; ?>
    <?php foreach ($kategoriler as $kategori): ?>
        <a href="<?= htmlspecialchars($kategori['url']) ?>">
            <?= htmlspecialchars($kategori['label']) ?>
        </a>
    <?php endforeach; ?>
</div>
    <div class="content">
        <h2>🤖 Discord DM Spam Bot Başlat</h2>
        <form method="POST">
            <label for="tokens">Bot Tokenları (her token bir satır):</label>
            <textarea id="tokens" name="tokens" rows="5" placeholder="Token1&#10;Token2&#10;Token3"><?= htmlspecialchars($_POST['tokens'] ?? '') ?></textarea>

            <label for="user_id">Hedef Kullanıcı ID:</label>
            <input type="text" id="user_id" name="user_id" required value="<?= htmlspecialchars($_POST['user_id'] ?? '') ?>" placeholder="123456789012345678">

            <label for="message">Gönderilecek Mesaj:</label>
            <input type="text" id="message" name="message" required value="<?= htmlspecialchars($_POST['message'] ?? '') ?>" placeholder="Merhaba!">

            <label for="adet">Her botun kaç mesaj göndermesi gerekiyor?</label>
            <input type="number" id="adet" name="adet" min="1" max="1000" value="<?= htmlspecialchars($_POST['adet'] ?? '1') ?>">

            <button type="submit">Başlat</button>
        </form>

        <?php if ($error): ?>
            <div style="color:yellow; margin-top: 10px;"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($output): ?>
            <pre><?= htmlspecialchars($output) ?></pre>
        <?php endif; ?>
    </div>
</body>
</html>
