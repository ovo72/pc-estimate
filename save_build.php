<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    die("로그인이 필요합니다.");
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    die("잘못된 요청입니다.");
}

$user = $_SESSION['user'];

$stmt = $conn->prepare("
INSERT INTO builds 
(title, cpu, mb, gpu, ram, ssd, hdd, power, user)
VALUES 
(:title, :cpu, :mb, :gpu, :ram, :ssd, :hdd, :power, :user)
");

$stmt->execute([
    ':title' => $data['title'],
    ':cpu' => $data['cpu'],
    ':mb' => $data['mb'],
    ':gpu' => $data['gpu'],
    ':ram' => $data['ram'],
    ':ssd' => $data['ssd'],
    ':hdd' => $data['hdd'],
    ':power' => $data['power'],
    ':user' => $user
]);

echo "저장 완료!";
?>