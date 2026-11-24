<?php

require_once __DIR__ . '/BaseModel.php';

class Bucket extends BaseModel
{
    protected string $table = 'buckets';

    public function getAll(): array
    {
        $sql = "SELECT b.*, COUNT(d.id) AS total_log
                FROM {$this->table} b
                LEFT JOIN daily_logs d ON b.id = d.bucket_id
                GROUP BY b.id
                ORDER BY b.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (kode_ember, kapasitas_liter, jenis_ikan, jumlah_tebar, tanaman_atas, tanggal_tebar)
                VALUES (:kode_ember, :kapasitas_liter, :jenis_ikan, :jumlah_tebar, :tanaman_atas, :tanggal_tebar)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'kode_ember' => $data['kode_ember'],
            'kapasitas_liter' => (int) $data['kapasitas_liter'],
            'jenis_ikan' => $data['jenis_ikan'],
            'jumlah_tebar' => (int) $data['jumlah_tebar'],
            'tanaman_atas' => $data['tanaman_atas'],
            'tanggal_tebar' => $data['tanggal_tebar'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET kode_ember = :kode_ember,
                    kapasitas_liter = :kapasitas_liter,
                    jenis_ikan = :jenis_ikan,
                    jumlah_tebar = :jumlah_tebar,
                    tanaman_atas = :tanaman_atas,
                    tanggal_tebar = :tanggal_tebar
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'kode_ember' => $data['kode_ember'],
            'kapasitas_liter' => (int) $data['kapasitas_liter'],
            'jenis_ikan' => $data['jenis_ikan'],
            'jumlah_tebar' => (int) $data['jumlah_tebar'],
            'tanaman_atas' => $data['tanaman_atas'],
            'tanggal_tebar' => $data['tanggal_tebar'],
        ]);
    }
}