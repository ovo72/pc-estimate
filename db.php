<?php
$databaseUrl = getenv("DATABASE_URL");

if (!$databaseUrl) {
    die("DATABASE_URL이 설정되지 않았습니다.");
}

$databaseUrl = getenv("DATABASE_URL");

$db = parse_url($databaseUrl);

$host = $db["host"];
$user = $db["user"];
$pass = $db["pass"];
$dbname = ltrim($db["path"], "/");

$conn = new PDO(
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $pass
);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}
?>
