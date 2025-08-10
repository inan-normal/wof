CREATE TABLE kodlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(100),
    baslik VARCHAR(255),
    icerik TEXT NULL,
    dosya_adi VARCHAR(255) NULL,
    tur ENUM('kod', 'zip') NOT NULL DEFAULT 'kod',
    eklenme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Zip dosyaları tablosu: kategori, başlık ve dosya adı (upload edilen)
CREATE TABLE zipler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(50) NOT NULL,
    baslik VARCHAR(255) NOT NULL,
    dosya_adi VARCHAR(255) NOT NULL
);
