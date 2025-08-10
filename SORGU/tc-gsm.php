<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost", "root", "", "195mgsm");
if ($mysqli->connect_error) die("Veritabanı bağlantı hatası: " . $mysqli->connect_error);

function escape($mysqli, $value) {
    return $mysqli->real_escape_string($value);
}

function renderTable($rows) {
    if (count($rows) === 0) return '<p class="text-muted">Sonuç bulunamadı.</p>';
    $html = "<div class='table-responsive'><table class='table table-bordered table-sm'><thead><tr>";
    foreach (array_keys($rows[0]) as $col) {
        $html .= "<th>" . htmlspecialchars($col) . "</th>";
    }
    $html .= "</tr></thead><tbody>";
    foreach ($rows as $row) {
        $html .= "<tr>";
        foreach ($row as $val) {
            $html .= "<td>" . htmlspecialchars($val) . "</td>";
        }
        $html .= "</tr>";
    }
    $html .= "</tbody></table></div>";
    return $html;
}

$results = [];
$error = '';
$q = trim($_GET['q'] ?? '');

if ($q !== '') {
    if (!preg_match('/^\d+$/', $q)) {
        $error = "Lütfen sadece rakam giriniz.";
    } else {
        $q_esc = escape($mysqli, $q);
        // TC alanına göre sorgulama, GSM bilgisini getir
        $sql = "SELECT TC, GSM FROM `195mgsm` WHERE `TC` LIKE '$q_esc%' LIMIT 50";
        $res = $mysqli->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $results[] = $row;
            }
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>TC → GSM Sorgu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: monospace;
            padding: 20px;
        }
        table {
            color: #0f0;
        }
.sidebar {
    background: #111;
    position: fixed;
    top: 0; 
    left: 0;
    height: 100vh;
    width: 220px;
    padding: 20px 15px;
    box-shadow: 2px 0 8px rgba(0, 255, 0, 0.15);
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.sidebar a {
    display: block;
    padding: 10px 15px;
    color: #ccc;
    text-decoration: none;
    margin-bottom: 10px;
    border-radius: 4px;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.sidebar a:hover {
    background: #333;
    color: #fff;
}

.sidebar a:hover,
.sidebar a.active {
    background-color: #0f0;
    color: #000;
    border-left: 4px solid #000;
    font-weight: bold;
}

        .content {
            margin-left: 240px;
            padding: 10px 20px;
        }
        .error-message {
            color: #f00;
            font-weight: bold;
            margin-bottom: 10px;
            background: #300;
            padding: 8px;
            border-radius: 4px;
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
<div class="content">
    <h2>TC → GSM Sorgu</h2>
    <form method="get" class="mb-4" style="max-width:400px;">
        <div class="input-group">
            <input 
                type="text" 
                name="q" 
                placeholder="Sadece rakam girin (TC numarası)" 
                class="form-control" 
                value="<?= htmlspecialchars($q) ?>" 
                required 
                pattern="\d+" 
                inputmode="numeric"
                title="Lütfen sadece rakam giriniz."
            />
            <button class="btn btn-success">Sorgula</button>
        </div>
    </form>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?= renderTable($results) ?>
</div>

</body>
</html>
