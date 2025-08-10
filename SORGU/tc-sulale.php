<?php
// Hata gösterimini kapat
ini_set('display_errors', 0);
error_reporting(0);

$mysqli = new mysqli("localhost", "root", "", "101m");
if ($mysqli->connect_error) die("Veritabanı bağlantı hatası: " . $mysqli->connect_error);

function escape($mysqli, $value) {
    return $mysqli->real_escape_string(trim($value));
}

function renderTable($rows) {
    if (count($rows) === 0) return '<p class="text-muted">Sonuç bulunamadı.</p>';
    $html = "<div class='table-responsive'><table class='table table-bordered table-sm'><thead><tr>";
    foreach (array_keys($rows[0]) as $col) $html .= "<th>" . htmlspecialchars($col) . "</th>";
    $html .= "</tr></thead><tbody>";
    foreach ($rows as $row) {
        $html .= "<tr>";
        foreach ($row as $val) $html .= "<td>" . htmlspecialchars($val) . "</td>";
        $html .= "</tr>";
    }
    $html .= "</tbody></table></div>";
    return $html;
}

$tc = $_GET['tc'] ?? '';
$results = [];

if ($tc !== '' && preg_match('/^\d{11}$/', $tc)) {
    $visited = [];
    function getFamily($mysqli, $tc, &$visited = [], $level = 0, $relation = 'Kendisi') {
        if (in_array($tc, $visited)) return [];
        $visited[] = $tc;

        $results = [];

        $escaped = escape($mysqli, $tc);
        $res = $mysqli->query("SELECT * FROM `101m` WHERE `TC` = '$escaped' LIMIT 1");
        if (!$res || !$res->num_rows) return [];

        $person = $res->fetch_assoc();
        $person['İLİŞKİ'] = $relation;
        $results[] = $person;

        $anne = $person['ANNETC'];
        $baba = $person['BABATC'];

        if ($anne) $results = array_merge($results, getFamily($mysqli, $anne, $visited, $level + 1, 'Anne'));
        if ($baba) $results = array_merge($results, getFamily($mysqli, $baba, $visited, $level + 1, 'Baba'));

        $children = $mysqli->query("SELECT * FROM `101m` WHERE `ANNETC` = '$escaped' OR `BABATC` = '$escaped'");
        if ($children) while ($c = $children->fetch_assoc()) {
            if (!in_array($c['TC'], $visited)) {
                $c['İLİŞKİ'] = 'Çocuk';
                $visited[] = $c['TC'];
                $results[] = $c;
            }
        }

        return $results;
    }

    $results = getFamily($mysqli, $tc);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sülale Sorgusu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" /><style>
body {
    background-color: #000;
    color: #00ff00;
    font-family: monospace;
    margin: 0;
    padding: 0;
}


.content {
    margin-left: 240px;
    padding: 30px 20px;
}

h2, h4 {
    color: #00ff00;
    font-weight: bold;
}

table {
    color: #00ff00;
}

.text-muted {
    color: #777 !important;
}

input, button {
    background-color: #111;
    color: #00ff00;
    border: 1px solid #00ff00;
    font-family: monospace;
}

input::placeholder {
    color: #888;
}

button:hover {
    background-color: #00ff00;
    color: black;
    transition: 0.3s ease;
}

.table-responsive {
    overflow-x: auto;
}
</style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Kategori Sidebar -->

<div class="sidebar">
    <h3>📂 KATEGORİLER</h3>
    <?php include 'SÜLALE/kategori.php'; ?>
    <?php foreach ($kategoriler as $kategori): ?>
        <a href="<?= htmlspecialchars($kategori['url']) ?>">
            <?= htmlspecialchars($kategori['label']) ?>
        </a>
    <?php endforeach; ?>
</div>


        <!-- Ana içerik -->
        <div class="col-md-9 content">
            <h2>Sülale Sorgusu</h2>
            <form method="get" class="mb-4">
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" name="tc" placeholder="TC Kimlik No" class="form-control" maxlength="11" value="<?= htmlspecialchars($tc) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success w-100">Sorgula</button>
                    </div>
                </div>
            </form>

            <?= renderTable($results) ?>
        </div>
    </div>
</div>
</body>
</html>
