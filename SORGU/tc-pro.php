<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost", "root", "", "101m");
if ($mysqli->connect_error) die("Veritabanı hatası: " . $mysqli->connect_error);

$tc = $_GET['tc'] ?? '';
$results = [];

if ($tc && preg_match('/^\d{11}$/', $tc)) {
    $tc = $mysqli->real_escape_string($tc);
    $query = "SELECT * FROM `101m` WHERE `TC` = '$tc' LIMIT 1";
    $res = $mysqli->query($query);
    if ($res && $res->num_rows > 0) $results = $res->fetch_assoc();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>TC Pro Sorgu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background: #1e1e1e; color: #0f0; font-family: monospace; }
        .container { margin-left: 240px; padding: 20px; }
        .sidebar {
            background: #111;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            width: 220px;
            padding: 15px;
        }
        .sidebar a {
            display: block;
            padding: 8px;
            color: #ccc;
            text-decoration: none;
            border-bottom: 1px solid #333;
        }
        .sidebar a:hover {
            background: #333;
            color: white;
        }
        .result-box {
            background: black;
            color: #0f0;
            padding: 15px;
            border: 1px solid #0f0;
            margin-top: 20px;
            white-space: pre-wrap;
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
    <h2>🧠 TC Pro Sorgu</h2>
    <form method="get" class="row g-2 mb-4" autocomplete="off">
        <div class="col-md-6">
            <input name="tc" class="form-control" placeholder="TC Kimlik No (11 haneli)" required pattern="\d{11}" value="<?= htmlspecialchars($tc) ?>" />
        </div>
        <div class="col-md-6">
            <button class="btn btn-success w-100">🚀 Sorgula</button>
        </div>
    </form>

    <?php if (!empty($results)): ?>
        <div class="result-box">
<?php
foreach ($results as $key => $val) {
    echo strtoupper($key) . ": " . htmlspecialchars($val) . "\n";
}
?>
        </div>
    <?php elseif ($tc): ?>
        <div class="alert alert-danger">❌ TC bulunamadı veya geçersiz.</div>
    <?php endif; ?>
</div>

</body>
</html>
