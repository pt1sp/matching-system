<?php
require_once('functions.php');
session_start();

//予約確定ボタンが押された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //セッションから入力情報を取得する
    if (isset($_SESSION['RESERVE'])) {
        $reserve_date = $_SESSION['RESERVE']['reserve_date'];
        $reserve_time = $_SESSION['RESERVE']['reserve_time'];
        $rule = $_SESSION['RESERVE']['rule'];
        $power = $_SESSION['RESERVE']['power'];
        $friendcode = $_SESSION['RESERVE']['friendcode'];
        $comment = $_SESSION['RESERVE']['comment'];

        //予約が確定可能かどうか最終チェック

        //DBに接続
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->query('SET NAMES utf8;');

        //reserveテーブルにINSERT
        $stmt = $pdo->prepare('INSERT INTO reserve (reserve_date, reserve_time, rule, power, friendcode, comment) VALUES (:reserve_date, :reserve_time, :rule, :power, :friendcode, :comment)');
        $stmt->bindValue(':reserve_date', $reserve_date, PDO::PARAM_STR);
        $stmt->bindValue(':reserve_time', $reserve_time, PDO::PARAM_STR);
        $stmt->bindValue(':rule', $rule, PDO::PARAM_STR);
        $stmt->bindValue(':power', $power, PDO::PARAM_STR);
        $stmt->bindValue(':friendcode', $friendcode, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();

        //予約が正常に完了したらセッションのデータをクリアする
        unset($_SESSION['RESERVE']);

        //DBから切断
        unset($pdo);

        //予約完了画面の表示
        header('Location: complete.php');
        exit;
    } else {
        //セッションからデータを収録できない場合はエラー

    }
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

    <title>募集内容確認</title>
</head>

<body>
    <header>MATCHING SYSTEM</header>
    <h1>募集内容確認</h1>
    <form method="post">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">日付</th>
                    <td><?= fomat_date($_SESSION['RESERVE']['reserve_date']) ?></td>
                </tr>
                <tr>
                    <th scope="row">時間帯</th>
                    <td><?= $_SESSION['RESERVE']['reserve_time'] ?></td>
                </tr>
                <tr>
                    <th scope="row">ルール</th>
                    <td colspan="2"><?= $_SESSION['RESERVE']['rule'] ?></td>
                </tr>
                <tr>
                    <th scope="row">パワー</th>
                    <td colspan="2"><?= $_SESSION['RESERVE']['power'] ?></td>
                </tr>
                <tr>
                    <th scope="row">フレンドコード</th>
                    <td colspan="2"><?= $_SESSION['RESERVE']['friendcode'] ?></td>
                </tr>
                <tr>
                    <th scope="row">備考</th>
                    <td colspan="2"><?= nl2br($_SESSION['RESERVE']['comment']) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="d-grid gap-2 mx-3">
            <button class="btn btn-primary rounded-pill" type="submit">募集</button>
            <a class="btn btn-secondary rounded-pill" href="index.php">戻る</a>
        </div>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>

</html>