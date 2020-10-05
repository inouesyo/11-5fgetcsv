<?php
try {
    // データベースに接続するための文字列（DSN 接続文字列）
    $dsn = 'mysql:dbname=php_work;host=localhost;charset=utf8';

    // PDOクラスのインスタンスを作る
    // 引数は、上記のDSN、データベースのユーザー名、パスワード
    // XAMPPの場合はデフォルトでパスワードなし、MAMPの場合は「root」
    $dbh = new PDO($dsn, 'root', '');

    // エラーが起きたときのモードを指定する
    // ?????まず「PDO::ERRMODE_EXCEPTION」を指定すると「PDO::ERRMODE_EXCEPTION」選択できる ??????
    // 「PDO::ERRMODE_EXCEPTION」を指定すると、エラー発生時に例外がスローされる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 削除チェックボックスにチェックが入っているとき
    if (isset($_POST['delete']) && $_POST['delete'] == "1") {
        // レコードを削除する
        $sql = 'delete from todo_items where id=:id';

        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);

        // SQL文の該当箇所に、変数の値を割り当て（バインド）する
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    } else {
        // レコードをアップデートする
        // update テーブル set カラム = 値 where 条件
        // 条件にプレースホルダーを当てる(あとで値をバインドする為)
        $sql = 'update todo_items set is_completed=:is_completed where id=:id';

        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        // bindValue(プレースホルダー, 値, 値の型)
        // 値の型はPDOクラスの定数(PDO::PARAM_???)で指定
        // SQL文の該当箇所に、変数の値を割り当て（バインド）する
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->bindValue(':is_completed', $_POST['is_completed'], PDO::PARAM_INT);
    }

    // SQLを実行する
    $stmt->execute();

    // index.phpへリダイレクトする
    header('Location: ./');
    exit;
} catch (Exception $e) {
    var_dump($e);
    exit;
}