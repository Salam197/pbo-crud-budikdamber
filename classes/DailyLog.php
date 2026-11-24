<?php

require_once __DIR__ . '/BaseModel.php';

class DailyLog extends BaseModel
{
    protected string $table = 'daily_logs';

    public function getAll(): array
    {
        $sql = "SELECT d.*, b.kode_ember, b.jenis_ikan, b.tanaman_atas
                FROM {$this->table} d
                INNER JOIN buckets b ON d.bucket_id = b.id
                ORDER BY d.tanggal_catat DESC, d.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (bucket_id, tanggal_catat, pakan_gram, ikan_mati, kondisi_air, tinggi_tanaman_cm)
                VALUES (:bucket_id, :tanggal_catat, :pakan_gram, :ikan_mati, :kondisi_air, :tinggi_tanaman_cm)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'bucket_id' => (int) $data['bucket_id'],
            'tanggal_catat' => $data['tanggal_catat'],
            'pakan_gram' => (int) $data['pakan_gram'],
            'ikan_mati' => (int) $data['ikan_mati'],
            'kondisi_air' => $data['kondisi_air'],
            'tinggi_tanaman_cm' => (float) $data['tinggi_tanaman_cm'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET bucket_id = :bucket_id,
                    tanggal_catat = :tanggal_catat,
                    pakan_gram = :pakan_gram,
                    ikan_mati = :ikan_mati,
                    kondisi_air = :kondisi_air,
                    tinggi_tanaman_cm = :tinggi_tanaman_cm
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'bucket_id' => (int) $data['bucket_id'],
            'tanggal_catat' => $data['tanggal_catat'],
            'pakan_gram' => (int) $data['pakan_gram'],
            'ikan_mati' => (int) $data['ikan_mati'],
            'kondisi_air' => $data['kondisi_air'],
            'tinggi_tanaman_cm' => (float) $data['tinggi_tanaman_cm'],
        ]);
    }
}