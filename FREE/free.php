<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: giriş.php");
    exit;
}

// Buraya free.php veya admin.php kodları gelecek
?>

<?php
include 'db.php';

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

if ($kategori) {
    $stmt = $conn->prepare("SELECT * FROM kodlar WHERE kategori = ? ORDER BY id DESC");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM kodlar ORDER BY id DESC");
}
?>

<style>
    body { background: #121212; color: #eee; font-family: monospace; }
    a { color: #0f0; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .kod-container {
        background: #222; padding: 15px; margin: 15px auto; max-width: 700px; border-radius: 10px;
        white-space: pre-wrap; font-family: monospace; font-size: 14px; color: #0f0;
    }
    .zip-link {
        background: #444; padding: 10px; margin: 15px auto; max-width: 700px; border-radius: 10px;
    }
    .kategori-list {
        margin: 15px auto; max-width: 700px; text-align:center;
    }
    .kategori-list a {
        margin: 0 8px; font-weight: bold; color: #0f0;
    }
</style>

<div class="kategori-list">
    <a href="free.php">Tüm Kategoriler</a> |
    <a href="free.php?kategori=Python">Python</a> |
    <a href="free.php?kategori=CMD">CMD</a> |
    <a href="free.php?kategori=JavaScript">JavaScript</a> |
    <a href="free.php?kategori=AOIJS">AOIJS</a> |
    <a href="free.php?kategori=DİĞER">DİĞER</a>
    <a href="free.php?kategori=Html">Site</a>
</div>

<?php
if ($result->num_rows == 0) {
    echo "<p style='text-align:center;'>Hiç kod veya dosya bulunamadı.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='kod-container'>";
        echo "<h3>{$row['baslik']} ({$row['kategori']})</h3>";

        if ($row['tur'] == 'kod') {
            echo "<pre>" . htmlspecialchars($row['icerik']) . "</pre>";
        } else if ($row['tur'] == 'zip' && !empty($row['dosya_adi'])) {
            echo "<div class='zip-link'><a href='uploads/{$row['dosya_adi']}' download>ZIP Dosyasını İndir</a></div>";
        }
        echo "</div>";
    }
}
?>
