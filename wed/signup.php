<?php
require_once 'functions.php';

// DBに接続
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
$pdo->query('SET NAMES utf8;');

// POST処理時
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力値を取得
    $login_user = $_POST['login_user'];
    $login_password = $_POST['login_password'];

    // バリデーションチェック
    $err = array();

    if (!$login_user || !$login_password) {
        $err['common'] = 'IDとパスワードを入力してください';
    } else {
        // パスワードのハッシュ化
        $hashed_password = hash('sha256', $login_password);

        // データベースからユーザーを取得
        $sql = 'SELECT * FROM user WHERE login_user = :login_user LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':login_user', $login_user, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $err['common'] = 'IDが既に登録されています';
        } else {
            // ユーザーを登録
            $sql = 'INSERT INTO user (login_user, login_password) VALUES (:login_user, :login_password)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':login_user', $login_user, PDO::PARAM_STR);
            $stmt->bindValue(':login_password', $hashed_password, PDO::PARAM_STR);
            $stmt->execute();

            // 登録完了画面へリダイレクト
            header('Location: success.php');
            exit;
        }
    }
} else {
    // 画面初回アクセス時
    $login_user = '';
    $login_password = '';
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

    <title>新規登録</title>
</head>

<body>
    <header>MATCHING SYSTEM</header>
    <h1>新規登録</h1>

    <form class="card text-center" method="post">
        <div class="card-body">
            <?php if (isset($err['common'])) : ?>
                <div class="alert alert-danger" role="alert"><?= $err['common']; ?></div>
            <?php endif; ?>
            <div class="mb-3 text-start">
                <input type="text" class="form-control <?php if (isset($err['login_user'])) echo 'is-invalid'; ?>" id="login_user" name="login_user" placeholder="ID" value="<?= $login_user ?>">
                <div class="invalid-feedback"><?= $err['login_user']; ?></div>
            </div>
            <div class="mb-3 text-start input-group">
                <input type="password" class="form-control <?php if (isset($err['login_password'])) echo 'is-invalid'; ?>" id="login_password" name="login_password" placeholder="PASSWORD">
                <button type="button" class="btn btn-outline-secondary border-0" onclick="togglePassword()">
                    <i class="bi bi-eye"></i>
                </button>
                <div class="invalid-feedback"><?= $err['login_password']; ?></div>
            </div>
            <div class="d-grid gap-2 my-3">
                <button class="btn btn-primary rounded-pill" type="submit">新規登録</button>
            </div>
        </div>
    </form>

    <a href="login.php" class="btn btn-link">ログインはこちら</a>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script>
        // パスワードを表示するための関数
        function togglePassword() {
            var password = document.getElementById('login_password');
            if (password.type === 'password') {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>
</body>

</html>