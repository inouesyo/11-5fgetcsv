<?php
try {
    // データベースに接続するための文字列（DSN 接続文字列）
    $dsn = 'mysql:dbname=php_work;host=localhost;charset=utf8';

    // PDOクラスのインスタンスを作る
    // 引数は、上記のDSN、データベースのユーザー名、パスワード
    // XAMPPの場合はデフォルトでパスワードなし、MAMPの場合は「root」
    $dbh = new PDO($dsn, 'root', '');

    // エラーが起きたときのモードを指定する
    // 「PDO::ERRMODE_EXCEPTION」を指定すると、エラー発生時に例外がスローされる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // レコードを全件取得する（期限日の古いものから並び替える）
    $sql = 'select * from todo_items order by expiration_date';

    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);

    // SQLを実行する
    $stmt->execute();

    // 取得したレコードを連想配列として変数に代入する
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

// 取得したレコードをCSVファイルとしてダウンロードさせる
// header 生の HTTP ヘッダを送信する
// HTTPによるリクエストや、レスポンスのやりとりをするときに
// HTTPヘッダの内容を指定できる
// 指定したパスに存在する指定したファイルを
// ダウンロードすることができる
// Content-Typeにパスを指定
// Content-Dispositionではwork.csvの名前でダウンロードされるように指定しています。
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="work.csv"');

foreach ($list as $val) {
    foreach ($val as $k => $v) {
        // 配列のキーがtodo_itemのとき
        if ($k == 'todo_item') {
            // 文字コードをSJIS-winからUTF-8に変換する
            $val[$k] = mb_convert_encoding($v, 'SJIS-win', 'UTF-8');
        }
    }
    // 配列を「,」で結合して出力する
    // CSVの内容をechoで表示することでダウンロードが始まる
    // implode 配列要素を文字列により連結する
    echo implode(',', $val)."\n";
}