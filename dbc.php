<?php

// 詳細画面を表示する流れ
//①一覧画面からブログのidを送る
//GETリクエストでidをURLにつけて送る

//②詳細ページでidを受け取る
//PHPの$_GETでidを取得

//③idを元にデータベースから記事を取得
//SELECT文でプレースホルダーを使う

//④詳細ページに表示する
//HTMLにPHPを埋め込んで表示


//1.データベース接続
//引数：なし
//返り値：接続結果を返す
function dbConnect(){
    
    $dsn = $_ENV["DSN"];
    $user = $_ENV["USER"];
    $pass = $_ENV["PASSWORD"];


    try{
        $dbh = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

    }catch(PDOException $e){
        echo '接続失敗'. $e->getMessage();
        exit();
    };

    return $dbh;
}

//2.データを取得する
//引数：なし
//返り値：取得したデータ
function getAllBlog(){ 
    $dbh = dbConnect();     
    //①SQLの準備
    $sql = 'SELECT * FROM blog';
    //②SQLの実行
    $stmt = $dbh->query($sql);
    //③SQLの結果を受け取る
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    $dbh = null;
}
//取得したデータを表示
$blogData = getAllBlog();

//3.カテゴリー名を表示
//引数：数字
//返り値：カテゴリーの文字列
function setCategoryName($category){
    if ($category === '1'){
        return 'ブログ';
    } elseif ($category == '2'){
        return'日常';
    } else{
        return'その他';
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ一覧</title>
</head>
<body>
    <h2>ブログ一覧</h2>
    <table>
        <tr>
            <th>No</th>
            <th>タイトル</th>
            <th>カテゴリー</th>
        </tr>
        <?php foreach($blogData as $column): ?>
        <td><?php echo $column['id'] ?></td>
        <td><?php echo $column['title'] ?></td>
        <td><?php echo  setCategoryName($column['category'])?></td>
        <td><a href="/detail.php?id=<?php echo $column['id']?>">詳細</a></td>
        <?php endforeach; ?>
    </table>
    
</body>
</html>