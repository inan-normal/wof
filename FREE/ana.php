<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: giriş.php");
    exit;
}

$user = $_SESSION['user'];

$categories = ['Python', 'JavaScript', 'CMD', 'AOIJS', 'Paneller'];

?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Ana Sayfa</title>
<style>
    body { background: #121212; color: #eee; font-family: Arial, sans-serif; padding: 20px; }
    h1 { text-align: center; margin-bottom: 30px; }
    ul { list-style: none; padding: 0; max-width: 400px; margin: 0 auto; }
    li { background: #222; margin: 10px 0; padding: 15px; border-radius: 8px; text-align: center; }
    a { color: #0f0; text-decoration: none; font-weight: bold; display: block; }
    a:hover { color: #afa; }
    .logout { position: fixed; top: 10px; right: 10px; background: #0f0; color: #000; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-weight: bold; }
    .admin-menu { max-width: 400px; margin: 20px auto; background: #222; padding: 15px; border-radius: 8px; }
    .admin-menu a { display: block; margin: 10px 0; color: #0f0; font-weight: bold; }
</style>
</head>
<body>

<a href="logout.php" class="logout">Çıkış Yap</a>

<h1>Hoşgeldin, <?= htmlspecialchars($user) ?></h1>

<?php if ($user === 'admin'): ?>
    <div class="admin-menu">
        <h2>Admin Menüsü</h2>
        <a href="admin.php">Kod Ekle / Sil</a>
        <a href="free.php">Bedava Kodlar (Free Site)</a>
    </div>
<?php else: ?>
    <h2>Bedava Kod Kategorileri</h2>
    <ul>
        <?php foreach ($categories as $cat): ?>
            <li><a href="free.php?kategori=<?= urlencode($cat) ?>"><?= htmlspecialchars($cat) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
