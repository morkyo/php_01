<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css?<?= filemtime( "{$_SERVER['DOCUMENT_ROOT']}/php_01/css/style.css" ) ?>">
</head>
<body>
<?php


//入力内容を書き出し
$name = '';
$time = '';
$msg = '';
$i = 1;
date_default_timezone_set('Asia/Tokyo');
  
if (isset($_POST['send']) === true) {
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  $time = $_POST['time'];
  if (empty($_POST['name'])){
    $name = "名無しさん＠お腹いっぱい。";
  }
  $fp = fopen('log.txt','a');
  fwrite($fp,$name."\t".$time."\t".$msg."\n");
  fclose($fp);
  header('Location: ./');
}

//テキストファイルの情報を表示
$log_array = [];
$fp = fopen('log.txt', 'r');
while ($val = fgets($fp)) {
  $temp = explode("\t", $val);
  $temp_array = [
      'name' => $temp[0],
      'time' => $temp[1],
      'msg' => $temp[2]
  ];
  $log_array[] = $temp_array;
}
?>
<h1><span>?</span>ちゃんねる</h1>
<main>
<ul id="contents">
    <?php foreach ($log_array as $data): ?>
        <li>
          <div class="contents_name">
            <span class="contents_num"><?= $i++; ?></span>
            <?= htmlspecialchars($data["name"],ENT_QUOTES); ?>
            <span class="contents_time"><?= $data["time"]; ?></span>
          </div>
          <div class="contents_msg">
          <?= htmlspecialchars($data["msg"],ENT_QUOTES); ?>
          </div>
        </li>
    <?php endforeach; ?>
  </ul>
  <div id="register">
    <form action="index.php#register" method="post">
      <div class="register_name">
        <label for="name">名前</label>
        <input type="text" name="name" id="name">
      </div>
      <div class="register_msg">
        <label for="msg">内容</label>
        <input type="text" name="msg" id="msg">
      </div>
      <div class="register_btn">
        <input type="hidden" name="time" value="<?= date('Y/m/d H:i:s'); ?>">
        <input type="submit" name="send" value="書き込む">
      </div>
    </form>
  </div>
</main>
</body>
</html>