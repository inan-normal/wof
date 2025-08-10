
    <div class="sidebar">
        <h3>📂 KATEGORİLER</h3>
        <a href="/index.php">🔙 Ana Sayfa</a>
        <a href="discord.php">🔙 Ana Panel</a>
        <a href="/DISCORD/server.php">🤖 Discord Sunucu Nukleer</a>
        <a href="/DISCORD/dm.php">🤖 Discord Dm Nukleer</a>
    </div>
    <style>
        body {
            background-color: black;
            color: #00FF00;
            font-family: monospace;
            margin: 0;
            display: flex;
        }
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
        .container {
            flex-grow: 1;
            padding: 30px;
        }
        input, button {
            background-color: #111;
            color: #00FF00;
            border: 1px solid #00FF00;
            padding: 8px;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
            font-family: monospace;
            border-radius: 4px;
        }
        button {
            cursor: pointer;
        }
        pre {
            background-color: #111;
            border: 1px solid #00FF00;
            padding: 15px;
            white-space: pre-wrap;
            margin-top: 20px;
        }
        .error {
            color: yellow;
            margin-top: 10px;
        }
        .success {
            color: #0f0;
            margin-top: 10px;
            word-break: break-all;
        }
    </style>