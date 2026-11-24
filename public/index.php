<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Bucket.php';
require_once __DIR__ . '/../classes/DailyLog.php';
require_once __DIR__ . '/../classes/Helper.php';

$db = (new Database())->getConnection();
$buckets = (new Bucket($db))->getAll();
$logs = (new DailyLog($db))->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Budikdamber OOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3 class="mb-4 fw-bold text-success">Sistem Monitoring Budikdamber & Akuaponik</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">1. Daftar Unit Ember (Tabel Induk)</span>
            <a href="ember_form.php" class="btn btn-sm btn-success">+ Tambah Ember</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Kapasitas</th>
                        <th>Jenis Ikan</th>
                        <th>Tebar</th>
                        <th>Tanaman Atas</th>
                        <th>Tgl Tebar</th>
                        <th>Total Log</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($buckets as $b): ?>
                    <tr>
                        <td><strong><?= Helper::clean($b['kode_ember']) ?></strong></td>
                        <td><?= (int) $b['kapasitas_liter'] ?> L</td>
                        <td><?= Helper::clean($b['jenis_ikan']) ?></td>
                        <td><?= (int) $b['jumlah_tebar'] ?> ekor</td>
                        <td><?= Helper::clean($b['tanaman_atas']) ?></td>
                        <td><?= Helper::clean($b['tanggal_tebar']) ?></td>
                        <td><span class="badge bg-secondary"><?= (int) $b['total_log'] ?> catatan</span></td>
                        <td>
                            <a href="ember_form.php?id=<?= (int) $b['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus.php?type=bucket&id=<?= (int) $b['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus ember ini beserta seluruh catatan hariannya?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">2. Catatan Harian Pemeliharaan (Relasi Foreign Key)</span>
            <a href="log_form.php" class="btn btn-sm btn-primary">+ Tambah Catatan</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Unit Ember & Ikan</th>
                        <th>Tanaman</th>
                        <th>Pakan</th>
                        <th>Mati</th>
                        <th>Kondisi Air</th>
                        <th>Tinggi Tanaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $l): ?>
                    <tr>
                        <td><?= Helper::clean($l['tanggal_catat']) ?></td>
                        <td><?= Helper::clean($l['kode_ember']) ?> - <?= Helper::clean($l['jenis_ikan']) ?></td>
                        <td><?= Helper::clean($l['tanaman_atas']) ?></td>
                        <td><?= (int) $l['pakan_gram'] ?> gr</td>
                        <td><?= (int) $l['ikan_mati'] ?> ekor</td>
                        <td>
                            <span class="badge bg-<?= Helper::statusAirColor($l['kondisi_air']) ?>">
                                <?= Helper::clean($l['kondisi_air']) ?>
                            </span>
                        </td>
                        <td><?= number_format((float) $l['tinggi_tanaman_cm'], 1) ?> cm</td>
                        <td>
                            <a href="log_form.php?id=<?= (int) $l['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus.php?type=log&id=<?= (int) $l['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus catatan harian ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>