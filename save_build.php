<?php
session_start();
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $_SESSION['user'];

$stmt = $conn->prepare("
    INSERT INTO builds (title, cpu, mb, gpu, ram, ssd, hdd, power, username)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $data['title'],
    $data['cpu'],
    $data['mb'],
    $data['gpu'],
    $data['ram'],
    $data['ssd'],
    $data['hdd'],
    $data['power'],
    $username
]);

echo "저장 완료!";
?>
