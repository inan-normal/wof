
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>CMD Ad Soyad Sorgu</title>
    <style>
   
.sidebar {
    background: #111;
    position: fixed;
    top: 0; 
    left: 0;
    height: 100vh;
    width: 220px;
    padding: 20px 15px;
    border-right: 2px solid #00ff00;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    overflow-y: auto;
}
.sidebar h3 {
    font-size: 20px;
    color: #00ff00;
    margin-bottom: 15px;
    border-bottom: 1px solid #00ff00;
    padding-bottom: 5px;
}

.sidebar a {
    display: block;
    color: #00ff00;
    text-decoration: none;
    margin: 10px 0;
    padding: 8px 10px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.sidebar a:hover {
    background-color: #00ff00;
    color: #0d0d0d;
    padding-left: 15px;
}</style>
</style>
    </style>
    <?php
$kategoriler = [
    ["label" => "🔙 Ana Sayfa", "url" => "/index.php"],
    ["label" => "🔙 Ana Panel", "url" => "sorgu.php"],
    ["label" => "👤 Ad Soyad", "url" => "ad-soyad.php"],
    ["label" => "👤 Ad Soyadsız", "url" => "ad-soyadsız.php"],
    ["label" => "🆔 TC Sorgu", "url" => "tc.php"],
    ["label" => "📱 GSM → TC", "url" => "gsm-tc.php"],
    ["label" => "🆔 TC → GSM", "url" => "tc-gsm.php"],
    ["label" => "🧠 TC Pro", "url" => "tc-pro.php"],
    ["label" => "👪 Aile Sorgu", "url" => "tc-aile.php"],
    ["label" => "👴🏻 Sülale", "url" => "tc-sulale.php"]
];
?>
</head>
<body>