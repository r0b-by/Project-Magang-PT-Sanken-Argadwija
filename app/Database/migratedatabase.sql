-- Migration Users Table --
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    role ENUM('admin','user') DEFAULT 'user',
    departement VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Migration ISO 00 Products Table --
CREATE TABLE iso_00 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_dokumen VARCHAR(50) NOT NULL UNIQUE,   -- Kode unik dokumen
    tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Tanggal upload otomatis
    departement VARCHAR(100) NOT NULL,          -- Departement
    nama_file VARCHAR(255) NOT NULL,            -- Nama file PDF
    keterangan TEXT,                             -- Catatan tambahan
    status ENUM('save','revisi') DEFAULT 'save', -- Status dokumen
    user_update VARCHAR(100),                    -- User terakhir update
    jam_update TIME DEFAULT CURRENT_TIME,       -- Jam update
    tanggal_update DATE DEFAULT CURRENT_DATE    -- Tanggal update
);

-- Migration ISO 01 Products Table --
CREATE TABLE iso_001 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    iso_00_id INT NOT NULL,                      -- Relasi ke tabel Header
    kode_dokumen VARCHAR(50) NOT NULL,          -- Salinan kode dokumen
    versi INT DEFAULT 1,                         -- Versi dokumen
    nama_file VARCHAR(255) NOT NULL,            -- File PDF revisi
    keterangan TEXT,                             -- Catatan revisi
    status ENUM('save','revisi') DEFAULT 'save',
    user_update VARCHAR(100),
    jam_update TIME DEFAULT CURRENT_TIME,
    tanggal_update DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (iso_00_id) REFERENCES iso_00(id) ON DELETE CASCADE
);
