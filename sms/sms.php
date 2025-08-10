<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$output = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tel_no = trim($_POST['tel_no'] ?? '');

    if (!preg_match('/^\d{10}$/', $tel_no)) {
        $error = "Lütfen 10 haneli geçerli bir telefon numarası girin.";
    } else {
        $python = 'python';  // Örneğin: C:\\Python39\\python.exe
        $script = __DIR__ . DIRECTORY_SEPARATOR . 'sms_send.py';
        $tel_escaped = escapeshellarg($tel_no);

        $cmd = "$python $script $tel_escaped 2>&1";
        $output = shell_exec($cmd);
        if ($output === null) {
            $error = "SMS gönderme işlemi başarısız oldu veya çıktı alınamadı.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>💬 SMS Panel</title><style>body {
    background-color: #000;
    color: #00ff00;
    font-family: monospace;
    margin: 0;
    padding: 0;
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

<div class="container">
    <h2>💬 SMS Gönderme Paneli</h2>
    <form method="POST">
        <label for="tel_no">Telefon Numarası (10 haneli):</label><br>
        <input type="text" id="tel_no" name="tel_no" maxlength="10" pattern="\d{10}" required placeholder="Örnek: 5551234567"><br>
        <button type="submit">SMS Gönder</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($output): ?>
        <pre><?= htmlspecialchars($output) ?></pre>
    <?php endif; ?>
</div>

</body>
</html>
