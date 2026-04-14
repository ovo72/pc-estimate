<?php
$databaseUrl = getenv("DATABASE_URL");

if (!$databaseUrl) {
    die("DATABASE_URL이 설정되지 않았습니다.");
}

$db = parse_url($databaseUrl);

$host = $db["host"];
$port = $db["port"];
$dbname = ltrim($db["path"], "/");
$user = $db["user"];
$password = $db["pass"];

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}
?>