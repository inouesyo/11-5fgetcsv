<?php
try {
    // データベースに接続するための文字列（DSN 接続文字列）
    // データソースネーム データベースやその接続情報に対して
    // 付けられる識別用の名前
    $dsn = 'mysql:
                    dbname=php_work;
                    host=localhost;
                    charset=utf8';

    // PDOクラスはPHPとデータベースサーバーの間の接続を表す
    // PDOクラスのインスタンスを作ることで
    // データベースサーバーとの接続が確立される
    // 引数は、上記のDSN、データベースのユーザー名、パスワード
    // XAMPPの場合はデフォルトでパスワードなし、MAMPの場合は「root」
    $dbh = new PDO($dsn, 'root', '');

    // エラーが起きたときのモードを指定する
    // 「PDO::ERRMODE_EXCEPTION」を指定すると、
    // エラー(ERRMODE)発生時に例外(EXCEPTION)がスローされる
    // setAttribute 属性を設定する (attribute 属性)
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTデータをデータベースにインサートする
    $sql = '';
    $sql .= 'insert into todo_items (';
    $sql .= 'expiration_date,';
    $sql .= 'todo_item';
    $sql .= ') values (';
    $sql .= ':expiration_date,';
    $sql .= ':todo_item';
    $sql .= ')';

    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);

    // SQL文の該当箇所に、変数の値を割り当て（バインド）する
    // bindValue(プレースホルダー, 値, 値の型)
    // 値の型はPDOクラスの定数(PDO::PARAM_???)で指定
    // SQL文の該当箇所に、変数の値を割り当て（バインド）する
    $stmt->bindValue(':expiration_date', $_POST['expiration_date'], PDO::PARAM_STR);
    $stmt->bindValue(':todo_item', $_POST['todo_item'], PDO::PARAM_STR);

    // SQLを実行する
    $stmt->execute();

    // 処理が完了したらトップページ（index.php）へリダイレクト
    header('Location: ./');
    exit;
} catch (Exception $e) {
    var_dump($e);
    exit;
}