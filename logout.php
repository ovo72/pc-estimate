<?php
session_start(); // 세션 시작

session_destroy(); // 세션 전체 삭제 (로그아웃 처리)

// 메인 페이지로 이동
header("Location: index.php");
exit();
?>