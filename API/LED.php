<?php
// ---- file path ----
$jsonFile = "led_state.json";

// ---- load previous state or create default ----
if (file_exists($jsonFile)) {
    $data = json_decode(file_get_contents($jsonFile), true);
} else {
    $data = [
        "status" => "OFF",
        "color" => ["r" => 0, "g" => 0, "b" => 0]
    ];
}

// ---- handle form submission ----
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data["status"] = $_POST["status"];
    $data["color"]["r"] = intval($_POST["r"]);
    $data["color"]["g"] = intval($_POST["g"]);
    $data["color"]["b"] = intval($_POST["b"]);

    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>RGB LED Control (JSON-Based)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f0f0f0;
      margin: 20px;
    }
    .color-box {
      width: 200px;
      height: 100px;
      margin: 20px auto;
      border: 2px solid #000;
      border-radius: 5px;
      background-color: rgb(<?php echo "{$data['color']['r']}, {$data['color']['g']}, {$data['color']['b']}"; ?>);
    }
    .slider { width: 60%; }
  </style>
  <script>
    function updatePreview() {
      const r = document.getElementById("r").value;
      const g = document.getElementById("g").value;
      const b = document.getElementById("b").value;
      document.getElementById("color-box").style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
      document.getElementById("rgbText").innerText = `rgb(${r}, ${g}, ${b})`;
    }
  </script>
</head>
<body>

  <h2>RGB LED Control</h2>

  <div id="color-box" class="color-box"></div>
  <p id="rgbText">
    rgb(<?php echo "{$data['color']['r']}, {$data['color']['g']}, {$data['color']['b']}"; ?>)
  </p>

  <form method="post">
    <p>
      <label><strong>LED Status:</strong></label>
      <label><input type="radio" name="status" value="ON" <?php if($data["status"]=="ON") echo "checked"; ?>> ON</label>
      <label><input type="radio" name="status" value="OFF" <?php if($data["status"]=="OFF") echo "checked"; ?>> OFF</label>
    </p>

    <p>
      <label>Red:</label>
      <input type="range" id="r" name="r" class="slider" min="0" max="255" value="<?php echo $data['color']['r']; ?>" oninput="updatePreview()">
    </p>
    <p>
      <label>Green:</label>
      <input type="range" id="g" name="g" class="slider" min="0" max="255" value="<?php echo $data['color']['g']; ?>" oninput="updatePreview()">
    </p>
    <p>
      <label>Blue:</label>
      <input type="range" id="b" name="b" class="slider" min="0" max="255" value="<?php echo $data['color']['b']; ?>" oninput="updatePreview()">
    </p>

    <p><input type="submit" value="Save"></p>
  </form>

  <p>Current LED Status: <strong><?php echo strtoupper($data['status']); ?></strong></p>

</body>
</html>
