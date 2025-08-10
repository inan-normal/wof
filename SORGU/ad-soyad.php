<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost", "root", "", "101m");
if ($mysqli->connect_error) die("Veritabanı bağlantı hatası: " . $mysqli->connect_error);

function get($key) {
    return isset($_GET[$key]) ? trim($_GET[$key]) : '';
}

$adi      = get("adi");
$soyadi   = get("soyadi");
$il       = get("il");
$ilce     = get("ilce");
$anneadi  = get("anneadi");
$babaadi  = get("babaadi");

$results = [];
$hata = '';

if ($_GET) {
    if (!$adi || !$soyadi) {
        $hata = "Ad ve Soyad zorunludur!";
    } else {
        $where = [];
        $where[] = "ADI LIKE '" . $mysqli->real_escape_string($adi) . "%'";
        $where[] = "SOYADI LIKE '" . $mysqli->real_escape_string($soyadi) . "%'";

        if (!empty($il)) {
            $where[] = "NUFUSIL LIKE '" . $mysqli->real_escape_string($il) . "%'";
        }
        if (!empty($ilce))    $where[] = "NUFUSILCE LIKE '" . $mysqli->real_escape_string($ilce) . "%'";
        if (!empty($anneadi)) $where[] = "ANNEADI LIKE '" . $mysqli->real_escape_string($anneadi) . "%'";
        if (!empty($babaadi)) $where[] = "BABAADI LIKE '" . $mysqli->real_escape_string($babaadi) . "%'";

        $sql = "SELECT * FROM 101m WHERE " . implode(" AND ", $where) . " LIMIT 10000";
        $res = $mysqli->query($sql);

        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $results[] = $row;
            }
            if (count($results) === 0) {
                $hata = "Sonuç bulunamadı.";
            }
        } else {
            $hata = "Sorgu hatası: " . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>CMD Ad Soyad Sorgu</title>
    <style>
        body {
            margin: 0; padding: 0;
            background: black;
            color: #00FF00;
            font-family: monospace;
            display: flex;
        }

        .container {
            flex-grow: 1;
            padding: 30px;
        }
        input, button {
            background-color: #111;
            color: #00FF00;
            border: 1px solid #00FF00;
            padding: 6px;
            font-family: monospace;
            margin: 4px;
            font-size: 16px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #00FF00;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #111;
        }
        .form-row {
            margin-bottom: 10px;
        }
        .error {
            color: yellow;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h3>📂 KATEGORİLER</h3>
    <?php include 'AD/kategori.php'; ?>
    <?php foreach ($kategoriler as $kategori): ?>
        <a href="<?= htmlspecialchars($kategori['url']) ?>">
            <?= htmlspecialchars($kategori['label']) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="container">
    <h2>📋 Ad Soyad Sorgulama</h2>
    <form method="get">
        <div class="form-row">
            Ad <input type="text" name="adi" value="<?= htmlspecialchars($adi ?? '') ?>" required>
            Soyad <input type="text" name="soyadi" value="<?= htmlspecialchars($soyadi ?? '') ?>" required>
            İl <input type="text" name="il" value="<?= htmlspecialchars($il ?? '') ?>">
        </div>
        <div class="form-row">
            İlçe <input type="text" name="ilce" value="<?= htmlspecialchars($ilce ?? '') ?>">
            Anne Adı <input type="text" name="anneadi" value="<?= htmlspecialchars($anneadi ?? '') ?>">
            Baba Adı <input type="text" name="babaadi" value="<?= htmlspecialchars($babaadi ?? '') ?>">
        </div>
        <button type="submit">🚀 Sorgula</button>
    </form>

    <?php if ($hata): ?>
        <div class="error"><?= htmlspecialchars($hata) ?></div>
    <?php elseif ($results): ?>
        <table>
            <tr>
                <?php foreach (array_keys($results[0]) as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <?php foreach ($row as $val): ?>
                        <td><?= htmlspecialchars($val ?? '') ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
