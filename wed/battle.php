<?php
require_once 'functions.php';

session_start();
// DBに接続
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
$pdo->query('SET NAMES utf8;');
//予約データをすべて取得
$stmt = $pdo->query('SELECT * FROM reserve');
$reserve_list = $stmt->fetchAll();

//取得したデータを日付順に並び替えて表示
usort($reserve_list, function ($a, $b) {
    return $a['reserve_date'] <=> $b['reserve_date'];
});

$reserve_date_array = array();
for ($i = 1; $i <= 31; $i++) {
    $target_date = strtotime("+ {$i} day");

    $reserve_date_array[date('Ymd', $target_date)] = date('n/j', $target_date);
}

$rule_array = array(
    "エリア" => "エリア",
    "ナワバリ" => "ナワバリ",
    "ヤグラ" => "ヤグラ",
    "ホコ" => "ホコ",
    "アサリ" => "アサリ",
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //idを取得
    $id = $_POST['id'];
    //セッションにidを保存
    $_SESSION['id'] = $id;
    //go.phpにリダイレクト
    header('Location: go.php');
    exit;
}
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

    <title>募集リスト</title>
</head>

<body>
    <header>MATCHING SYSTEM
        <div id="navArea">
            <nav>
                <div class="inner">
                    <h2>MENU</h2>
                    <ul>
                        <li><a href="reserve.php">申し込み</a></li>
                        <li><a href="">対戦予定</a></li>
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
    <h1>募集リスト</h1>

    <form id="filter-form" method="get">
        <div class="row m-3">
            <div class="col">
                <?= arrayToSelect('reserve_date', $reserve_date_array); ?>
            </div>
            <div class="col">
                <?= arrayToSelect('rule', $rule_array); ?>
            </div>
        </div>
    </form>

    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">日付</th>
                            <th scope="col">時間帯</th>
                            <th scope="col">ルール</th>
                            <th scope="col">パワー</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reserve_list as $reserve) : ?>
                            <tr>
                                <form method="post">
                                    <th scope="row"><?= $reserve['id'] ?></th>
                                    <td><?= fomat_date($reserve['reserve_date']) ?></td>
                                    <td><?= date('H:i', strtotime($reserve['reserve_time'])) ?></td>
                                    <td><?= $reserve['rule'] ?></td>
                                    <td><?= $reserve['power'] ?></td>
                                    <td><button class="btn custom-btn" type="submit" style="background-color: blue; color:white">詳</button>
                                        <input type="hidden" name="id" value="<?= $reserve['id'] ?>">
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>

</html>