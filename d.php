<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = @new mysqli("localhost", "root", "", "101m");
if ($mysqli->connect_error) die("Veritabanı bağlantı hatası: " . $mysqli->connect_error);

function safe_get($key) {
    return $_GET[$key] ?? '';
}

function escape($mysqli, $value) {
    return $mysqli->real_escape_string($value);
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

$results = [];

$adi = safe_get('adi'); $soyadi = safe_get('soyadi'); $il = safe_get('il'); $ilce = safe_get('ilce'); $dogumyil = safe_get('dogumyil');
if ($adi || $soyadi || $il || $ilce || $dogumyil) {
    $mysqli->select_db("101m");
    $conditions = [];
    if ($adi) $conditions[] = "`ADI` LIKE '%" . escape($mysqli, $adi) . "%'";
    if ($soyadi) $conditions[] = "`SOYADI` LIKE '%" . escape($mysqli, $soyadi) . "%'";
    if ($il) $conditions[] = "`NUFUSIL` LIKE '%" . escape($mysqli, $il) . "%'";
    if ($ilce) $conditions[] = "`NUFUSILCE` LIKE '%" . escape($mysqli, $ilce) . "%'";
    if ($dogumyil) $conditions[] = "RIGHT(`DOGUMTARIHI`, 4) = '" . escape($mysqli, $dogumyil) . "'";
    $sql = "SELECT * FROM `101m` WHERE " . implode(" AND ", $conditions) . " LIMIT 100";
    $res = $mysqli->query($sql);
    if ($res) while ($r = $res->fetch_assoc()) $results['101m'][] = $r;
}

$tcpro = safe_get('tcpro');
if ($tcpro !== '') {
    $mysqli->select_db("109mtcpro");
    $q = escape($mysqli, $tcpro);
    $sql = "SELECT * FROM `109mtcpro` WHERE `TC` LIKE '%$q%' OR `AD` LIKE '%$q%' LIMIT 50";
    $res = $mysqli->query($sql);
    if ($res) while ($r = $res->fetch_assoc()) $results['109mtcpro'][] = $r;
}

$gsm = safe_get('gsm');
if ($gsm !== '') {
    $mysqli->select_db("195mgsm");
    $q = escape($mysqli, $gsm);
    $sql = "SELECT * FROM `195mgsm` WHERE `GSM` LIKE '%$q%' OR `TC` LIKE '%$q%' LIMIT 50";
    $res = $mysqli->query($sql);
    if ($res) while ($r = $res->fetch_assoc()) $results['195mgsm'][] = $r;
}

$adres = safe_get('adres');
if ($adres !== '') {
    $mysqli->select_db("83madres");
    $q = escape($mysqli, $adres);
    $sql = "SELECT * FROM `83madres` WHERE `KimlikNo` LIKE '%$q%' OR `VergiNumarasi` LIKE '%$q%' OR `Ikametgah` LIKE '%$q%' LIMIT 50";
    $res = $mysqli->query($sql);
    if ($res) while ($r = $res->fetch_assoc()) $results['83madres'][] = $r;
}

$mtapu = safe_get('mtapu');
if ($mtapu !== '') {
    $mysqli->select_db("97mtapu");
    $q = escape($mysqli, $mtapu);
    $sql = "SELECT * FROM `97mtapu` WHERE `Identify` LIKE '%$q%' OR `Name` LIKE '%$q%' OR `Surname` LIKE '%$q%' LIMIT 50";
    $res = $mysqli->query($sql);
    if ($res) while ($r = $res->fetch_assoc()) $results['97mtapu'][] = $r;
}

$tc = safe_get('tc');
$rows_tree = [];
if ($tc !== '') {
    $mysqli->select_db("101m");
    function getTree($mysqli, $tc, &$visited = [], $level = 0, $relation = 'Kendisi') {
        if (in_array($tc, $visited)) return [];
        $visited[] = $tc;
        $results = [];

        $escapedTC = $mysqli->real_escape_string($tc);
        $res = $mysqli->query("SELECT * FROM `101m` WHERE `TC` = '$escapedTC' LIMIT 1");
        if (!$res || !$res->num_rows) return [];
        $person = $res->fetch_assoc();
        $person['ILIŞKI'] = $relation;
        $results[] = $person;

        $anneTC = $person['ANNETC'];
        $babaTC = $person['BABATC'];

        if ($anneTC) $results = array_merge($results, getTree($mysqli, $anneTC, $visited, $level + 1, 'Anne Tarafı'));
        if ($babaTC) $results = array_merge($results, getTree($mysqli, $babaTC, $visited, $level + 1, 'Baba Tarafı'));

        $children = $mysqli->query("SELECT * FROM `101m` WHERE `ANNETC` = '$escapedTC' OR `BABATC` = '$escapedTC'");
        if ($children) while ($c = $children->fetch_assoc()) {
            if ($c['TC'] != $tc) {
                $c['ILIŞKI'] = 'Cocugu';
                $results[] = $c;
            }
        }
        return $results;
    }
    $rows_tree = getTree($mysqli, $tc);
}

$mysqli->close();
?><!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>RUON PANEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="text-center mb-4">RUON PANEL</h2>
    <form method="get" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3"><input type="text" name="adi" placeholder="Adı" class="form-control"></div>
            <div class="col-md-3"><input type="text" name="soyadi" placeholder="Soyadı" class="form-control"></div>
            <div class="col-md-2"><input type="text" name="il" placeholder="İl" class="form-control"></div>
            <div class="col-md-2"><input type="text" name="ilce" placeholder="İlçe" class="form-control"></div>
            <div class="col-md-2"><input type="text" name="dogumyil" placeholder="Doğum Yılı" class="form-control"></div>
        </div>
        <div class="row g-2 mt-2">
            <div class="col-md-3"><input type="text" name="tcpro" placeholder="TC Pro" class="form-control"></div>
            <div class="col-md-3"><input type="text" name="gsm" placeholder="GSM / TC" class="form-control"></div>
            <div class="col-md-3"><input type="text" name="adres" placeholder="Adres / TC / Vergi" class="form-control"></div>
            <div class="col-md-3"><input type="text" name="mtapu" placeholder="Tapu / TC / Ad" class="form-control"></div>
        </div>
        <div class="row g-2 mt-2">
            <div class="col-md-6"><input type="text" name="tc" placeholder="Soy Ağacı TC" class="form-control"></div>
            <div class="col-md-6"><button class="btn btn-primary w-100">Sorgula</button></div>
        </div>
    </form>
<?php
foreach ($results as $source => $rows) {
    echo "<h4 class='mt-4'>$source</h4>";
    echo renderTable($rows);
}
if (!empty($rows_tree)) {
    echo "<h4 class='mt-4'>Soy Ağacı</h4>";
    echo renderTable($rows_tree);
}
?>
</div>
</body>
</html>