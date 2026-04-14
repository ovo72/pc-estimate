<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>PC 견적 플랫폼</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background-color: #f5f5f5; }
    header { background-color: #222; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
    header h1 { margin: 0; font-size: 20px; }
    nav a { color: white; margin-left: 20px; text-decoration: none; }

    .hero { background-color: #4a90e2; color: white; padding: 60px 20px; text-align: center; }
    .search-box { margin-top: 20px; }
    .search-box input { padding: 10px; width: 250px; border: none; border-radius: 5px; }
    .search-box button { padding: 10px 15px; border: none; background-color: #222; color: white; border-radius: 5px; cursor: pointer; }

    .section { padding: 40px 20px; max-width: 1000px; margin: auto; }
    .card-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }

    .card-link { text-decoration: none; color: inherit; }
    .card { background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
    .card h3 { margin-top: 0; }

    footer { background-color: #222; color: white; text-align: center; padding: 15px; margin-top: 40px; }
  </style>
</head>

<body>

<header>
  <h1>PC 견적 플랫폼</h1>
  <nav>
    <a href="#">홈</a>
    <a href="build.php">견적 만들기</a> 
    <a href="#">견적 공유</a>

    <?php if (isset($_SESSION['user'])): ?>
      <span style="margin-left:20px; color:white;">
         <?php echo $_SESSION['user']; ?>님
      </span>
      <a href="logout.php">로그아웃</a>
    <?php else: ?>
      <a href="login.php">로그인</a>
      <a href="register.php">회원가입</a>
    <?php endif; ?>

  </nav>
</header>

<section class="hero">
  <h2>나만의 PC 견적을 만들어보세요</h2>
  <p>초보자도 쉽게, 전문가처럼 견적 구성</p>
  <div class="search-box">
    <input type="text" placeholder="견적 검색 (예: 100만원 게임용)">
    <button>검색</button>
  </div>
</section>

<section class="section">
  <h2>추천 견적</h2>
  <div class="card-container">

    <a href="popular.php?type=office" class="card-link">
      <div class="card">
        <h3> 사무용 PC</h3>
        <p>가장 인기 있는 사무용 견적 보기</p>
      </div>
    </a>

    <a href="popular.php?type=highend" class="card-link">
      <div class="card">
        <h3> 고사양 PC</h3>
        <p>유저들이 선택한 최고의 성능 견적</p>
      </div>
    </a>

    <a href="popular.php?type=work" class="card-link">
      <div class="card">
        <h3> 작업용 PC</h3>
        <p>작업 효율을 위한 추천 견적</p>
      </div>
    </a>

  </div>
</section>

<footer>
  <p>© 2026 PC 견적 플랫폼</p>
</footer>

</body>
</html>

