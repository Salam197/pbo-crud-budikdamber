<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Bucket.php';
require_once __DIR__ . '/../classes/DailyLog.php';

$type = $_GET['type'] ?? '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $db = (new Database())->getConnection();

    if ($type === 'bucket') {
        (new Bucket($db))->delete($id);
    } elseif ($type === 'log') {
        (new DailyLog($db))->delete($id);
    }
}

header('Location: index.php');
exit;