<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: giriş.php");
    exit;
}

// Buraya free.php veya admin.php kodları gelecek
?>

<?php
// db.php (önce bu dahil edilecek)
include 'db.php';

if (isset($_POST['save_code'])) {
    $kategori = $_POST['kategori'];
    $baslik = $_POST['baslik'];
    $kod = $_POST['kod'];

    // Kod ekle
    $stmt = $conn->prepare("INSERT INTO kodlar (kategori, baslik, icerik, tur) VALUES (?, ?, ?, 'kod')");
    $stmt->bind_param("sss", $kategori, $baslik, $kod);
    $stmt->execute();
    $stmt->close();
    echo "<p style='color:green;'>Kod başarıyla kaydedildi.</p>";
}

if (isset($_POST['upload_zip'])) {
    $kategori = $_POST['kategori'];
    $baslik = $_POST['baslik'];

    if (isset($_FILES['zip_file']) && $_FILES['zip_file']['error'] == 0) {
        $zip_name = time() . "_" . basename($_FILES['zip_file']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $zip_name;

        if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO kodlar (kategori, baslik, dosya_adi, tur) VALUES (?, ?, ?, 'zip')");
            $stmt->bind_param("sss", $kategori, $baslik, $zip_name);
            $stmt->execute();
            $stmt->close();
            echo "<p style='color:green;'>Zip dosyası başarıyla yüklendi.</p>";
        } else {
            echo "<p style='color:red;'>Zip dosyası yüklenirken hata oluştu.</p>";
        }
    } else {
        echo "<p style='color:red;'>Lütfen geçerli bir zip dosyası seçin.</p>";
    }
}
?>

<style>
    body { background: #121212; color: #eee; font-family: monospace; }
    label { display:block; margin-top:10px; }
    input[type=text], select, textarea {
        width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px;
        border: none; background: #222; color: #0f0;
        font-family: monospace; font-size: 14px;
    }
    textarea { height: 150px; resize: vertical; }
    button {
        margin-top: 15px; padding: 10px 20px; background: #0f0; color: #000; border: none; border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s;
    }
    button:hover { background: #0b0; }
    form { max-width: 600px; margin: 30px auto; background: #222; padding: 20px; border-radius: 10px; }
</style>

<form method="post" enctype="multipart/form-data">
    <label>Kategori:</label>
    <select name="kategori" required>
        <option value="">-- Kategori Seçin --</option>
        <option value="Python">Python</option>
        <option value="Html">Site</option>
        <option value="CMD">CMD</option>
        <option value="JavaScript">JavaScript</option>
        <option value="AOIJS">AOIJS</option>
        <option value="DİĞER">DİĞER</option>
    </select>

    <label>Başlık:</label>
    <input type="text" name="baslik" placeholder="Proje/Kod başlığı" required>

    <label>Kod Yaz (CMD görünüm):</label>
    <textarea name="kod" placeholder="Kodunuzu buraya yazabilirsiniz..."></textarea>

    <button type="submit" name="save_code">Kodu Kaydet</button>

    <hr style="border-color: #444; margin: 30px 0;">

    <label>Ya da Zip Dosyası Yükle:</label>
    <input type="file" name="zip_file" accept=".zip">

    <button type="submit" name="upload_zip">Zip Yükle</button>
</form>
