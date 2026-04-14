var_dump(getenv("DATABASE_URL"));
exit;
<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error = "이미 존재하는 아이디입니다.";
    } else {

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo "<script>alert('회원가입 성공!'); location.href='login.php';</script>";
        } else {
            $error = "회원가입 실패";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>회원가입</title>
<style>
body {
  margin: 0;
  font-family: Arial;
  background: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.container {
  background: white;
  padding: 40px;
  border-radius: 10px;
  width: 300px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

h2 {
  text-align: center;
}

input {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

button {
  width: 100%;
  padding: 10px;
  margin-top: 20px;
  background: #4a90e2;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background: #357abd;
}

.error {
  color: red;
  margin-top: 10px;
  text-align: center;
}
</style>
</head>

<body>

<div class="container">
  <h2>회원가입</h2>

  <form method="post">
    <input type="text" name="username" placeholder="아이디" required>
    <input type="password" name="password" placeholder="비밀번호" required>
    <button type="submit">회원가입</button>
  </form>

  <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

</div>

</body>
</html>
