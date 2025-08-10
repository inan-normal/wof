<?php
// 404 HTTP header gönder
http_response_code(404);
// Basit 404 sayfası içeriği
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>404 - Sayfa Bulunamadı</title>
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 4rem;
            margin: 0;
        }
        p {
            font-size: 1.5rem;
            margin-top: 10px;
        }
        a {
            color: #0f0;
            text-decoration: none;
            margin-top: 20px;
            font-size: 1.2rem;
        }
        a:hover {
            color: #6f6;
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Sayfa Bulunamadı.</p>
    <a href="/">Ana Sayfaya Dön</a>
</body>
</html>
