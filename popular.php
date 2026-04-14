<?php
session_start();
include "db.php";

$type = $_GET['type'] ?? '';

// 좋아요 처리
if (isset($_GET['like']) && isset($_SESSION['user'])) {

    $build_id = $_GET['like'];
    $user = $_SESSION['user'];

    $check = $conn->prepare("
        SELECT * FROM likes 
        WHERE build_id = :build_id AND user = :user
    ");
    $check->execute([
        ':build_id' => $build_id,
        ':user' => $user
    ]);

    if (!$check->fetch()) {
        $stmt = $conn->prepare("
            INSERT INTO likes (build_id, user)
            VALUES (:build_id, :user)
        ");
        $stmt->execute([
            ':build_id' => $build_id,
            ':user' => $user
        ]);
    }

    header("Location: popular.php?type=$type");
    exit();
}

// 목록 조회
$sql = "
SELECT builds.*, COUNT(likes.id) AS like_count
FROM builds
LEFT JOIN likes ON builds.id = likes.build_id
";

if ($type) {
    $sql .= " WHERE builds.type = :type";
}

$sql .= " GROUP BY builds.id ORDER BY like_count DESC";

$stmt = $conn->prepare($sql);

if ($type) {
    $stmt->bindParam(':type', $type);
}

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>인기 견적</title>
<style>
body { font-family: Arial; background: #f5f5f5; }
.container { max-width: 800px; margin: auto; padding: 20px; }

.card {
  background: white;
  padding: 20px;
  margin-top: 15px;
  border-radius: 10px;
}

button {
  margin-top: 10px;
  padding: 8px 12px;
  background: #4a90e2;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
</head>

<body>

<div class="container">
  <h2>🔥 인기 견적</h2>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card">
      <h3><?php echo $row['title']; ?></h3>
      <p>CPU: <?php echo $row['cpu']; ?></p>
      <p>GPU: <?php echo $row['gpu']; ?></p>
      <p>RAM: <?php echo $row['ram']; ?></p>
      <p>작성자: <?php echo $row['user']; ?></p>

      <p>👍 좋아요: <?php echo $row['like_count']; ?></p>

      <?php if (isset($_SESSION['user'])): ?>
        <a href="?type=<?php echo $type; ?>&like=<?php echo $row['id']; ?>">
          <button>좋아요 👍</button>
        </a>
      <?php else: ?>
        <button onclick="alert('로그인 후 이용하세요')">좋아요 👍</button>
      <?php endif; ?>

    </div>
  <?php endwhile; ?>

</div>

</body>
</html>