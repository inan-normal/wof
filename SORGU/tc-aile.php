<?php
$mysqli = new mysqli("localhost", "root", "", "101m");
if ($mysqli->connect_error) die("Veritabanı bağlantı hatası: " . $mysqli->connect_error);

function escape($db, $val) {
    return $db->real_escape_string(trim($val));
}

$tc = $_GET['tc'] ?? '';
$results = [];

if ($tc !== '' && preg_match('/^\d{11}$/', $tc)) {
    $q = escape($mysqli, $tc);

    $queries = [
        "SELECT *, 'Kendisi' AS ILIŞKI FROM 101m WHERE TC = '$q'",
        "SELECT *, 'Annesi' AS ILIŞKI FROM 101m WHERE TC = (SELECT ANNETC FROM 101m WHERE TC = '$q')",
        "SELECT *, 'Babası' AS ILIŞKI FROM 101m WHERE TC = (SELECT BABATC FROM 101m WHERE TC = '$q')",
        "SELECT *, 'Kardeşi' AS ILIŞKI FROM 101m 
         WHERE TC != '$q' AND 
               ANNETC = (SELECT ANNETC FROM 101m WHERE TC = '$q') AND
               BABATC = (SELECT BABATC FROM 101m WHERE TC = '$q')
         LIMIT 50",
        "SELECT *, 'Çocuğu' AS ILIŞKI FROM 101m 
         WHERE ANNETC = '$q' OR BABATC = '$q'
         LIMIT 50"
    ];

    foreach ($queries as $sql) {
        $res = $mysqli->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $results[] = $row;
            }
        }
    }
}

function renderTable($rows) {
    if (empty($rows)) return "<p>Sonuç bulunamadı.</p>";
    $html = "<table class='table table-bordered table-dark table-sm'><thead><tr>";
    foreach (array_keys($rows[0]) as $key) {
        $html .= "<th>" . htmlspecialchars($key) . "</th>";
    }
    $html .= "</tr></thead><tbody>";
    foreach ($rows as $row) {
        $html .= "<tr>";
        foreach ($row as $val) {
            $html .= "<td>" . htmlspecialchars($val) . "</td>";
        }
        $html .= "</tr>";
    }
    $html .= "</tbody></table>";
    return $html;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>TC Aile Sorgu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: black;
            color: #00FF00;
            font-family: monospace;
            display: flex;
            margin: 0;
            height: 100vh;
        }
        .sidebar {
            background: #111;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            width: 220px;
            padding: 15px;
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
    overflow-y: auto;
}

.sidebar h4 {
    color: #00ff00;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
    margin-bottom: 25px;
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
    font-size: 15px;
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
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            margin-left: 220px;
        }
        input, button {
            background-color: #111;
            color: #00FF00;
            border: 1px solid #00FF00;
            font-family: monospace;
        }
        button:hover {
            background-color: #00FF00;
            color: black;
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
<div class="content container">
    <h2 class="mb-4">TC Aile Sorgu</h2>
    <form method="get" class="mb-3">
        <div class="row g-2">
            <div class="col-md-9">
                <input type="text" name="tc" placeholder="TC Girin" class="form-control" maxlength="11" value="<?= htmlspecialchars($tc) ?>">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-success w-100">Sorgula</button>
            </div>
        </div>
    </form>
    <?= renderTable($results) ?>
</div>

</body>
</html>
