<!-- マッチングしたユーザー同士でチャットができるようにする -->
<?php
require_once 'functions.php';

?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link href="css/style.css" rel="stylesheet">
    <script src="css/script.js"></script>

    <title>チャット</title>
</head>

<body>
    <header>MATCHING SYSTEM
        <div id="navArea">
            <nav>
                <div class="inner">
                    <h2>MENU</h2>
                    <ul>
                        <li><a href="reserve.php">申し込み</a></li>
                        <li><a href="index.php">募集</a></li>
                        <li><a href="login.php">ログイン・新規登録</a></li>
                    </ul>
                </div>
            </nav>
            <div class="toggle-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div id="mask"></div>
        </div>
    </header>
    <h1>チャット</h1>

</body>

</html>