<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Bucket.php';
require_once __DIR__ . '/../classes/Helper.php';

$db = (new Database())->getConnection();
$bucketModel = new Bucket($db);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$ember = $id > 0 ? $bucketModel->findById($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($ember) {
        $bucketModel->update($id, $_POST);
    } else {
        $bucketModel->create($_POST);
    }
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $ember ? 'Edit' : 'Tambah' ?> Unit Ember</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">
            <?= $ember ? 'Edit Unit Ember' : 'Tambah Unit Ember Baru' ?>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Kode Ember</label>
                    <input type="text" name="kode_ember" class="form-control" required
                           value="<?= Helper::clean($ember['kode_ember'] ?? '') ?>" placeholder="Contoh: EMB-03">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kapasitas Ember (Liter)</label>
                    <input type="number" name="kapasitas_liter" class="form-control" required
                           value="<?= (int) ($ember['kapasitas_liter'] ?? 80) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Ikan</label>
                    <input type="text" name="jenis_ikan" class="form-control" required
                           value="<?= Helper::clean($ember['jenis_ikan'] ?? '') ?>" placeholder="Contoh: Lele Sangkuriang">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Tebar (Ekor)</label>
                    <input type="number" name="jumlah_tebar" class="form-control" required
                           value="<?= (int) ($ember['jumlah_tebar'] ?? 50) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanaman Akuaponik Atas</label>
                    <input type="text" name="tanaman_atas" class="form-control" required
                           value="<?= Helper::clean($ember['tanaman_atas'] ?? '') ?>" placeholder="Contoh: Kangkung">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Tebar</label>
                    <input type="date" name="tanggal_tebar" class="form-control" required
                           value="<?= Helper::clean($ember['tanggal_tebar'] ?? date('Y-m-d')) ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>