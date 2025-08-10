<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$output = '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');

    if (empty($token)) {
        $error = "Token boş olamaz.";
    } else {
        $python = 'python';  // Windows'ta gerekirse tam yol verin, örn: C:\\Python39\\python.exe
        $script = 'server.py';
        $escaped_token = escapeshellarg($token);

        // Windows için arka planda çalıştırma:
        pclose(popen("start /B $python $script $escaped_token", "r"));

        // Linux/Mac için arkaplan çalıştırma örneği:
        // exec("nohup $python $script $escaped_token > /dev/null 2>&1 &");

        $success = "Bot başarıyla başlatıldı. Token: <code>" . htmlspecialchars($token) . "</code>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Discord Bot Başlat</title>
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
        <h2>🤖 Discord Bot Başlat</h2>
        <form method="POST">
            <label for="token">Bot Token:</label>
            <input type="text" id="token" name="token" required placeholder="DISCORD_BOT_TOKEN" autocomplete="off" />
            <button type="submit">Başlat</button>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
