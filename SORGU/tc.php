<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli("localhost", "root", "", "101m");
if ($mysqli->connect_error) die("Veritabanı hatası");

$tc = $_GET['tc'] ?? '';
$results = [];

if ($tc && preg_match('/^[0-9]{11}$/', $tc)) {
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
    <meta charset="UTF-8">
    <title>TC ile Sorgu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="sidebar">
    <h3>📂 KATEGORİLER</h3>
    <?php include 'TC/kategori.php'; ?>
    <?php foreach ($kategoriler as $kategori): ?>
        <a href="<?= htmlspecialchars($kategori['url']) ?>">
            <?= htmlspecialchars($kategori['label']) ?>
        </a>
    <?php endforeach; ?>
</div>


<div class="container">
    <h2>🆔 TC ile Sorgu</h2>
    <form method="get" class="row g-2 mb-4">
        <div class="col-md-6">
            <input name="tc" class="form-control" placeholder="TC Kimlik No (11 haneli)" required pattern="\d{11}">
        </div>
        <div class="col-md-6">
            <button class="btn btn-success w-100">🚀 Sorgula</button>
        </div>
    </form>

    <?php if (!empty($results)): ?>
        <div class="result-box">
<?php
foreach ($results as $key => $val) {
    echo strtoupper($key) . ": " . $val . "\n";
}
?>
        </div>
    <?php elseif ($tc): ?>
        <div class="alert alert-danger">❌ TC bulunamadı veya geçersiz.</div>
    <?php endif; ?>
</div>

</body>
</html>
