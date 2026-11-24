<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Bucket.php';
require_once __DIR__ . '/../classes/DailyLog.php';
require_once __DIR__ . '/../classes/Helper.php';

$db = (new Database())->getConnection();
$bucketModel = new Bucket($db);
$logModel = new DailyLog($db);

$buckets = $bucketModel->getAll();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$log = $id > 0 ? $logModel->findById($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($log) {
        $logModel->update($id, $_POST);
    } else {
        $logModel->create($_POST);
    }
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $log ? 'Edit' : 'Tambah' ?> Catatan Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">
            <?= $log ? 'Edit Catatan Harian' : 'Tambah Catatan Harian' ?>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Pilih Unit Ember</label>
                    <select name="bucket_id" class="form-select" required>
                        <?php foreach ($buckets as $b): ?>
                            <option value="<?= (int) $b['id'] ?>"
                                <?= ((int) ($log['bucket_id'] ?? 0) === (int) $b['id']) ? 'selected' : '' ?>>
                                <?= Helper::clean($b['kode_ember']) ?> - <?= Helper::clean($b['jenis_ikan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pencatatan</label>
                    <input type="date" name="tanggal_catat" class="form-control" required
                           value="<?= Helper::clean($log['tanggal_catat'] ?? date('Y-m-d')) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Pakan (Gram)</label>
                    <input type="number" name="pakan_gram" class="form-control" required
                           value="<?= (int) ($log['pakan_gram'] ?? 40) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Ikan Mati (Ekor)</label>
                    <input type="number" name="ikan_mati" class="form-control" required
                           value="<?= (int) ($log['ikan_mati'] ?? 0) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kondisi Air</label>
                    <select name="kondisi_air" class="form-select" required>
                        <?php foreach (['Jernih', 'Keruh Ringan', 'Berbau/Pekat'] as $opsi): ?>
                            <option value="<?= $opsi ?>" <?= (($log['kondisi_air'] ?? '') === $opsi) ? 'selected' : '' ?>>
                                <?= $opsi ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tinggi Tanaman (cm)</label>
                    <input type="number" step="0.1" name="tinggi_tanaman_cm" class="form-control" required
                           value="<?= (float) ($log['tinggi_tanaman_cm'] ?? 15.0) ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>