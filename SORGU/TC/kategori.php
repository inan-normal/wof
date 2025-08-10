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
<style>           body { background: #1e1e1e; color: #0f0; font-family: monospace; }
       
        .result-box {
            background: black;
            color: #0f0;
            padding: 15px;
            border: 1px solid #0f0;
            margin-top: 20px;
            white-space: pre-wrap;
        }
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
    padding-left: 15px;  }


    .container {
        margin-left: 240px;
        padding: 30px;
        flex-grow: 1;
    }

    h2 {
        margin-top: 0;
    }

    input, button {
        background-color: #111;
        color: #00FF00;
        border: 1px solid #00FF00;
        padding: 9px;
        font-family: monospace;
        margin: 4px;
        font-size: 16px;
    }

    .form-row {
        margin-bottom: 10px;
    }

    button {
        cursor: pointer;
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

    .error {
        color: yellow;
        margin-top: 10px;
    }

</style>