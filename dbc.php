<?php

namespace Blog\Dbc;

//1.データベース接続
//引数：なし
//返り値：接続結果を返す
function dbConnect(){
    
    $dsn = $_ENV['DSN'];
    $user = $_ENV['USER'];
    $pass = $_ENV['PASSWORD'];

    try{
        $dbh = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);

    }catch(\PDOException $e){
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
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
    $dbh = null;
}


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


// 引数：$id
// 返り値：$result
function getBlog($id){
    if(empty($id)){
        exit('IDが不正です');
      }
      
      $dbh = dbConnect();
      
      //SQL準備
      $stmt = $dbh->prepare('SELECT * FROM blog Where id = :id');
      $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
      //SQL実行
      $stmt->execute();
      //結果を取得
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      
      if(!$result){
        exit('ブログがありません');
      }

      return $result;
}

// 詳細画面を表示する流れ
//①一覧画面からブログのidを送る
//GETリクエストでidをURLにつけて送る

//②詳細ページでidを受け取る
//PHPの$_GETでidを取得

//③idを元にデータベースから記事を取得
//SELECT文でプレースホルダーを使う

//④詳細ページに表示する
//HTMLにPHPを埋め込んで表示

?>
