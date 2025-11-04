<?php
// ====== Handle Button Request ======
$file = "results.txt";

if (isset($_POST['led_status'])) {
    $status = strtoupper(trim($_POST['led_status']));
    file_put_contents($file, $status);
}

// ====== Read Current LED Status ======
$currentStatus = file_exists($file) ? trim(file_get_contents($file)) : "OFF";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Creating a User Interface Webpage</title>
  <meta http-equiv="refresh" content="5"> <!-- auto refresh every 5 seconds -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f9fc;
      text-align: center;
    }
    h1 {
      margin-top: 40px;
      font-size: 28px;
    }
    .container {
      display: inline-block;
      margin-top: 20px;
      text-align: left;
      background: #fff;
      padding: 20px 30px;
      border: 2px solid #ccc;
      border-radius: 5px;
    }
    .title {
      font-size: 26px;
      font-weight: bold;
      color: #2e8b57;
    }
    input[type="submit"] {
      padding: 4px 12px;
      margin: 5px 0;
      border: 1px solid #888;
      border-radius: 3px;
      cursor: pointer;
    }
    .file-note {
      margin-top: 15px;
      font-size: 14px;
    }
    .status-box {
      margin-top: 15px;
      padding: 8px;
      font-weight: bold;
      border: 1px solid #aaa;
      background-color: #eef;
      width: fit-content;
    }
  </style>
</head>
<body>

  <h1>Creating a User Interface Webpage</h1>

  <div class="container">
    <div class="title">IoT Course</div>
    <p><strong>How to call PHP function on the click of a Button?</strong></p>

    <form method="post" action="">
      <p>Click to turn ON:
        <input type="submit" name="led_status" value="on">
      </p>
      <p>Click to Turn OFF:
        <input type="submit" name="led_status" value="off">
      </p>
    </form>

    <div class="status-box">
      Current LED Status:
      <span style="color: <?= ($currentStatus == 'ON') ? 'green' : 'red'; ?>;">
        <?= htmlspecialchars($currentStatus); ?>
      </span>
    </div>

  

</body>
</html>
