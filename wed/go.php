<?php
require_once('functions.php');
session_start();

//セッションから入力情報を取得する
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    //DBに接続
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->query('SET NAMES utf8;');

    //idをキーにして予約データを取得
    $stmt = $pdo->prepare('SELECT * FROM reserve WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $reserve = $stmt->fetch();
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
    <!-- CSS -->
    <link href="css/style.css" rel="stylesheet">
    <script src="css/script.js"></script>

    <title>募集内容</title>
</head>

<body>
    <header>MATCHING SYSTEM</header>
    <h1>募集内容</h1>
    <form method="post">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">日付</th>
                    <td><?= fomat_date($reserve['reserve_date']) ?></td>
                </tr>
                <tr>
                    <th scope="row">時間帯</th>
                    <td><?= (date('H:i', strtotime($reserve['reserve_time']))) ?></td>
                </tr>
                <tr>
                    <th scope="row">ルール</th>
                    <td><?= ($reserve['rule']) ?></td>
                </tr>
                <tr>
                    <th scope="row">パワー</th>
                    <td><?= ($reserve['power']) ?></td>
                </tr>
                <tr>
                    <th scope="row">フレンドコード</th>
                    <td><?= ($reserve['friendcode']) ?></td>
                </tr>
                <tr>
                    <th scope="row">備考</th>
                    <td><?= nl2br(($reserve['comment'])) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="d-grid gap-2 mx-3">
            <button class="btn btn-primary rounded-pill" type="submit">申し込み</button>
            <a class="btn btn-secondary rounded-pill" href="reserve.php">戻る</a>
        </div>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>

</html>