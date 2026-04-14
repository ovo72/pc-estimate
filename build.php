<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>견적 작성</title>

<style>
body {
  margin: 0;
  font-family: Arial;
  background: #f5f5f5;
}

.container {
  display: flex;
  height: 100vh;
}

/* 왼쪽 리스트 */
#part-list {
  width: 50%;
  background: white;
  padding: 20px;
  overflow-y: scroll;
  border-right: 1px solid #ccc;
}

#part-list h3 {
  margin-top: 20px;
  border-bottom: 1px solid #ddd;
}

#part-list p {
  cursor: pointer;
  padding: 5px;
}

#part-list p:hover {
  background: #eee;
}

/* 오른쪽 선택 영역 */
.right {
  width: 50%;
  padding: 20px;
}

.right p {
  cursor: pointer;
  padding: 10px;
  background: white;
  margin-bottom: 10px;
  border-radius: 5px;
}

.right p:hover {
  background: #ddd;
}

button {
  padding: 10px;
  width: 100%;
  background: #4a90e2;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

</style>
</head>

<body>

<div class="container">

  <!-- 왼쪽 -->
  <div id="part-list">
    <h2>부품을 선택하세요</h2>
  </div>

  <!-- 오른쪽 -->
  <div class="right">

    <p onclick="loadPart('cpu')">CPU: <span id="cpu">미선택</span></p>
    <p onclick="loadPart('mb')">메인보드: <span id="mb">미선택</span></p>
    <p onclick="loadPart('gpu')">그래픽카드: <span id="gpu">미선택</span></p>
    <p onclick="loadPart('ram')">RAM: <span id="ram">미선택</span></p>
    <p onclick="loadPart('ssd')">SSD: <span id="ssd">미선택</span></p>
    <p onclick="loadPart('hdd')">HDD: <span id="hdd">미선택</span></p>
    <p onclick="loadPart('power')">파워: <span id="power">미선택</span></p>

    <input type="text" id="title" placeholder="견적 제목 입력" style="width:100%; padding:10px; margin-top:10px;">

    <br><br>

    <button onclick="saveBuild()">견적 저장</button>

  </div>

</div>

<script>

const parts = {

  cpu: {
    "Intel (1~14세대)": [
      "i3 1세대","i5 1세대","i7 1세대",
      "i3 2세대","i5 2세대","i7 2세대",
      "i3 3세대","i5 3세대","i7 3세대",
      "i3 4세대","i5 4세대","i7 4세대",
      "i3 5세대","i5 5세대","i7 5세대",
      "i3 6세대","i5 6세대","i7 6세대",
      "i3 7세대","i5 7세대","i7 7세대",
      "i3 8세대","i5 8세대","i7 8세대",
      "i3 9세대","i5 9세대","i7 9세대",
      "i3 10세대","i5 10세대","i7 10세대","i9 10세대",
      "i3 11세대","i5 11세대","i7 11세대","i9 11세대",
      "i3 12세대","i5 12세대","i7 12세대","i9 12세대",
      "i3 13세대","i5 13세대","i7 13세대","i9 13세대",
      "i3 14세대","i5 14세대","i7 14세대","i9 14세대"
    ],
    "Intel 울트라": [
      "Ultra 2세대","Ultra 3세대"
    ],
    "AMD Ryzen": [
      "Ryzen 3 3000번대","Ryzen 5 3000번대","Ryzen 7 3000번대","Ryzen 9 3000번대",
      "Ryzen 3 5000번대","Ryzen 5 5000번대","Ryzen 7 5000번대","Ryzen 9 5000번대",
      "Ryzen 3 7000번대","Ryzen 5 7000번대","Ryzen 7 7000번대","Ryzen 9 7000번대",
      "Ryzen 3 8000번대","Ryzen 5 8000번대","Ryzen 7 8000번대","Ryzen 9 8000번대",
      "Ryzen 3 9000번대","Ryzen 5 9000번대","Ryzen 7 9000번대","Ryzen 9 9000번대"
    ]
  },

  gpu: {

    "NVIDIA GTX 10": [
      "GTX 1080 Ti","GTX 1080","GTX 1070 Ti","GTX 1070",
      "GTX 1060","GTX 1060 3GB","GTX 1050 Ti","GTX 1050","GT 1030"
    ],

    "NVIDIA GTX 16": [
      "GTX 1660 Ti","GTX 1660 SUPER","GTX 1660",
      "GTX 1650 SUPER","GTX 1650"
    ],

    "NVIDIA RTX 20": [
      "RTX 2080 Ti","RTX 2080 SUPER","RTX 2080",
      "RTX 2070 SUPER","RTX 2070",
      "RTX 2060 SUPER","RTX 2060","RTX 2060 12GB"
    ],

    "NVIDIA RTX 30": [
      "RTX 3090 Ti","RTX 3090",
      "RTX 3080 Ti","RTX 3080 12GB","RTX 3080",
      "RTX 3070 Ti","RTX 3070",
      "RTX 3060 Ti GDDR6X","RTX 3060 Ti",
      "RTX 3060","RTX 3060 8GB",
      "RTX 3050 8GB","RTX 3050 6GB"
    ],

    "NVIDIA RTX 40": [
      "RTX 4090","RTX 4080 SUPER","RTX 4080",
      "RTX 4070 Ti SUPER","RTX 4070 SUPER",
      "RTX 4070 Ti","RTX 4070",
      "RTX 4060 Ti 16GB","RTX 4060 Ti 8GB","RTX 4060"
    ],

    "NVIDIA RTX 50": [
      "RTX 5090","RTX 5080","RTX 5070 Ti",
      "RTX 5070","RTX 5060 Ti 16GB","RTX 5060 Ti 8GB",
      "RTX 5060","RTX 5050"
    ],

    "AMD RX 5000": [
      "RX 5700 XT","RX 5700","RX 5600 XT","RX 5500 XT"
    ],

    "AMD RX 6000": [
      "RX 6950 XT","RX 6900 XT","RX 6800 XT","RX 6800",
      "RX 6700 XT","RX 6700",
      "RX 6600 XT","RX 6600",
      "RX 6500 XT","RX 6400","RX 6300"
    ],

    "AMD RX 7000": [
      "RX 7900 XTX","RX 7900 XT","RX 7900 GRE",
      "RX 7800 XT","RX 7700 XT","RX 7700",
      "RX 7600 XT","RX 7600","RX 7400"
    ],

    "AMD RX 9000": [
      "RX 9070 XT","RX 9070","RX 9060 XT","RX 9060"
    ]
  },

  ram: {
    "DDR3": ["16GB","24GB","32GB","48GB","64GB","128GB"],
    "DDR4": ["16GB","24GB","32GB","48GB","64GB","128GB"],
    "DDR5": ["16GB","24GB","32GB","48GB","64GB","128GB"]
  },

  ssd: {
    "M.2 PCIe 3.0": ["500GB","1TB","2TB","4TB"],
    "M.2 PCIe 4.0": ["500GB","1TB","2TB","4TB"],
    "M.2 PCIe 5.0": ["500GB","1TB","2TB","4TB"],
    "SATA": ["500GB","1TB","2TB","4TB"]
  },

  hdd: {
    "HDD": ["500GB","1TB","2TB","4TB"]
  },

  power: {
    "브론즈": ["500W","600W","650W","700W","750W","800W","1000W"],
    "실버": ["500W","600W","650W","700W","750W","800W","1000W"],
    "골드": ["500W","600W","650W","700W","750W","800W","1000W"],
    "플래티넘": ["500W","600W","650W","700W","750W","800W","1000W"],
    "티타늄": ["500W","600W","650W","700W","750W","800W","1000W"]
  },

  mb: {
    "AMD X 시리즈": ["X870","X870E","X670E"],
    "AMD B 시리즈": ["B850","B650"],
    "AMD A 시리즈": ["A620","A520"],
    "Intel Z 시리즈": ["Z890","Z790"],
    "Intel B 시리즈": ["B860","B760"],
    "Intel H 시리즈": ["H610","H510"]
  }

};
// 🔥 왼쪽 리스트 출력
function loadPart(type) {

  let html = "";

  for (let category in parts[type]) {

    html += `<h3>${category}</h3>`;

    parts[type][category].forEach(item => {
      html += `<p onclick="selectPart('${type}', '${category} ${item}')">${item}</p>`;
    });

  }

  document.getElementById("part-list").innerHTML = html;
}

// 🔥 선택 반영
function selectPart(type, value) {
  document.getElementById(type).innerText = value;
}

// 🔥 저장
function saveBuild() {

  let data = {
    title: document.getElementById("title").value,
    cpu: document.getElementById("cpu").innerText,
    mb: document.getElementById("mb").innerText,
    gpu: document.getElementById("gpu").innerText,
    ram: document.getElementById("ram").innerText,
    ssd: document.getElementById("ssd").innerText,
    hdd: document.getElementById("hdd").innerText,
    power: document.getElementById("power").innerText
  };

  fetch("save_build.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  })
  .then(res => res.text())
  .then(msg => {
    alert(msg);
    location.href = "popular.php";
  });

}

</script>

</body>
</html>