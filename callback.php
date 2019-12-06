<?php
require('config.php');
session_start();

$token = null;
if (!empty($_SESSION["state"]) && $_SESSION["state"] == $_GET["state"]) {
    unset($_SESSION["state"]);
    $code = $_GET["code"];
    $url = TOKEN_URI;
    $data = [
        'code' => $_GET["code"],
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI,
        'grant_type' => 'authorization_code',
    ];
    $headers = "Content-Type: application/x-www-form-urlencoded";
    $context = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($context);
    $resp = file_get_contents($url, false, $context);
    $token = json_decode($resp);
    if (empty($token->error)) {
        $_SESSION["token"] = $token;
        header('Location: /profile.php');
        exit();
    }
} else {
    $token->error = 'Invalid request';
    $token->error_description = 'Invalid state. State in session and State in response do not match';
}

$state = substr(base_convert(md5(uniqid()), 16, 36), 0, 16);
$_SESSION["state"] = $state;
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
    </div>
  </nav>
  <div class="container mt-5">
    <div class="row">
      <div class="col">
        <h3 class="h3"><?php echo htmlspecialchars($token->error); ?></h3>
        <p class="text-danger"><?php echo htmlspecialchars($token->error_description); ?></p>
        <a class="btn btn-light" href="<?php echo BASE_URI ?>?client_id=<?php echo CLIENT_ID ?>&redirect_uri=<?php REDIRECT_URI ?>&response_type=code&state=<?php echo $state; ?>">Retry OAuth Sign in</a>
        <a class="btn btn-secondary" href="./">Back</a>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
