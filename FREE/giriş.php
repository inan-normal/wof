<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: ana.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $validUsers = [
        'admin' => '123',
        'free' => '123'
    ];

    if (isset($validUsers[$username]) && $validUsers[$username] === $password) {
        $_SESSION['user'] = $username;
        header("Location: ana.php");
        exit;
    } else {
        $error = "Kullanıcı adı veya şifre hatalı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Giriş Yap - Site</title>
<style>
    body { background:#121212; color:#eee; font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; }
    form { background:#222; padding:20px; border-radius:8px; width:300px; }
    input { width:100%; padding:10px; margin:10px 0; border:none; border-radius:5px; background:#333; color:#0f0; font-family: monospace; }
    button { background:#0f0; border:none; padding:10px; border-radius:5px; width:100%; cursor:pointer; font-weight:bold; color:#000; }
    .error { color:#f33; text-align:center; }
</style>
</head>
<body>

<form method="post" autocomplete="off">
    <h2 style="text-align:center;">Giriş Yap</h2>
    <input type="text" name="username" placeholder="Kullanıcı Adı" required autofocus />
    <input type="password" name="password" placeholder="Şifre" required />
    <button type="submit">Giriş</button>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
</form>

</body>
</html>
