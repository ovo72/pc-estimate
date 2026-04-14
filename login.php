<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user['username'];

        header("Location: index.php");
        exit();

    } else {
        $error = "아이디 또는 비밀번호가 틀렸습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>로그인</title>

<style>
body {
  margin: 0; /* 기본 여백 제거 */
  font-family: Arial; /* 글꼴 설정 */
  background: #f5f5f5; /* 배경색 */
  display: flex; /* 가운데 정렬을 위한 flex */
  justify-content: center; /* 가로 가운데 */
  align-items: center; /* 세로 가운데 */
  height: 100vh; /* 전체 화면 높이 */
}

.container {
  background: white; /* 카드 배경 */
  padding: 40px; /* 내부 여백 */
  border-radius: 10px; /* 둥근 모서리 */
  width: 300px; /* 박스 너비 */
  box-shadow: 0 5px 15px rgba(0,0,0,0.2); /* 그림자 */
}

h2 {
  text-align: center; /* 제목 가운데 정렬 */
}

input {
  width: 100%; /* 입력창 전체 너비 */
  padding: 10px; /* 내부 여백 */
  margin-top: 10px; /* 위쪽 간격 */
  border-radius: 5px; /* 둥근 모서리 */
  border: 1px solid #ccc; /* 테두리 */
}

button {
  width: 100%; /* 버튼 전체 너비 */
  padding: 10px; /* 내부 여백 */
  margin-top: 20px; /* 위쪽 간격 */
  background: #4a90e2; /* 배경색 */
  color: white; /* 글자색 */
  border: none; /* 테두리 제거 */
  border-radius: 5px; /* 둥근 모서리 */
  cursor: pointer; /* 마우스 포인터 */
}

button:hover {
  background: #357abd; /* 마우스 올렸을 때 색상 */
}

.error {
  color: red; /* 에러 메시지 색 */
  margin-top: 10px; /* 위쪽 간격 */
  text-align: center; /* 가운데 정렬 */
}
</style>
</head>

<body>

<div class="container">
  <h2>로그인</h2>

  <!-- 로그인 폼 -->
  <form method="post">
    <input type="text" name="username" placeholder="아이디" required> <!-- 아이디 입력 -->
    <input type="password" name="password" placeholder="비밀번호" required> <!-- 비밀번호 입력 -->
    <button type="submit">로그인</button> <!-- 로그인 버튼 -->
  </form>

  <!-- 에러 메시지 출력 -->
  <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

</div>

</body>
</html>