CREATE DATABASE IF NOT EXISTS db_budikdamber;
USE db_budikdamber;

CREATE TABLE buckets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_ember VARCHAR(20) NOT NULL UNIQUE,
    kapasitas_liter INT NOT NULL,
    jenis_ikan VARCHAR(50) NOT NULL,
    jumlah_tebar INT NOT NULL,
    tanaman_atas VARCHAR(60) NOT NULL,
    tanggal_tebar DATE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE daily_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bucket_id INT NOT NULL,
    tanggal_catat DATE NOT NULL,
    pakan_gram INT NOT NULL,
    ikan_mati INT NOT NULL DEFAULT 0,
    kondisi_air ENUM('Jernih', 'Keruh Ringan', 'Berbau/Pekat') NOT NULL DEFAULT 'Jernih',
    tinggi_tanaman_cm DECIMAL(5,2) NOT NULL,
    CONSTRAINT fk_bucket_log FOREIGN KEY (bucket_id)
        REFERENCES buckets(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO buckets (kode_ember, kapasitas_liter, jenis_ikan, jumlah_tebar, tanaman_atas, tanggal_tebar) VALUES
('EMB-01', 80, 'Lele Sangkuriang', 60, 'Kangkung Darat', '2026-11-01'),
('EMB-02', 100, 'Lele Dumbo', 75, 'Pakcoy Hijau', '2026-11-05');

INSERT INTO daily_logs (bucket_id, tanggal_catat, pakan_gram, ikan_mati, kondisi_air, tinggi_tanaman_cm) VALUES
(1, '2026-11-23', 45, 0, 'Jernih', 18.50),
(2, '2026-11-24', 60, 1, 'Keruh Ringan', 14.20);