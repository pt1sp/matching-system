<?php
require_once 'functions.php';

$reserve_date_array = array();
for ($i = 1; $i <= 31; $i++) {
    $target_date = strtotime("+ {$i} day");

    $reserve_date_array[date('Ymd', $target_date)] = date('n/j', $target_date);
}

$reserve_time_array = array(
    "24:00" => "24:00",
    "23:00" => "23:00",
    "22:00" => "22:00",
    "21:00" => "21:00",
    "20:00" => "20:00",
    "19:00" => "19:00",
    "18:00" => "18:00",
    "17:00" => "17:00",
    "16:00" => "16:00",
    "15:00" => "15:00",
    "14:00" => "14:00",
    "13:00" => "13:00",
    "12:00" => "12:00",
    "11:00" => "11:00",
    "10:00" => "10:00",
    "09:00" => "09:00",
    "08:00" => "08:00",
    "07:00" => "07:00",
    "06:00" => "06:00",
    "05:00" => "05:00",
    "04:00" => "04:00",
    "03:00" => "03:00",
    "02:00" => "02:00",
    "01:00" => "01:00",
);

$rule_array = array(
    "エリア" => "エリア",
    "ナワバリ" => "ナワバリ",
    "ヤグラ" => "ヤグラ",
    "ホコ" => "ホコ",
    "アサリ" => "アサリ",
);

$power_array = array(
    "誰でも" => "誰でも",
    "強いところ" => "強いところ",
    "3500" => "3500",
    "3400" => "3400",
    "3300" => "3300",
    "3200" => "3200",
    "3100" => "3100",
    "3000" => "3000",
    "2900" => "2900",
    "2800" => "2800",
    "2700" => "2700",
    "2600" => "2600",
    "2500" => "2500",
    "2400" => "2400",
    "2300" => "2300",
    "2200" => "2200",
    "2100" => "2100",
    "2000" => "2000",
);

session_start();
$err = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTパラメータから各種入力値を取得
    $reserve_date = $_POST['reserve_date'];
    $reserve_time = $_POST['reserve_time'];
    $rule = $_POST['rule'];
    $power = $_POST['power'];
    $friendcode = $_POST['friendcode'];
    $comment = $_POST['comment'];

    //各種入力値のバリデーション
    if (!$reserve_date) {
        $err['reserve_date'] = '予約日を選択してください';
    }
    if (!$reserve_time) {
        $err['reserve_time'] = '予約時間を選択してください';
    }
    if (!$rule) {
        $err['rule'] = 'ルールを選択してください';
    }
    if (!$power) {
        $err['power'] = 'パワー帯を選択してください';
    }
    if (!$friendcode) {
        $err['friendcode'] = 'フレンドコードを入力してください';
    } else if (!preg_match('/^\d{4}-\d{4}-\d{4}$/', $friendcode)) {
        $err['friendcode'] = 'フレンドコードを正しく入力してください';
    }
    if (mb_strlen($comment, 'utf-8') > 2000) {
        $err['comment'] = '備考欄は2000文字以内で入力してください';
    }

    // エラーがなければ次の処理へ進む
    if (empty($err)) {
        // セッションに各種入力値を保存
        $_SESSION['RESERVE']['reserve_date'] = $reserve_date;
        $_SESSION['RESERVE']['reserve_time'] = $reserve_time;
        $_SESSION['RESERVE']['rule'] = $rule;
        $_SESSION['RESERVE']['power'] = $power;
        $_SESSION['RESERVE']['friendcode'] = $friendcode;
        $_SESSION['RESERVE']['comment'] = $comment;

        // 予約確認画面へリダイレクト
        header('Location: confim.php');
        exit;
    }
} else {
    //セッションに入力情報がある場合は取得する
    if (isset($_SESSION['RESERVE'])) {
        $reserve_date = $_SESSION['RESERVE']['reserve_date'];
        $reserve_time = $_SESSION['RESERVE']['reserve_time'];
        $rule = $_SESSION['RESERVE']['rule'];
        $power = $_SESSION['RESERVE']['power'];
        $friendcode = $_SESSION['RESERVE']['friendcode'];
        $comment = $_SESSION['RESERVE']['comment'];
    } else {
        //セッションに入力情報がない場合は初期値を設定する
        $reserve_date = '';
        $reserve_time = '';
        $rule = '';
        $power = '';
        $friendcode = '';
        $comment = '';
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
    <script src="css/script.js"></script>

    <title>対抗戦相手募集</title>
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
    <content>
        <h1>対抗戦相手募集</h1>
        <form class="m-3" method="post">

            <?php if (isset($err['common'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $err['common']; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">【１】 日付を選択</label>
                <?= arrayToSelect('reserve_date', $reserve_date_array, $reserve_date); ?>
                <div class="invalid-feedback"><?= $err['reserve_date']; ?></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">【２】 時間帯を選択</label>
                <?= arrayToSelect('reserve_time', $reserve_time_array, $reserve_time); ?>
                <div class="invalid-feedback"><?= $err['reserve_time']; ?></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">【３】 ルールを選択</label>
                <?= arrayToSelect('rule', $rule_array, $rule); ?>
                <div class="invalid-feedback"><?= $err['rule']; ?></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">【４】 パワー帯を選択</label>
                <?= arrayToSelect('power', $power_array, $power); ?>
                <div class="invalid-feedback"><?= $err['power']; ?></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">【５】 フレンドコードを入力</label>
                <input type="tel" class="form-control <?php if (isset($err['friendcode'])) echo 'is-invalid'; ?>" name="friendcode" placeholder="1234-5678-9000" value="<?= $friendcode ?>">
                <div class="invalid-feedback"><?= $err['friendcode']; ?></div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">備考</label>
                <textarea class="form-control" name="comment" rows="3" placeholder="配信有無・情報漏洩有無など"><?= $comment ?></textarea>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary rounded-pill" type="submit">確認画面へ</button>
            </div>
        </form>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    </content>
</body>

</html>