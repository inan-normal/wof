<?php
// Sayfa adı dinamik olarak belirlenir
$currentPage = basename($_SERVER['PHP_SELF']);

// Python scriptini arka planda çalıştır (Linux/Unix için)
// NOT: 404 sayfa yönlendirmesini burada yapma, sadece 404 olduğunda yapılmalı
// Bu kod normal sayfa için, 404 sayfası için ayrı 404.php dosyası olmalı
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>WOLF İCRAAT - SORGU PANELİ</title>
    <style>
        /* Genel ayarlar */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            height: 100vh;
            background-color: #000;
            color: #0f0;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            overflow: hidden;
        }
        a {
            color: #0f0;
            text-decoration: none;
        }
        a:hover {
            color: #6f6;
        }

        /* Sol kategori paneli */
        .sidebar {
            width: 260px;
            background-color: #111;
            border-right: 2px solid #0f0;
            display: flex;
            flex-direction: column;
            padding: 10px 0;
            user-select: none;
        }
        .sidebar h2 {
            padding-left: 20px;
            font-weight: normal;
            font-size: 1.5rem;
            margin: 0 0 15px 0;
            border-bottom: 2px solid #0f0;
            padding-bottom: 10px;
        }
        .sidebar a {
            padding: 12px 20px;
            border-bottom: 1px solid #0f0;
            display: block;
            transition: background-color 0.2s ease;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #0f0;
            color: #000;
            font-weight: bold;
        }

        /* Ana içerik alanı */
        .content {
            flex-grow: 1;
            padding: 20px 30px;
            overflow-y: auto;
            white-space: pre-wrap;
            background-color: #000;
            border-left: 2px solid #0f0;
            font-size: 1.1rem;
            line-height: 1.4;
        }

        /* Scrollbar - koyu tema uyumlu */
        .content::-webkit-scrollbar {
            width: 10px;
        }
        .content::-webkit-scrollbar-track {
            background: #111;
        }
        .content::-webkit-scrollbar-thumb {
            background-color: #0f0;
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: #111;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #0f0;
            border-radius: 10px;
        }

        /* Responsive küçültme */
        @media(max-width: 700px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 2px solid #0f0;
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
            }
            .sidebar h2 {
                display: none;
            }
            .sidebar a {
                border-bottom: none;
                border-right: 1px solid #0f0;
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            .content {
                border-left: none;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <h2>📂 KATEGORİLER</h2>
      <a href="/FREE/giriş.php"       class="<?= $currentPage === '//FREE/giriş.php' ? 'active' : '' ?>">😊 FREE DAĞITIM</a>
      <a href="/SORGU/sorgu.php"       class="<?= $currentPage === '/SORGU/sorgu.php' ? 'active' : '' ?>">👤 Sorgu paneli</a>
      <a href="/SMS/sms.php"       class="<?= $currentPage === '/SMS/sms.php' ? 'active' : '' ?>">💬  Sms paneli</a>
      <a href="/DISCORD/discord.php"       class="<?= $currentPage === '/DISCORD/discord.php' ? 'active' : '' ?>">🤖 Discord Bot</a>
    </nav>

    <main class="content">
        <h1>WOLF İCRAAT</h1>
        <p>Hoş geldin, aşağıdan sorgu tipini seçebilirsin.</p>
        <p>Bu sayfada bir sorgu seçilmedi. Lütfen soldan kategori seçin.</p>
    </main>

</body>
</html>
