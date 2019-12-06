<?php
require('config.php');
session_start();

if (empty($_SESSION["token"])) {
    header('Location: /');
    exit();
}

$token = $_SESSION['token'];
$data = [
        'access_token' => $token->access_token,
];

// ユーザー情報取得
$resp = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . http_build_query($params));

?>

<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <title>OAuth Client</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand mb-0 h1" href="/">OAuth Client</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto"></ul>
      <a class="btn btn-light mr-sm-2" href="#">Token refresh</a><!--本来であればトークンリフレッシュ用の処理を書いたリンクを付ける。-->
      <a class="btn btn-light" href="#">Sign out</a><!--本来であればサインアウト用の処理を書いたリンクを付ける。-->
    </div>
  </nav>
  <div class="container mt-5">
    <div class="row">
      <div class="col">
        <!-- コメント内のマークアップはresponseをどう表示するかによって変更されるので注意 -->
        <?php echo $resp; ?>
        <!-- ここまで -->
      </div>
    </div>
  </div>
  <hr>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
